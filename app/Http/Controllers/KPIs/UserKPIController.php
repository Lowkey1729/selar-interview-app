<?php

namespace App\Http\Controllers\KPIs;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;

class UserKPIController extends Controller
{
    public function index()
    {
        
    }

    /**
     * A merchant is defined as a user that has created at least one product,
     * so a new merchant is a user that added their first product in that particular time frame.
     * @return void
     *
     */
    public function newMerchants()
    {
        $newMerchants = User::query()->with(['products'])
            ->has('products', '=', 1)
            ->count();
    }

    /**
     * number of merchants with at least one sale in a particular time frame.
     * @return void
     *
     */
    public function uniqueSellers()
    {
        $uniqueSellers =
            User::query()
                ->with(['purchases'])
                ->has('purchases')
                ->count();
    }

    /**
     * number of merchants that made their first sale in a particular time frame
     * @return void
     *
     */
    public function newSellers()
    {
        $newSellers = User::query()
            ->with(['purchases'])
            ->has('purchases', '=', 1)
            ->count();
    }

    /**
     * a count of all the new users that signed up.
     * @return void
     *
     */
    public function newUsers()
    {
        $newUsers = User::query()
            ->whereDate('created_at', '>=', Carbon::now()->add(-3))
            ->count();
    }


}
