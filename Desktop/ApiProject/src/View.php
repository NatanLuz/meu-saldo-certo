<?php

declare(strict_types=1);

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function asString(mixed $value, string $fallback = '-'): string
{
    $text = trim((string) ($value ?? ''));
    return $text === '' ? $fallback : $text;
}