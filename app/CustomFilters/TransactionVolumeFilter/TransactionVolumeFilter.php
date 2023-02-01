<?php

namespace App\CustomFilters\TransactionVolumeFilter;

use App\Models\Product;
use App\Purchase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class TransactionVolumeFilter
{
    public static function apply(array $filters)
    {
        $query = static::applyDecoratorFromRequest($filters, (new Purchase())->newQuery());
        return static::getResults($query);
    }

    private static function getResults(Builder $query)
    {
        return $query
            ->selectRaw('currency, SUM(selar_profit) as profits, COUNT(id) as total_amount_of_sales')
            ->get();
    }

    private static function applyDecoratorFromRequest(array $filters, Builder $query): Builder
    {
        foreach ($filters as $filterName => $value) {
            $decorator = static::createFilterDecorator($filterName);
            if (static::isValidDecorator($decorator)) {
                $query = $decorator::apply($query, $value);
            }

        }

        return $query;
    }

    private static function createFilterDecorator($filterName): string
    {
        return __NAMESPACE__ . '\\Filters\\' . Str::studly($filterName);
    }

    private static function isValidDecorator(string $decorator): bool
    {
        return class_exists($decorator);
    }
}
