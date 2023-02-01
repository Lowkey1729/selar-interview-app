<?php

namespace App\Http\Controllers\KPIs;

use App\CustomFilters\TransactionVolumeFilter\TransactionVolumeFilter;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransactionKPIController extends Controller
{
    /**
     * total amount of sales made in each currency and
     * how much profit we made - this is gotten from the `
     * @param Request $request
     * @return RedirectResponse
     */
    public function transactionVolume(Request $request): \Illuminate\Http\RedirectResponse
    {

        //validate
        $validator = Validator::make($request->all(), $this->validationRules());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())
                ->withInput();
        }
        try {
            $results = $this->getTransactions($validator->validated());
            return redirect()->back();
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', "An unexpected error was encountered. Please contact support");
        }

    }

    /**
     * A list of the accepted rules
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'currency' => ['required', Rule::in(['NGN', 'GHS', 'KES', 'USD', 'ALL'])],
            'date.*.from' => ['nullable', 'date'],
            'date.*.to' => ['nullable', 'date']
        ];
    }

    /**
     * A list of the accepted rules
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getTransactions(array $data)
    {
        return TransactionVolumeFilter::apply($data);
    }
}
