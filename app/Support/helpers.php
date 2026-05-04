<?php

if (! function_exists('formatCurrency')) {
    function formatCurrency(float|int|string|null $value): string
    {
        $amount = (float) ($value ?? 0);

        return 'R$ '.number_format($amount, 2, ',', '.');
    }
}
