<?php

namespace App\Http\Controllers\KPIs;

use App\Currency;
use App\CustomFilters\TransactionVolumeFilter\TransactionVolumeFilter;
use App\Http\Controllers\Controller;
use App\Services\Traits\KPIS\TransactionKPITrait;
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
    use TransactionKPITrait;

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


}
