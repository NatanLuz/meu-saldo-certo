<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_valid_transaction(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('transactions.store'), [
            'type' => Transaction::TYPE_INCOME,
            'amount' => 1200,
            'date' => now()->toDateString(),
            'category_name' => 'Salary',
        ]);

        $response
            ->assertRedirect(route('transactions.index'))
            ->assertSessionHas('status', 'Transação criada com sucesso.');

        $categoryId = Category::query()
            ->where('user_id', $user->id)
            ->where('name', 'Salary')
            ->where('type', Transaction::TYPE_INCOME)
            ->latest('id')
            ->value('id');

        $this->assertNotNull($categoryId);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'type' => Transaction::TYPE_INCOME,
            'amount' => 1200,
            'category_id' => $categoryId,
        ]);
    }

    public function test_user_cannot_delete_transaction_from_another_user(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();
        $category = Category::query()->create([
            'user_id' => $owner->id,
            'name' => 'Food',
            'type' => Transaction::TYPE_EXPENSE,
        ]);

        $transaction = $owner->transactions()->create([
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 50,
            'category_id' => $category->id,
            'date' => now()->toDateString(),
        ]);

        $this->actingAs($intruder)
            ->delete(route('transactions.destroy', $transaction))
            ->assertForbidden();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'user_id' => $owner->id,
        ]);
    }

    public function test_validation_rejects_amount_less_than_or_equal_to_zero(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->from(route('transactions.index'))->post(route('transactions.store'), [
            'type' => Transaction::TYPE_INCOME,
            'amount' => 0,
            'date' => now()->toDateString(),
            'category_name' => 'Freelance',
        ]);

        $response
            ->assertRedirect(route('transactions.index'))
            ->assertSessionHasErrors(['amount']);

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_validation_rejects_empty_category_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('transactions.index'))
            ->post(route('transactions.store'), [
                'type' => Transaction::TYPE_INCOME,
                'amount' => 100,
                'date' => now()->toDateString(),
                'category_name' => '',
            ]);

        $response
            ->assertRedirect(route('transactions.index'))
            ->assertSessionHasErrors(['category_name']);

        $this->assertDatabaseCount('transactions', 0);
    }

    public function test_user_can_create_transaction_with_free_category_name(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('transactions.store'), [
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 89.90,
            'date' => now()->toDateString(),
            'category_name' => 'Streaming',
        ]);

        $response
            ->assertRedirect(route('transactions.index'))
            ->assertSessionHas('status', 'Transação criada com sucesso.');

        $this->assertDatabaseHas('categories', [
            'user_id' => $user->id,
            'name' => 'Streaming',
            'type' => Transaction::TYPE_EXPENSE,
        ]);

        $categoryId = Category::query()
            ->where('user_id', $user->id)
            ->where('name', 'Streaming')
            ->where('type', Transaction::TYPE_EXPENSE)
            ->value('id');

        $this->assertNotNull($categoryId);

        $this->assertDatabaseHas('transactions', [
            'user_id' => $user->id,
            'type' => Transaction::TYPE_EXPENSE,
            'category_id' => $categoryId,
        ]);
    }

    public function test_user_can_create_duplicate_categories_with_same_name_and_type(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('transactions.store'), [
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 100,
            'date' => now()->toDateString(),
            'category_name' => 'Academia',
        ])->assertRedirect(route('transactions.index'));

        $this->actingAs($user)->post(route('transactions.store'), [
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 120,
            'date' => now()->toDateString(),
            'category_name' => 'Academia',
        ])->assertRedirect(route('transactions.index'));

        $this->assertSame(
            2,
            Category::query()
                ->where('user_id', $user->id)
                ->where('type', Transaction::TYPE_EXPENSE)
                ->where('name', 'Academia')
                ->count()
        );
    }

    public function test_user_can_update_own_transaction(): void
    {
        $user = User::factory()->create();
        $incomeCategory = Category::query()->create([
            'user_id' => $user->id,
            'name' => 'Salario',
            'type' => Transaction::TYPE_INCOME,
        ]);

        $transaction = $user->transactions()->create([
            'type' => Transaction::TYPE_INCOME,
            'amount' => 3000,
            'category_id' => $incomeCategory->id,
            'date' => now()->subDay()->toDateString(),
        ]);

        $response = $this->actingAs($user)->patch(route('transactions.update', $transaction), [
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 120,
            'date' => now()->toDateString(),
            'category_name' => 'Lazer',
        ]);

        $response
            ->assertRedirect(route('transactions.index'))
            ->assertSessionHas('status', 'Transação atualizada com sucesso.');

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'user_id' => $user->id,
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 120,
        ]);

        $this->assertDatabaseHas('categories', [
            'user_id' => $user->id,
            'name' => 'Lazer',
            'type' => Transaction::TYPE_EXPENSE,
        ]);
    }

    public function test_user_cannot_update_transaction_from_another_user(): void
    {
        $owner = User::factory()->create();
        $intruder = User::factory()->create();

        $ownerCategory = Category::query()->create([
            'user_id' => $owner->id,
            'name' => 'Moradia',
            'type' => Transaction::TYPE_EXPENSE,
        ]);

        $transaction = $owner->transactions()->create([
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 450,
            'category_id' => $ownerCategory->id,
            'date' => now()->subDay()->toDateString(),
        ]);

        $this->actingAs($intruder)
            ->patch(route('transactions.update', $transaction), [
                'type' => Transaction::TYPE_EXPENSE,
                'amount' => 999,
                'date' => now()->toDateString(),
                'category_name' => 'Viagem',
            ])
            ->assertForbidden();

        $this->assertDatabaseHas('transactions', [
            'id' => $transaction->id,
            'user_id' => $owner->id,
            'amount' => 450,
            'category_id' => $ownerCategory->id,
        ]);
    }

    public function test_transactions_index_applies_period_filter(): void
    {
        $user = User::factory()->create();

        $category = Category::query()->create([
            'user_id' => $user->id,
            'name' => 'Mercado',
            'type' => Transaction::TYPE_EXPENSE,
        ]);

        $recentTransaction = $user->transactions()->create([
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 120,
            'category_id' => $category->id,
            'date' => now()->subDays(2)->toDateString(),
        ]);

        $oldTransaction = $user->transactions()->create([
            'type' => Transaction::TYPE_EXPENSE,
            'amount' => 300,
            'category_id' => $category->id,
            'date' => now()->subDays(40)->toDateString(),
        ]);

        $response = $this->actingAs($user)->get(route('transactions.index', ['period' => Transaction::PERIOD_7_DAYS]));

        $response
            ->assertOk()
            ->assertViewHas('selectedPeriod', Transaction::PERIOD_7_DAYS)
            ->assertViewHas('transactions', function ($paginator) use ($recentTransaction, $oldTransaction) {
                $ids = $paginator->getCollection()->pluck('id');

                return $ids->contains($recentTransaction->id) && ! $ids->contains($oldTransaction->id);
            });
    }
}
