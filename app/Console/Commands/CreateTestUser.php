<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class CreateTestUser extends Command
{
    protected $signature = 'make:test-user';

    public function handle()
    {
        User::create([
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => bcrypt('12345678'),
        ]);

        $this->info('Test user created!');
    }
}
