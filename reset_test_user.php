<?php
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/bootstrap/app.php';

use App\Models\User;

$user = User::where('email', 'test@example.com')->first();
if ($user) {
    $user->password = bcrypt('password');
    $user->save();
    echo "Usuário resetado!\n";
} else {
    echo "Usuário não encontrado!\n";
}