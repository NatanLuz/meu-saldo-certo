<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    /**
     * Determina se o usuario pode visualizar qualquer modelo.
     * O sistema nao possui perfis administrativos aqui; qualquer usuario
     * autenticado pode acessar somente seu proprio conjunto de transacoes.
     */
    public function viewAny(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Determina se o usuario pode visualizar o modelo.
     */
    public function view(User $user, Transaction $transaction): bool
    {
        return $transaction->user_id === $user->id;
    }

    /**
     * Determina se o usuario pode criar modelos.
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Determina se o usuario pode atualizar o modelo.
     */
    public function update(User $user, Transaction $transaction): bool
    {
        return $transaction->user_id === $user->id;
    }

    /**
     * Determina se o usuario pode excluir o modelo.
     */
    public function delete(User $user, Transaction $transaction): bool
    {
        return $transaction->user_id === $user->id;
    }

    /**
     * Determina se o usuario pode restaurar o modelo.
     */
    public function restore(User $user, Transaction $transaction): bool
    {
        return false;
    }

    /**
     * Determina se o usuario pode excluir permanentemente o modelo.
     */
    public function forceDelete(User $user, Transaction $transaction): bool
    {
        return false;
    }
}
