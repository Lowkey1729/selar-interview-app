<?php

namespace App\Services\Traits\KPIS;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

trait UserKPITrait
{
    use GeneralTrait;

    /**
     * @param array $data
     * @return array
     */
    protected function getUsers(array $data): array
    {
        $newData = [];
        $this->setDateIfNotSet($data);
        $this->selectCategoryCountBasedOnFilter($data, $newData);
        return $newData;
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
        $userCategories = array_keys($this->userCategories());
        return [
            'user_category.*' => ['required', Rule::in($userCategories)],
            'date.from' => ['nullable', 'date', 'required_with:date.to'],
            'date.to' => ['nullable', 'date', 'after_or_equal:date.from', 'required_with:date.from']
        ];
    }

    /**
     * @return string[]
     */
    protected function userCategories(): array
    {
        return [
            'newUsers' => 'New Users',
            'uniqueSellers' => 'Unique Sellers',
            'newSellers' => 'New Sellers',
            'newMerchants' => 'New Merchants'];

    }

    /**
     * @param array $data
     * @return array
     */
    protected function getRequestData(array $data): array
    {

        if ($this->userCategoryWasNotSet($data)) {
            $data['user_category'][0] = 'allUsers';
        }

        return $data;
    }

    /**
     * @param array $data
     * @return bool
     */
    protected function userCategoryWasNotSet(array $data): bool
    {
        return !array_key_exists('user_category', $data);
    }

    /**
     * @param array $data
     * @param array $newData
     * @return void
     */
    protected function selectCategoryCountBasedOnFilter(array $data, array &$newData)
    {
        $newData['totalUsers'] = User::query()->count();

        if (in_array('newUsers', $data['user_category'])) {
            $newData['newUsers'] = User::query()
                ->countNewUsers($data);
        }

        if (in_array('uniqueSellers', $data['user_category'])) {
            $newData['uniqueSellers'] = User::query()
                ->countUniqueSellers($data);
        }


        if (in_array('newSellers', $data['user_category'])) {
            $newData['newSellers'] = User::query()
                ->countNewSellers($data);
        }

        if (in_array('newMerchants', $data['user_category'])) {
            $newData['newMerchants'] = User::query()
                ->countNewMerchants($data);
        }



    }


}
