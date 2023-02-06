<?php

namespace App\CustomFilters\TransactionVolumeFilter\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Date implements \App\CustomFilters\Filter
{

    /**
     * @inheritDoc
     */
    public static function apply(Builder $builder, $value): Builder
    {
        $rawSQLDate = rawSQLDateFormat($value['dateType'], 'transaction_date');
        return $value['dateType'] == 'days' ? $builder->whereBetween(DB::raw($rawSQLDate), [$value['from'], $value['to']])
            : $builder->whereRaw($rawSQLDate . " = ? AND YEAR(transaction_date) = ?", [$value['from'], date('Y')]);
    }
}
