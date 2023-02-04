<?php

namespace App\Http\Controllers\KPIs;

use App\Http\Controllers\Controller;
use App\Services\Traits\KPIS\UserKPITrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserKPIController extends Controller
{
    use UserKPITrait;

    public function index(Request $request)
    {
        $users = $this->getUsers($this->getRequestData($request->all()));
        $userCategories = $this->userCategories();
        return view('kpis.users.index', compact('users', 'userCategories'));
    }

    public function totalUsers(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), $this->validationRules(), $this->validationMessages());

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)
                ->withInput();
        }

        return redirect()->route("users.kpi.index", $request->all());
    }


}
