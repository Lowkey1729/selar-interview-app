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
        return $builder->whereBetween(DB::raw($rawSQLDate), [$value['from'], $value['to']]);
    }
}
