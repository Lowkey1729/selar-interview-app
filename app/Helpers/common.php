<?php

if (!function_exists('currencyTitle')) {
    function currencyTitle(string $currency): string
    {
        switch ($currency) {
            case "NGN":
                return 'Naira(NGN)';
            case "GHS":
                return "CEDIS(GHS)";
            case "KES":
                return "Kenya Shillings(KES)";
            case "USD":
                return "US Dollars(USD)";
            default:
                return "No Title set";
        }
    }
}

if (!function_exists('rawSQLDateFormat')) {
    function rawSQLDateFormat(string $dateType, string $column = 'created_at'): string
    {
        switch ($dateType) {
            case "week":
                return "WEEK({$column})";
            case "month":
                return "MONTH({$column})";
            case "year":
                return "YEAR({$column})";
            default:
                return "DATE({$column})";


        }
    }
}
