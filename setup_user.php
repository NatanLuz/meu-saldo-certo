<?php

$dbPath = __DIR__ . '/database/database.sqlite';
$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON');

$email = 'natandaluz01@gmail.com';
$password = 'natan1234';
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$now = date('Y-m-d H:i:s');

$userStmt = $pdo->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
$userStmt->execute([$email]);
$user = $userStmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $pdo->prepare('UPDATE users SET name = ?, password = ?, updated_at = ? WHERE id = ?')
        ->execute(['Natan da Luz', $hashedPassword, $now, $user['id']]);
    $userId = (int) $user['id'];
    echo "Usuario atualizado com sucesso.\n";
} else {
    $pdo->prepare('INSERT INTO users (name, email, password, created_at, updated_at) VALUES (?, ?, ?, ?, ?)')
        ->execute(['Natan da Luz', $email, $hashedPassword, $now, $now]);
    $userId = (int) $pdo->lastInsertId();
    echo "Usuario criado com sucesso.\n";
}

$categories = [
    ['name' => 'Investimento', 'type' => 'income'],
    ['name' => 'Dívidas', 'type' => 'expense'],
    ['name' => 'Uber', 'type' => 'income'],
    ['name' => 'Saque Cx Eletrônico', 'type' => 'income'],
    ['name' => 'Remédios', 'type' => 'expense'],
    ['name' => 'Academia', 'type' => 'income'],
    ['name' => 'Pet', 'type' => 'expense'],
    ['name' => 'Salário', 'type' => 'income'],
];

$categoryIds = [];

foreach ($categories as $category) {
    $categoryStmt = $pdo->prepare('SELECT id FROM categories WHERE user_id = ? AND name = ? AND type = ? LIMIT 1');
    $categoryStmt->execute([$userId, $category['name'], $category['type']]);
    $categoryRow = $categoryStmt->fetch(PDO::FETCH_ASSOC);

    if ($categoryRow) {
        $categoryIds[$category['name']] = (int) $categoryRow['id'];
        continue;
    }

    $pdo->prepare('INSERT INTO categories (user_id, name, type, created_at, updated_at) VALUES (?, ?, ?, ?, ?)')
        ->execute([$userId, $category['name'], $category['type'], $now, $now]);

    $categoryIds[$category['name']] = (int) $pdo->lastInsertId();
}

$transactions = [
    ['date' => '2026-05-04', 'type' => 'income', 'amount' => 500.00, 'category' => 'Investimento'],
    ['date' => '2026-04-28', 'type' => 'expense', 'amount' => 2300.00, 'category' => 'Dívidas'],
    ['date' => '2026-03-15', 'type' => 'income', 'amount' => 200.00, 'category' => 'Uber'],
    ['date' => '2026-01-01', 'type' => 'income', 'amount' => 1000.00, 'category' => 'Saque Cx Eletrônico'],
    ['date' => '2026-04-01', 'type' => 'expense', 'amount' => 350.00, 'category' => 'Remédios'],
    ['date' => '2026-02-10', 'type' => 'income', 'amount' => 150.00, 'category' => 'Academia'],
    ['date' => '2026-05-02', 'type' => 'expense', 'amount' => 250.00, 'category' => 'Pet'],
    ['date' => '2026-05-02', 'type' => 'income', 'amount' => 4000.00, 'category' => 'Salário'],
];

$createdCount = 0;

foreach ($transactions as $transaction) {
    $amount = number_format($transaction['amount'], 2, '.', '');
    $transactionStmt = $pdo->prepare(
        'SELECT id FROM transactions WHERE user_id = ? AND type = ? AND amount = ? AND date = ? AND category_id = ? LIMIT 1'
    );
    $transactionStmt->execute([
        $userId,
        $transaction['type'],
        $amount,
        $transaction['date'],
        $categoryIds[$transaction['category']],
    ]);

    if ($transactionStmt->fetch(PDO::FETCH_ASSOC)) {
        continue;
    }

    $pdo->prepare('INSERT INTO transactions (user_id, type, amount, category_id, date, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?)')
        ->execute([
            $userId,
            $transaction['type'],
            $amount,
            $categoryIds[$transaction['category']],
            $transaction['date'],
            $now,
            $now,
        ]);

    $createdCount++;
}

echo 'Categorias prontas: ' . count($categoryIds) . PHP_EOL;
echo 'Transacoes criadas agora: ' . $createdCount . PHP_EOL;
echo 'Email: ' . $email . PHP_EOL;
echo 'Senha: ' . $password . PHP_EOL;
echo 'Login: http://127.0.0.1:8000/login' . PHP_EOL;
