<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        'code', 'name', 'currency', 'price', 'merchant_id', 'description', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'merchant_id', 'id');
    }
}
