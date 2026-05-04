<?php

namespace App\Http\Requests;

use App\Models\Transaction;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        // Normaliza o nome da categoria antes da validacao para evitar duplicatas
        // geradas apenas por espacos excedentes ou input inconsistente.
        if (is_string($this->input('category_name'))) {
            $this->merge(['category_name' => trim($this->string('category_name')->toString())]);
        }
    }

    /**
     * Determina se o usuario esta autorizado a fazer esta requisicao.
     * O controller assume contexto de usuario autenticado porque a transacao e
     * sempre vinculada ao owner da sessao.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
        * Retorna as regras de validacao aplicadas a requisicao.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => ['required', Rule::in([Transaction::TYPE_INCOME, Transaction::TYPE_EXPENSE])],
            'amount' => ['required', 'numeric', 'gt:0'],
            'date' => ['required', 'date'],
            'category_name' => ['required', 'string', 'max:80'],
        ];
    }
}
