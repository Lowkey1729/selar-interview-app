<?php

namespace App\Services\Traits\KPIS;

use App\User;
use Illuminate\Validation\Rule;

trait UserKPITrait
{
    use GeneralTrait;

    protected function getUsers(array $data)
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
        $userCategories = array_keys($this->userCategories());
        return [
            'user_category.*' => ['required', Rule::in($userCategories)],
            'date.from' => ['nullable', 'date', 'required_with:date.to'],
            'date.to' => ['nullable', 'date', 'after_or_equal:date.from', 'required_with:date.from']
        ];
    }

    protected function userCategories(): array
    {
        return [
            'allUsers' => 'All Users',
            'uniqueSellers' => 'Unique Sellers',
            'newSellers' => 'New Sellers',
            'newMerchants' => 'New Merchants'];

    }

    protected function getRequestData(array $data): array
    {

        if ($this->userCategoryWasNotSet($data)) {
            $data['user_category'][0] = 'allUsers';
        }

        return $data;
    }

    protected function userCategoryWasNotSet(array $data): bool
    {
        return !array_key_exists('user_category', $data);
    }




}
