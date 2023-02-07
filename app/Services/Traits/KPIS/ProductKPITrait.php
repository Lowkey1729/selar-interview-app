<?php

namespace App\Services\Traits\KPIS;

use App\Product;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

trait ProductKPITrait
{
    use GeneralTrait;

    /**
     * @param array $data
     * @return Builder|Model|mixed|object|null
     */
    protected function getProducts(array $data)
    {
        $this->setDateIfNotSet($data);
        $to = $data['date']['to'];
        $from = $data['date']['from'];
        $dateType = $data['date']['dateType'];


        $totalNewProducts = Product::query()
            ->selectRaw('COUNT(id) as total_new_products')
            ->filterDateQuery($from, $to, $dateType, 'created_at')
            ->first();
        $data['totalNewProducts'] = $totalNewProducts['total_new_products'];
        $data['totalProducts'] = Product::query()->count();
        return $data;
    }

    /**
     * @return string[]
     */
    protected function validationMessages(): array
    {
        return [
            'after_or_equal' => "You need to select a date equal or after the 'View From' date",
            'date.from.required_with' => "The 'View From' date is also required since you selected 'View To' date",
            'date.to.required_with' => "The 'View To' date is also required  since you selected 'View From' date",
        ];
    }

    /**
     * A list of the accepted rules for validation
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'date.from' => ['nullable', 'date', 'required_with:date.to'],
            'date.to' => ['nullable', 'date', 'after_or_equal:date.from', 'required_with:date.from']
        ];
    }

}
