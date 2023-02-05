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

if (!function_exists('userCategoryTitle')) {
    function userCategoryTitle(string $userCategory): string
    {
        switch ($userCategory) {
            case "allUsers":
                return 'All Users';
            case "newMerchants":
                return "New Merchants";
            case "newSellers":
                return "New Sellers";
            case "uniqueSellers":
                return "Unique Sellers";
            default:
                return "No Title set";
        }
    }
}

if (!function_exists('pickDate')) {
    function pickDate($dateType)
    {
        switch ($dateType) {
            case "week":
                return date('w');
            case "month":
                return date('m');
            case "year":
                return date('y');
            default:
                return date('Y-m-d');


        }
    }
}
