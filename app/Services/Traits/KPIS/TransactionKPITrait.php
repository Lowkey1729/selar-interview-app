<?php

namespace App\Services\Traits\KPIS;

use App\CustomFilters\TransactionVolumeFilter\TransactionVolumeFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;

trait TransactionKPITrait
{
    use GeneralTrait;

    /**
     * A list of the accepted rules for validation
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'currency.*' => ['required', Rule::in($this->currenciesOption())],
            'date.from' => ['nullable', 'date', 'required_with:date.to'],
            'date.to' => ['nullable', 'date', 'after_or_equal:date.from', 'required_with:date.from']
        ];
    }

    /**
     * A list of the accepted rules
     * @param array $data
     * @return Builder[]|Collection
     */
    protected function getTransactions(array $data)
    {
        $this->setDateIfNotSet($data);
        return TransactionVolumeFilter::apply(array_filter($data));
    }

    protected function getRequestData(array $data): array
    {

        if ($this->currencyWasNotSelected($data)) {
            $data['currency'][0] = 'ALL';
        }

        return $data;
    }

    /**
     * @return string[]
     */
    protected function currenciesOption(): array
    {
        return [
            'NGN',
            'GHS',
            'KES',
            'USD',
            'ALL'];
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

    protected function currencyWasNotSelected(array $data): bool
    {
        return !array_key_exists('currency', $data);
    }
}
