<?php

namespace App\Http\Controllers\KPIs;

use App\Http\Controllers\Controller;
use App\Services\Traits\KPIS\UserKPITrait;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class UserKPIController extends Controller
{
    use UserKPITrait;

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $userCategoryCount = $this->getUsers($this->getRequestData($request->all()));

        $userCategories = $this->userCategories();
        return view('kpis.users.index', compact('userCategoryCount', 'userCategories'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function totalUsers(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), $this->validationRules(), $this->validationMessages());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        return redirect()->route("users.kpi.index", $request->all());
    }


}
