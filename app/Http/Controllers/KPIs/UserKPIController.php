<?php

namespace App\Http\Controllers\KPIs;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserKPIController extends Controller
{
    public function index(Request $request)
    {
        $users = $this->getUsers($request->all());
        return view('kpis.users.index', compact('users'));
    }

    /**
     * A merchant is defined as a user that has created at least one product,
     * so a new merchant is a user that added their first product in that particular time frame.
     * @return int
     *
     */
    public function newMerchants(): int
    {
        return $newMerchants = User::query()->with(['products'])
            ->has('products', '=', 1)
            ->count();
    }

    /**
     * number of merchants with at least one sale in a particular time frame.
     * @return int
     *
     */
    public function uniqueSellers(): int
    {
        return $uniqueSellers =
            User::query()
                ->with(['purchases'])
                ->has('purchases')
                ->count();
    }

    /**
     * number of merchants that made their first sale in a particular time frame
     * @return int
     *
     */
    public function newSellers(): int
    {
        return $newSellers = User::query()
            ->with(['purchases'])
            ->has('purchases', '=', 1)
            ->count();
    }

    /**
     * a count of all the new users that signed up.
     * @return int
     *
     */
    public function allUsers(): int
    {
        return $newUsers = User::query()
            ->count();
    }

    protected function getUsers(array $data, string $filterType = 'allUsers'): int
    {
        switch ($filterType) {
            case "newSellers":
                return $this->newSellers();
            case "newMerchants":
                return $this->newMerchants();
            case "uniqueSellers":
                return $this->uniqueSellers();
            default:
                return $this->allUsers();
        }
    }


}
