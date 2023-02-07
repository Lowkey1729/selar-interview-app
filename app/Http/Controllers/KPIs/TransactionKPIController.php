<?php

namespace App\Http\Controllers\KPIs;

use App\Currency;
use App\Http\Controllers\Controller;
use App\Purchase;
use App\Services\Traits\KPIS\TransactionKPITrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class TransactionKPIController extends Controller
{
    use TransactionKPITrait;

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $transactions = $this->getTransactions($this->getRequestData($request->all()));
        $currencies = Currency::query()->get();
        $totalTransactions = Purchase::query()->count();
        return view('kpis.transactions.index', compact('transactions', 'currencies', 'totalTransactions'));
    }

    /**
     * total amount of sales made in each currency and
     * how much profit we made - this is gotten from the `
     * @param Request $request
     * @return RedirectResponse
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
