<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight dark:text-slate-100">
            Editar Transação
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-lg bg-white p-6 shadow-sm transition-colors duration-200 dark:border dark:border-slate-800 dark:bg-slate-900">
                <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-slate-100">Editar Transação</h3>

                <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="space-y-5">
                    @csrf
                    @method('PATCH')

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Tipo</label>
                        <select id="type" name="type" @class([
                            'mt-1 block w-full rounded-md border bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:outline-none focus:ring-2 dark:bg-slate-950 dark:text-slate-100',
                            'border-gray-300 focus:border-green-500 focus:ring-green-100 dark:border-slate-700 dark:focus:border-green-500 dark:focus:ring-green-900/50' => ! $errors->has('type'),
                            'border-red-300 ring-2 ring-red-100 focus:border-red-400 focus:ring-red-100 dark:border-red-800 dark:ring-red-950' => $errors->has('type'),
                        ]) required aria-invalid="@error('type') true @else false @enderror" aria-describedby="type-error">
                            <option value="income" @selected(old('type', $transaction->type) === 'income')>Receita</option>
                            <option value="expense" @selected(old('type', $transaction->type) === 'expense')>Despesa</option>
                        </select>
                        @error('type')
                            <p id="type-error" class="mt-1 text-sm font-medium text-red-700 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Valor</label>
                        <input id="amount" name="amount" type="number" step="0.01" min="0.01" value="{{ old('amount', $transaction->amount) }}" @class([
                            'mt-1 block w-full rounded-md border bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:outline-none focus:ring-2 placeholder:text-gray-400 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500',
                            'border-gray-300 focus:border-green-500 focus:ring-green-100 dark:border-slate-700 dark:focus:border-green-500 dark:focus:ring-green-900/50' => ! $errors->has('amount'),
                            'border-red-300 ring-2 ring-red-100 focus:border-red-400 focus:ring-red-100 dark:border-red-800 dark:ring-red-950' => $errors->has('amount'),
                        ]) placeholder="Ex: Digite o valor da transação" required aria-invalid="@error('amount') true @else false @enderror" aria-describedby="amount-error">
                        @error('amount')
                            <p id="amount-error" class="mt-1 text-sm font-medium text-red-700 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Data</label>
                        <input id="date" name="date" type="date" value="{{ old('date', optional($transaction->date)->toDateString() ?? now()->toDateString()) }}" @class([
                            'mt-1 block w-full rounded-md border bg-white px-3 py-2 text-sm shadow-sm focus:outline-none focus:ring-2 text-gray-900 dark:bg-slate-950 dark:text-slate-100',
                            'border-gray-300 focus:border-green-500 focus:ring-green-100 dark:border-slate-700 dark:focus:border-green-500 dark:focus:ring-green-900/50' => ! $errors->has('date'),
                            'border-red-300 ring-2 ring-red-100 focus:border-red-400 focus:ring-red-100 dark:border-red-800 dark:ring-red-950' => $errors->has('date'),
                        ]) required aria-invalid="@error('date') true @else false @enderror" aria-describedby="date-error">
                        @error('date')
                            <p id="date-error" class="mt-1 text-sm font-medium text-red-700 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category_name" class="block text-sm font-medium text-gray-700 dark:text-slate-300">Categoria</label>
                        <input id="category_name" name="category_name" type="text" maxlength="80" value="{{ old('category_name', $transaction->category->name) }}" @class([
                            'mt-1 block w-full rounded-md border bg-white px-3 py-2 text-sm text-gray-900 shadow-sm focus:outline-none focus:ring-2 placeholder:text-gray-400 dark:bg-slate-950 dark:text-slate-100 dark:placeholder:text-slate-500',
                            'border-gray-300 focus:border-green-500 focus:ring-green-100 dark:border-slate-700 dark:focus:border-green-500 dark:focus:ring-green-900/50' => ! $errors->has('category_name'),
                            'border-red-300 ring-2 ring-red-100 focus:border-red-400 focus:ring-red-100 dark:border-red-800 dark:ring-red-950' => $errors->has('category_name'),
                        ]) required aria-invalid="@error('category_name') true @else false @enderror" aria-describedby="category-name-error">
                        @error('category_name')
                            <p id="category-name-error" class="mt-1 text-sm font-medium text-red-700 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sticky bottom-0 mt-8 border-t border-gray-200 bg-white/95 pt-4 backdrop-blur transition-colors duration-200 dark:border-slate-700 dark:bg-slate-900/95">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('transactions.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:border-slate-700 dark:bg-slate-950 dark:text-slate-300 dark:hover:bg-slate-800 dark:focus:ring-slate-700">
                            Cancelar
                            </a>

                            <button type="submit" class="inline-flex items-center rounded-md border border-green-700 bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                Salvar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
