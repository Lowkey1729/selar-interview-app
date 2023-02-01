<?php

namespace App\CustomFilters\TransactionVolumeFilter\Filters;

use Illuminate\Database\Eloquent\Builder;

class Date implements \App\CustomFilters\Filter
{

    /**
     * @inheritDoc
     */
    public static function apply(Builder $builder, $value): Builder
    {
        // TODO: Implement apply() method.
    }
}
