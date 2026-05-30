<?php

namespace App\Helpers;

class PaymentCodeHelper
{
    /**
     * Generate unique payment code for cash payment
     * Format: PAY-YYYYMMDD-XXXXXXXX (8 random characters of digits and capital letters)
     */
    public static function generate(): string
    {
        $date = date('Ymd');
        $random = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        return "PAY-{$date}-{$random}";
    }

    /**
     * Check if payment method name matches cash/tunai
     */
    public static function isCash(string $paymentMethodName): bool
    {
        $cashKeywords = ['tunai', 'cash'];
        $lowerName = strtolower($paymentMethodName);
        foreach ($cashKeywords as $keyword) {
            if (str_contains($lowerName, $keyword)) {
                return true;
            }
        }
        return false;
    }
}
