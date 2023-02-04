<?php

namespace App\Http\Controllers\KPIs;

use App\Currency;
use App\Http\Controllers\Controller;
use App\Product;
use App\Services\Traits\KPIS\ProductKPITrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function totalProducts(Request $request): \Illuminate\Http\RedirectResponse
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
