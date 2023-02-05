<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'fullname'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class, 'merchant_id', 'id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'merchant_id', 'id');
    }

    /**
     * number of users available in the system
     * @param Builder $query
     * @param array $data
     * @return int
     */
    public function scopeCountAllUsers(Builder $query, array $data): int
    {
        return $query->selectRaw('count(users.id) as allUsers')
            ->count();
    }


    /**
     * number of merchants with at least one sale in a particular time frame.
     * @param Builder $query
     * @param array $data
     * @return int
     */
    public function scopeCountUniqueSellers(Builder $query, array $data): int
    {
        $result =
            $query
                ->join('purchases', 'users.id', '=', 'purchases.merchant_id')
                ->selectRaw('purchases.merchant_id, count(*) as newSellers')
                ->groupBy('users.id')
                ->havingRaw('count(purchases.id) >= 1')
                ->get();
        return count($result);


    }

    /**
     * number of merchants that made their first sale in a particular time frame
     * @param Builder $query
     * @param array $data
     * @return int
     */
    public function scopeCountNewSellers(Builder $query, array $data): int
    {

        $result = $query
            ->join('purchases', 'users.id', '=', 'purchases.merchant_id')
            ->selectRaw('purchases.merchant_id, count(*) as newSellers')
            ->groupBy('users.id')
            ->havingRaw('count(purchases.id) = 1')
            ->get();

        return count($result);

    }

    /**
     * A merchant is defined as a user that has created at least one product,
     * so a new merchant is a user that added their first product in that particular time frame.
     * @param Builder $query
     * @param array $data
     * @return int
     */
    public function scopeCountNewMerchants(Builder $query, array $data): int
    {

        $result = $query
            ->join('products', 'products.merchant_id', '=', 'users.id')
            ->selectRaw('products.merchant_id, count(*) as newMerchants')
            ->groupBy('users.id')
            ->havingRaw('count(products.id) = 1')
            ->get();

        return count($result);


    }
}
