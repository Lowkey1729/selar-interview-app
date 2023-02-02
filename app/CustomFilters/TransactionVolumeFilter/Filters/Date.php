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
        return $builder->whereBetween(DB::raw('DATE(created_at)'), [$value['from'], $value['to']]);
    }
}
