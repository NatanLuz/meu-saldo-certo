<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Popula categorias padrao para cada usuario existente.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Salario', 'type' => 'income'],
            ['name' => 'Freelance', 'type' => 'income'],
            ['name' => 'Investimentos', 'type' => 'income'],
            ['name' => 'Alimentacao', 'type' => 'expense'],
            ['name' => 'Transporte', 'type' => 'expense'],
            ['name' => 'Moradia', 'type' => 'expense'],
        ];

        User::query()->each(function (User $user) use ($categories): void {
            foreach ($categories as $category) {
                Category::query()->firstOrCreate([
                    'user_id' => $user->id,
                    'name' => $category['name'],
                    'type' => $category['type'],
                ]);
            }
        });
    }
}
