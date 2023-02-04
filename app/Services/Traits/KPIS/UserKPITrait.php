<?php

namespace App\Services\Traits\KPIS;

use App\User;
use Illuminate\Validation\Rule;

trait UserKPITrait
{
    protected function getUsers(array $data): int
    {
        return User::query()
            ->selectRaw("COUNT(id) as allUsers")
            ->countUniqueSellers($data)
            ->countNewSellers($data)
            ->countNewMerchants($data)
            ->get();
    }

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
            'user_category' => ['required', Rule::in($this->userCategories())],
            'date.from' => ['nullable', 'date', 'required_with:date.to'],
            'date.to' => ['nullable', 'date', 'after_or_equal:date.from', 'required_with:date.from']
        ];
    }

    protected function userCategories(): array
    {
        return ['allUsers', 'uniqueSellers', 'newSellers', 'newMerchants'];

    }

    protected function getRequestData(array $data): array
    {

        if ($this->userCategoryWasNotSet($data)) {
            $data['user_category'] = 'allUsers';
        }

        return $data;
    }

    protected function userCategoryWasNotSet(array $data): bool
    {
        return !array_key_exists('user_category', $data);
    }
}
