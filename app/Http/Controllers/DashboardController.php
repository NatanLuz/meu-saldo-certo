<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $period = Transaction::normalizePeriod($request->string('period')->toString());
        $baseQuery = $request->user()->transactions();

        $customStartDate = null;
        $customEndDate = null;

        if ($period === Transaction::PERIOD_CUSTOM) {
            $customStartDate = $this->parseDate($request->string('start_date')->toString());
            $customEndDate = $this->parseDate($request->string('end_date')->toString());

            if ($customStartDate && $customEndDate && $customStartDate->greaterThan($customEndDate)) {
                [$customStartDate, $customEndDate] = [$customEndDate, $customStartDate];
            }

            if ($customStartDate) {
                $baseQuery->whereDate('date', '>=', $customStartDate->toDateString());
            }

            if ($customEndDate) {
                $baseQuery->whereDate('date', '<=', $customEndDate->toDateString());
            }
        } else {
            $baseQuery->forPeriod($period);
        }

        // Carrega coleção filtrada e usa a Collection para calcular totais
        $filteredTransactions = (clone $baseQuery)->get();

        $incomeTotal = $filteredTransactions->where('type', Transaction::TYPE_INCOME)->sum('amount');
        $expenseTotal = $filteredTransactions->where('type', Transaction::TYPE_EXPENSE)->sum('amount');

        $monthNames = [
            1 => 'Jan',
            2 => 'Fev',
            3 => 'Mar',
            4 => 'Abr',
            5 => 'Mai',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Ago',
            9 => 'Set',
            10 => 'Out',
            11 => 'Nov',
            12 => 'Dez'
        ];

        // Agrupamento dinâmico para o gráfico: quando o periodo for temporal
        // (7 dias, 30 dias, este mes ou personalizado) agrupamos por dia;
        // para 'all' agrupamos por mes.
        $startDate = Transaction::periodStartDate($period);

        if ($period === Transaction::PERIOD_CUSTOM && ($customStartDate || $customEndDate)) {
            $driver = DB::connection()->getDriverName();
            $dayExpression = $driver === 'sqlite'
                ? "date(date)"
                : 'DATE(date)';

            $chartStart = $customStartDate?->copy()->startOfDay();
            $chartEnd = $customEndDate?->copy()->startOfDay() ?? now()->startOfDay();

            if (! $chartStart) {
                $firstDate = (clone $baseQuery)->min('date');
                $chartStart = $firstDate
                    ? Carbon::parse($firstDate)->startOfDay()
                    : $chartEnd->copy();
            }

            $rawRows = (clone $baseQuery)
                ->selectRaw("{$dayExpression} as day_key, type, SUM(amount) as total")
                ->whereBetween('date', [$chartStart->toDateString(), $chartEnd->toDateString()])
                ->groupBy('day_key', 'type')
                ->orderBy('day_key')
                ->get();

            $cursor = $chartStart->copy();
            $days = [];
            while ($cursor->lessThanOrEqualTo($chartEnd)) {
                $days[] = $cursor->toDateString();
                $cursor->addDay();
            }

            $incomeBy = array_fill_keys($days, 0.0);
            $expenseBy = array_fill_keys($days, 0.0);

            foreach ($rawRows as $row) {
                $d = $row->day_key;
                if ($row->type === Transaction::TYPE_INCOME) {
                    $incomeBy[$d] = (float) $row->total;
                    continue;
                }
                $expenseBy[$d] = (float) $row->total;
            }

            $monthlyData = [
                'labels' => array_values(array_map(fn (string $isoDate): string => (string) Carbon::parse($isoDate)->format('d/M'), $days)),
                'income' => array_values(array_map(fn (string $isoDate): float => $incomeBy[$isoDate] ?? 0.0, $days)),
                'expense' => array_values(array_map(fn (string $isoDate): float => $expenseBy[$isoDate] ?? 0.0, $days)),
            ];
        } elseif ($startDate === null) {
            // Agrupar por mês para todo o histórico
            $driver = DB::connection()->getDriverName();
            $monthExpression = $driver === 'sqlite'
                ? "CAST(strftime('%m', date) AS INTEGER)"
                : 'MONTH(date)';

            $rawRows = (clone $baseQuery)
                ->selectRaw("{$monthExpression} as group_key, type, SUM(amount) as total")
                ->groupBy('group_key', 'type')
                ->orderBy('group_key')
                ->get();

            $monthNumbers = range(1, 12);
            $incomeBy = array_fill_keys($monthNumbers, 0.0);
            $expenseBy = array_fill_keys($monthNumbers, 0.0);

            foreach ($rawRows as $row) {
                $m = (int) $row->group_key;
                if ($row->type === Transaction::TYPE_INCOME) {
                    $incomeBy[$m] = (float) $row->total;
                    continue;
                }
                $expenseBy[$m] = (float) $row->total;
            }

            $monthlyData = [
                'labels' => array_values(array_map(fn (int $monthNumber): string => $monthNames[$monthNumber], $monthNumbers)),
                'income' => array_values(array_map(fn (int $monthNumber): float => $incomeBy[$monthNumber] ?? 0.0, $monthNumbers)),
                'expense' => array_values(array_map(fn (int $monthNumber): float => $expenseBy[$monthNumber] ?? 0.0, $monthNumbers)),
            ];
        } else {
            // Agrupar por dia no intervalo [startDate .. today]
            $driver = DB::connection()->getDriverName();
            $dayExpression = $driver === 'sqlite'
                ? "date(date)"
                : 'DATE(date)';

            $rawRows = (clone $baseQuery)
                ->selectRaw("{$dayExpression} as day_key, type, SUM(amount) as total")
                ->whereBetween('date', [$startDate->toDateString(), now()->toDateString()])
                ->groupBy('day_key', 'type')
                ->orderBy('day_key')
                ->get();

            $cursor = $startDate->copy()->startOfDay();
            $end = now()->startOfDay();

            $days = [];
            while ($cursor->lessThanOrEqualTo($end)) {
                $days[] = $cursor->toDateString();
                $cursor->addDay();
            }

            $incomeBy = array_fill_keys($days, 0.0);
            $expenseBy = array_fill_keys($days, 0.0);

            foreach ($rawRows as $row) {
                $d = $row->day_key;
                if ($row->type === Transaction::TYPE_INCOME) {
                    $incomeBy[$d] = (float) $row->total;
                    continue;
                }
                $expenseBy[$d] = (float) $row->total;
            }

            $monthlyData = [
                'labels' => array_values(array_map(fn (string $isoDate): string => (string) \Carbon\Carbon::parse($isoDate)->format('d/M'), $days)),
                'income' => array_values(array_map(fn (string $isoDate): float => $incomeBy[$isoDate] ?? 0.0, $days)),
                'expense' => array_values(array_map(fn (string $isoDate): float => $expenseBy[$isoDate] ?? 0.0, $days)),
            ];
        }

        return view('dashboard', [
            'incomeTotal' => $incomeTotal,
            'expenseTotal' => $expenseTotal,
            'balance' => $incomeTotal - $expenseTotal,
            'selectedPeriod' => $period,
            'periodOptions' => Transaction::periodOptions(),
            'customStartDate' => $customStartDate?->toDateString(),
            'customEndDate' => $customEndDate?->toDateString(),
            'monthlyData' => $monthlyData,
        ]);
    }

    private function parseDate(?string $value): ?Carbon
    {
        if (! $value) {
            return null;
        }

        try {
            return Carbon::parse($value)->startOfDay();
        } catch (\Throwable) {
            return null;
        }
    }
}
