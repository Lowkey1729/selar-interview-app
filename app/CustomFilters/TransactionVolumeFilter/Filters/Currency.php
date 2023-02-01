<?php

namespace App\CustomFilters\TransactionVolumeFilter\Filters;

use App\CustomFilters\Filter;
use Illuminate\Database\Eloquent\Builder;

class Currency implements Filter
{

    /**
     * @inheritDoc
     */
    public static function apply(Builder $builder, $value): Builder
    {
        $values = self::elements($value);
        return $builder->whereIn('currency', $values)
            ->groupBy('currency');
    }

    protected static function elements($value): array
    {
        return $value == 'ALL' ? self::currencies() : [$value];
    }

    protected static function currencies(): array
    {
        return [
            'NGN', 'GHS', 'KES', 'USD'
        ];
    }
}
