<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Transaction::class);

        $user = $request->user();
        // O periodo e normalizado no model para impedir filtros invalidos na URL
        // e manter o mesmo comportamento independentemente do estado do frontend.
        $period = Transaction::normalizePeriod($request->string('period')->toString());
        $baseQuery = $user->transactions()->forPeriod($period);

        $transactions = (clone $baseQuery)
            ->with('category')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', [
            'transactions' => $transactions,
            'selectedPeriod' => $period,
            'periodOptions' => Transaction::periodOptions(),
        ]);
    }

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        $this->authorize('create', Transaction::class);

        $data = $request->validated();
        $user = $request->user();

        // A categoria e criada por transacao para preservar historico por usuario
        // e permitir nomes repetidos entre contas diferentes sem acoplamento global.
        $category = Category::query()->create([
            'user_id' => $user->id,
            'name' => $data['category_name'],
            'type' => $data['type'],
        ]);

        $user->transactions()->create([
            'type' => $data['type'],
            'amount' => $data['amount'],
            'date' => $data['date'],
            'category_id' => $category->id,
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('status', 'Transação criada com sucesso.');
    }

    public function edit(Request $request, Transaction $transaction): View
    {
        $this->authorize('update', $transaction);

        return view('transactions.edit', [
            'transaction' => $transaction,
        ]);
    }

    public function update(StoreTransactionRequest $request, Transaction $transaction): RedirectResponse
    {
        $this->authorize('update', $transaction);

        $data = $request->validated();
        // Mantemos a mesma estrategia de criacao de categoria para evitar
        // depender de estados anteriores e simplificar a atualizacao do lancamento.
        $category = Category::query()->create([
            'user_id' => $request->user()->id,
            'name' => $data['category_name'],
            'type' => $data['type'],
        ]);

        $transaction->update([
            'type' => $data['type'],
            'amount' => $data['amount'],
            'date' => $data['date'],
            'category_id' => $category->id,
        ]);

        return redirect()
            ->route('transactions.index')
            ->with('status', 'Transação atualizada com sucesso.');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->with('status', 'Transação excluída com sucesso.');
    }
}
