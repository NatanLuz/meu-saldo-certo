<?php

namespace App\Models;

use Carbon\Carbon;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public const TYPE_INCOME = 'income';
    public const TYPE_EXPENSE = 'expense';

    public const PERIOD_7_DAYS = '7days';
    public const PERIOD_30_DAYS = '30days';
    public const PERIOD_THIS_MONTH = 'this_month';
    public const PERIOD_ALL = 'all';
    public const PERIOD_CUSTOM = 'custom';

    protected $fillable = [
        'type',
        'amount',
        'category_id',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'date' => 'date',
        ];
    }

    protected static function booted(): void
    {
        // A integridade do valor e reforcada no model para evitar que insercoes
        // por outros fluxos escapem da validacao aplicada no formulario.
        static::saving(function (Transaction $transaction): void {
            if ((float) $transaction->amount <= 0) {
                throw new InvalidArgumentException('Amount must be greater than zero.');
            }
        });
    }

    /**
     * @return array<string, string>
     */
    public static function periodOptions(): array
    {
        return [
            self::PERIOD_7_DAYS => 'Ultimos 7 dias',
            self::PERIOD_30_DAYS => 'Ultimos 30 dias',
            self::PERIOD_THIS_MONTH => 'Este mes',
            self::PERIOD_ALL => 'Todos',
            self::PERIOD_CUSTOM => 'Personalizado',
        ];
    }

    public static function normalizePeriod(?string $period): string
    {
        $period = $period ?: self::PERIOD_ALL;

        // Qualquer valor fora da lista cai em "all" para impedir filtros
        // arbitrarios na query string e manter a tela previsivel.
        return array_key_exists($period, self::periodOptions())
            ? $period
            : self::PERIOD_ALL;
    }

    public static function periodStartDate(string $period): ?Carbon
    {
        return match ($period) {
            self::PERIOD_7_DAYS => now()->subDays(7),
            self::PERIOD_30_DAYS => now()->subDays(30),
            self::PERIOD_THIS_MONTH => now()->startOfMonth(),
            default => null,
        };
    }

    public function scopeForPeriod(Builder $query, string $period): Builder
    {
        // O escopo encapsula a regra de janela temporal para a listagem,
        // evitando repetir datas relativas em controller e relatorios.
        return match ($period) {
            self::PERIOD_7_DAYS => $query->where('date', '>=', self::periodStartDate(self::PERIOD_7_DAYS)),
            self::PERIOD_30_DAYS => $query->where('date', '>=', self::periodStartDate(self::PERIOD_30_DAYS)),
            self::PERIOD_THIS_MONTH => $query->where('date', '>=', self::periodStartDate(self::PERIOD_THIS_MONTH)),
            default => $query,
        };
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}