<?php

declare(strict_types=1);

/**
 * Fetches banks from BrasilAPI.
 *
 * @return array<int, array<string, mixed>>
 */
function fetchBanks(): array
{
    $url = 'https://brasilapi.com.br/api/banks/v1';

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
        ],
    ]);

    $response = curl_exec($ch);
    $curlError = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($response === false) {
        throw new RuntimeException('Erro na requisicao cURL: ' . $curlError);
    }

    if ($httpCode < 200 || $httpCode >= 300) {
        throw new RuntimeException('A API retornou erro HTTP: ' . $httpCode);
    }

    $data = json_decode($response, true);

    if (!is_array($data) || json_last_error() !== JSON_ERROR_NONE) {
        throw new RuntimeException('Resposta invalida (nao JSON): ' . json_last_error_msg());
    }

    return $data;
}

/**
 * @param array<int, array<string, mixed>> $banks
 * @return array<int, array<string, mixed>>
 */
function filterBanks(array $banks, string $query): array
{
    return array_values(array_filter($banks, static function (array $bank) use ($query): bool {
        if ($query === '') {
            return true;
        }

        $name = (string) ($bank['name'] ?? '');
        $code = (string) ($bank['code'] ?? '');
        $ispb = (string) ($bank['ispb'] ?? '');

        $stack = strtolower($name . ' ' . $code . ' ' . $ispb);
        return str_contains($stack, strtolower($query));
    }));
}

/**
 * @param array<int, array<string, mixed>> $banks
 * @return array<string, mixed>|null
 */
function findBankByCode(array $banks, string $code): ?array
{
    if ($code === '') {
        return null;
    }

    foreach ($banks as $bank) {
        if ((string) ($bank['code'] ?? '') === $code) {
            return $bank;
        }
    }

    return null;
}
