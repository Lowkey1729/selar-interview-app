<?php

namespace App\Services\Traits\KPIS;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

trait UserKPITrait
{
    use GeneralTrait;

    protected function getUsers(array $data): array
    {
        $newData = [];
        $this->setDateIfNotSet($data);
        $this->selectCountBasedOnFilter($data, $newData);
        return $newData;
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

    protected function selectCountBasedOnFilter(array $data, array &$newData)
    {

        if (in_array('allUsers', $data['user_category'])) {
            $newData['allUsers'] = User::query()
                ->countAllUsers($data);
        }


        if (in_array('newSellers', $data['user_category'])) {
            $newData['newSellers'] = User::query()
                ->countNewSellers($data);
        }

        if (in_array('newMerchants', $data['user_category'])) {
            $newData['newMerchants'] = User::query()
                ->countNewMerchants($data);
        }

        if (in_array('uniqueSellers', $data['user_category'])) {
            $newData['uniqueSellers'] = User::query()
                ->countUniqueSellers($data);
        }


    }


}
