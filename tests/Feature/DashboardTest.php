<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_applies_period_filter_to_totals(): void
    {
        $user = User::factory()->create();

        $incomeCategory = Category::query()->create([
            'user_id' => $user->id,
            'name' => 'Salario',
            'type' => Transaction::TYPE_INCOME,
        ]);

        $expenseCategory = Category::query()->create([
            'user_id' => $user->id,
            'name' => 'Mercado',
            'type' => Transaction::TYPE_EXPENSE,
        ]);

        $recentIncome = $user->transactions()->create([
            'type' => Transaction::TYPE_INCOME,
            'amount' => 1000,
            'category_id' => $incomeCategory->id,
            'date' => now()->subDays(2)->toDateString(),
        ]);

        $recentExpense = $user->transactions()->create([
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 200,
            'category_id' => $expenseCategory->id,
            'date' => now()->subDays(3)->toDateString(),
        ]);

        $oldIncome = $user->transactions()->create([
            'type' => Transaction::TYPE_INCOME,
            'amount' => 900,
            'category_id' => $incomeCategory->id,
            'date' => now()->subDays(45)->toDateString(),
        ]);

        $response = $this->actingAs($user)->get(route('dashboard', ['period' => Transaction::PERIOD_7_DAYS]));

        $response
            ->assertOk()
            ->assertViewHas('incomeTotal', '1000.00')
            ->assertViewHas('expenseTotal', '200.00')
            ->assertViewHas('balance', 800.0)
            ->assertViewHas('selectedPeriod', Transaction::PERIOD_7_DAYS);
    }

    public function test_dashboard_monthly_data_contains_ordered_months_and_zero_fill(): void
    {
        $user = User::factory()->create();

        $incomeCategory = Category::query()->create([
            'user_id' => $user->id,
            'name' => 'Salario',
            'type' => Transaction::TYPE_INCOME,
        ]);

        $expenseCategory = Category::query()->create([
            'user_id' => $user->id,
            'name' => 'Mercado',
            'type' => Transaction::TYPE_EXPENSE,
        ]);

        $incomeTransaction = $user->transactions()->create([
            'type' => Transaction::TYPE_INCOME,
            'amount' => 1500,
            'category_id' => $incomeCategory->id,
            'date' => now()->setDate((int) now()->year, 1, 15)->toDateString(),
        ]);

        $expenseTransaction = $user->transactions()->create([
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 300,
            'category_id' => $expenseCategory->id,
            'date' => now()->setDate((int) now()->year, 3, 15)->toDateString(),
        ]);

        $response = $this->actingAs($user)->get(route('dashboard', ['period' => Transaction::PERIOD_ALL]));

        $response
            ->assertOk()
            ->assertViewHas('monthlyData', function (array $monthlyData) {
                if (! isset($monthlyData['labels'], $monthlyData['income'], $monthlyData['expense'])) {
                    return false;
                }

                $count = count($monthlyData['labels']);

                if ($count !== count($monthlyData['income']) || $count !== count($monthlyData['expense'])) {
                    return false;
                }

                if ($count !== 12) {
                    return false;
                }

                if (($monthlyData['labels'][0] ?? null) !== 'Jan' || ($monthlyData['labels'][2] ?? null) !== 'Mar') {
                    return false;
                }

                if ((float) ($monthlyData['income'][0] ?? -1) !== 1500.0) {
                    return false;
                }

                if ((float) ($monthlyData['expense'][2] ?? -1) !== 300.0) {
                    return false;
                }

                return (float) ($monthlyData['income'][1] ?? -1) === 0.0
                    && (float) ($monthlyData['expense'][1] ?? -1) === 0.0;
            });
    }
}
