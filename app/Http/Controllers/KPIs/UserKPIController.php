<?php

namespace App\Http\Controllers\KPIs;

use App\Http\Controllers\Controller;
use App\Product;
use App\Purchase;
use App\Services\Traits\KPIS\UserKPITrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserKPIController extends Controller
{
    use UserKPITrait;

    public function index(Request $request)
    {
        $users = $this->getUsers($this->getRequestData($request->all()));
        return view('kpis.users.index', compact('users'));
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
