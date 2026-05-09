<?php

declare(strict_types=1);

require_once __DIR__ . '/src/BankService.php';
require_once __DIR__ . '/src/View.php';

function respondJson(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    exit;
}

$query = trim((string) ($_GET['q'] ?? ''));
$code = trim((string) ($_GET['code'] ?? ''));
$format = strtolower(trim((string) ($_GET['format'] ?? 'html')));

try {
    $banks = fetchBanks();
} catch (RuntimeException $exception) {
    if ($format === 'json') {
        respondJson(['error' => $exception->getMessage()], 500);
    }

    http_response_code(500);
    header('Content-Type: text/html; charset=utf-8');
    echo '<h1>Erro ao carregar API</h1><p>' . e($exception->getMessage()) . '</p>';
    exit;
}

$filteredBanks = filterBanks($banks, $query);
$selectedBank = findBankByCode($banks, $code);

if ($format === 'json') {
    if ($code !== '') {
        if ($selectedBank === null) {
            respondJson([
                'error' => 'Banco nao encontrado para o codigo informado.',
                'code' => $code,
            ], 404);
        }

        respondJson($selectedBank);
    }

    respondJson([
        'total' => count($filteredBanks),
        'query' => $query,
        'data' => $filteredBanks,
    ]);
}

header('Content-Type: text/html; charset=utf-8');
?>
<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consulta de Bancos - BrasilAPI</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>
<body>
    <main class="page">
        <section class="panel">
            <header class="panel-head">
                <h1>Consulta de Bancos</h1>
                <p>Exploracao de API com listagem, busca e detalhe por codigo.</p>
            </header>

            <div class="panel-body">
                <div class="toolbar">
                    <form class="search" method="get">
                        <input
                            type="text"
                            name="q"
                            placeholder="Buscar por nome, codigo ou ISPB"
                            value="<?= e($query) ?>"
                        >
                        <button type="submit">Buscar</button>
                    </form>
                </div>

                <div class="meta">
                    Total encontrado: <strong><?= count($filteredBanks) ?></strong>
                    | <a href="?q=<?= urlencode($query) ?>&format=json">Abrir JSON</a>
                </div>

                <?php if ($code !== ''): ?>
                    <?php if ($selectedBank === null): ?>
                        <div class="notice warn">
                            Codigo <strong><?= e($code) ?></strong> nao encontrado.
                        </div>
                    <?php else: ?>
                        <section class="detail">
                            <h2>Detalhe do Banco</h2>
                            <div class="detail-grid">
                                <div class="detail-item">
                                    <span class="label">Codigo</span>
                                    <span class="value"><?= e(asString($selectedBank['code'] ?? null)) ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Nome</span>
                                    <span class="value"><?= e(asString($selectedBank['name'] ?? null)) ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">ISPB</span>
                                    <span class="value"><?= e(asString($selectedBank['ispb'] ?? null)) ?></span>
                                </div>
                                <div class="detail-item">
                                    <span class="label">Nome Completo</span>
                                    <span class="value"><?= e(asString($selectedBank['fullName'] ?? null)) ?></span>
                                </div>
                            </div>
                            <p class="footer">
                                <a href="?q=<?= urlencode($query) ?>">Voltar para listagem</a>
                                | <a href="?code=<?= urlencode($code) ?>&format=json">Ver detalhe em JSON</a>
                            </p>
                        </section>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (count($filteredBanks) === 0): ?>
                    <div class="notice">Nenhum banco encontrado para essa busca.</div>
                <?php else: ?>
                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>Codigo</th>
                                    <th>Nome</th>
                                    <th>ISPB</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($filteredBanks as $bank): ?>
                                    <?php $bankCode = asString($bank['code'] ?? null); ?>
                                    <tr>
                                        <td>
                                            <?php if ($bankCode !== '-'): ?>
                                                <a class="code-pill" href="?code=<?= urlencode($bankCode) ?>&q=<?= urlencode($query) ?>">
                                                    <?= e($bankCode) ?>
                                                </a>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td><?= e(asString($bank['name'] ?? null)) ?></td>
                                        <td><?= e(asString($bank['ispb'] ?? null)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <p class="footer">
                    Dica: use <a href="?format=json">?format=json</a> para retornar a API em JSON.
                </p>
            </div>
        </section>
    </main>
</body>
</html>