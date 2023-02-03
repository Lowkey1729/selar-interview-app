<?php

namespace App\Http\Controllers\KPIs;

use App\Currency;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductKPIController extends Controller
{
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

    protected function getProducts(array $data)
    {
        $this->setDateToNullIfNotSet($data);
        $to = $data['date']['to'];
        $from = $data['date']['from'];


        return Product::query()
            ->selectRaw('COUNT(id) as total_new_products')
            ->when($from || $to, function (Builder $query) use ($from, $to) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [$from, $to]);
            })
            ->first();
    }

    protected function validationMessages(): array
    {
        return [
            'after_or_equal' => "You need to select a date equal or after the 'View From' date",
            'date.from.required_with' => "The 'View To' date is also required since you selected 'View From' date",
            'date.to.required_with' => "The 'View From' date is also required  since you selected 'View To' date",
        ];
    }

    /**
     * A list of the accepted rules for validation
     * @return array
     */
    protected function validationRules(): array
    {
        return [
            'date.from' => ['nullable', 'date', 'required_with:date.to'],
            'date.to' => ['nullable', 'date', 'after_or_equal:date.from', 'required_with:date.from']
        ];
    }

    protected function setDateToNullIfNotSet(&$data)
    {

        if (!isset($data['date']['from']) && !isset($data['date']['to'])) {
            $data['date']['from'] = $data['date']['to'] = null;
        }


    }
}
