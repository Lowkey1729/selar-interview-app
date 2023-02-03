<?php

if (!function_exists('currencyTitle')) {
    function currencyTitle(string $currency): string
    {
        switch ($currency) {
            case "NGN":
                return 'Naira(NGN)';
            case "GHS":
                return  "CEDIS(GHS)";
            case "KES":
               return "Kenya Shillings(KES)";
            case "USD":
                return "US Dollars(USD)";
            default:
                return "No Title set";
        }
    }
}
