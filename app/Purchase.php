<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Purchase extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'merchant_id', 'id', 'code', 'payment_reference', 'status', 'currency', 'totalamount', 'merchant_commission',
        'created_at', 'updated_at'
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'merchant_id', 'id');
    }



}
