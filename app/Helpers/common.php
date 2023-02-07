<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

if (!function_exists('currencyTitle')) {
    /**
     * @param string $currency
     * @return string
     */
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
    /**
     * @param string $dateType
     * @param string $column
     * @return string
     */
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
    /**
     * @param string $userCategory
     * @return string
     */
    function userCategoryTitle(string $userCategory): string
    {
        switch ($userCategory) {
            case "totalUsers":
                return "Total Users";
            case "newUsers":
                return 'New Users';
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
    /**
     * @param $dateType
     * @return false|string
     */
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

if (!function_exists('averageNairaValue')) {
    /**
     * @param $transactions
     * @return float
     */
    function averageNairaValue($transactions): float
    {
        try {
            $totalSales = 0;
            $totalProfits = 0;
            foreach ($transactions as $transaction) {
                switch ($transaction['currency']) {
                    case 'NGN' :
                        $totalSales = $transaction['total_amount_of_sales'];
                        $totalProfits = $transaction['profits'];
                        break;
                    case 'USD' :
                        $convert = new \App\ExternalAPIs\CurrencyConverters\ConvertAPI();
                        $totalSales = $transaction['total_amount_of_sales'];
                        $totalProfits = $convert->convertCurrency($transaction['profits'], 'USD', 'NGN')['result'];
                        break;
                    case 'KES' :
                        $convert = new \App\ExternalAPIs\CurrencyConverters\ConvertAPI();
                        $totalSales = $transaction['total_amount_of_sales'];
                        $totalProfits = $convert->convertCurrency($transaction['profits'], 'KES', 'NGN')['result'];
                        break;
                    case 'GHS' :
                        $convert = new \App\ExternalAPIs\CurrencyConverters\ConvertAPI();
                        $totalSales = $transaction['total_amount_of_sales'];
                        $totalProfits = $convert->convertCurrency($transaction['profits'], 'GHS', 'NGN')['result'];
                        break;
                    default:
                        $totalSales = 0;
                        $totalProfits = 0;
                }
            }
            return (float)$totalProfits / $totalSales;
        } catch (Exception $exception) {
            return 0;
        }


    }
}
