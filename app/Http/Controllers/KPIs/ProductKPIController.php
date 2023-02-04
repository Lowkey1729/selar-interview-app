<?php

namespace App\Http\Controllers\KPIs;

use App\Http\Controllers\Controller;
use App\Services\Traits\KPIS\ProductKPITrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductKPIController extends Controller
{
    use ProductKPITrait;

    public function index(Request $request)
    {
        $products = $this->getProducts($request->all());
        return view('kpis.products.index', compact('products'));
    }

    /**
     * a count of new products added to the table.
     * @param Request $request
     * @return RedirectResponse
     */
    public function totalProducts(Request $request): RedirectResponse
    {
        //validate
        $validator = Validator::make($request->all(), $this->validationRules(), $this->validationMessages());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        return redirect()->route("products.kpi.index", $request->all());
    }

}
