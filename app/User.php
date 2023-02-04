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
     * number of merchants with at least one sale in a particular time frame.
     * @param Builder $query
     * @param array $data
     * @return Builder
     */
    public function scopeCountUniqueSellers(Builder $query, array $data): Builder
    {
        return $query->addSelect([
            'newSellers' => Purchase::query()
                ->selectRaw('HAVING COUNT(id) >= 1')
                ->whereColumn('merchant_id', 'users.id')

        ]);
    }

    /**
     * number of merchants that made their first sale in a particular time frame
     * @param Builder $query
     * @param array $data
     * @return Builder
     */
    public function scopeCountNewSellers(Builder $query, array $data): Builder
    {
        return $query->addSelect([
            'newSellers' => Purchase::query()
                ->selectRaw('HAVING COUNT(id) == 1')
                ->whereColumn('merchant_id', 'users.id')

        ]);
    }

    /**
     * A merchant is defined as a user that has created at least one product,
     * so a new merchant is a user that added their first product in that particular time frame.
     * @param Builder $query
     * @param array $data
     * @return Builder
     */
    public function scopeCountNewMerchants(Builder $query, array $data): Builder
    {
        return $query->addSelect([
            'newSellers' => Product::query()
                ->selectRaw('HAVING COUNT(id) == 1')
                ->whereColumn('merchant_id', 'users.id')

        ]);
    }
}
