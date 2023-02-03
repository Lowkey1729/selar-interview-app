<?php

namespace App\Http\Controllers\KPIs;

use App\Currency;
use App\CustomFilters\TransactionVolumeFilter\TransactionVolumeFilter;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TransactionKPIController extends Controller
{

    public function index(Request $request)
    {
        $transactions = $this->getTransactions($this->getRequestData($request->all()));
        $currencies = Currency::query()->get();
        return view('kpis.transactions.index', compact('transactions', 'currencies'));
    }

    /**
     * total amount of sales made in each currency and
     * how much profit we made - this is gotten from the `
     * @param Request $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function transactionVolume(Request $request): RedirectResponse
    {

        //validate
        $validator = Validator::make($request->all(), $this->validationRules(), $this->validationMessages());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        return redirect()->route("transactions.kpi.index", $request->all());

    }

    /**
     * A list of the accepted rules for validation
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'currency' => ['required', Rule::in($this->currenciesOption())],
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
        return TransactionVolumeFilter::apply(array_filter($data));
    }

    protected function getRequestData(array $data): array
    {

        if ($this->currencyWasNotSelected($data)) {
            $data['currency'] = 'ALL';
        }

        return $data;
    }

    protected function currenciesOption(): array
    {
        return [
            'NGN',
            'GHS',
            'KES',
            'USD',
            'ALL'];
    }

    protected function validationMessages(): array
    {
        return [
            'after_or_equal' => "You need to select a date equal or after the 'View From' date",
            'date.from.required_with' => "The 'View To' date is also required since you selected 'View From' date",
            'date.to.required_with' => "The 'View From' date is also required  since you selected 'View To' date",
        ];
    }

    protected function currencyWasNotSelected(array $data): bool
    {
        return !array_key_exists('currency', $data);
    }


}
