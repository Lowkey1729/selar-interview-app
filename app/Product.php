<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'currency', 'price', 'merchant_id', 'description', 'deleted_at', 'created_at', 'updated_at'
    ];

    public function merchant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'merchant_id', 'id');
    }

    public function scopeFilterDateQuery(Builder $query, $from, $to, $dateType, $column)
    {
        $rawSQLDate = rawSQLDateFormat($dateType, $column);
        return $query->when($from || $to, function (Builder $query) use ($rawSQLDate, $from, $to, $dateType, $column) {
            $dateType == 'days' ? $query->whereBetween(DB::raw($rawSQLDate), [$from, $to])
                : $query->whereRaw($rawSQLDate . " = ? AND YEAR({$column}) = ?", [$from, date('Y')]);
        });
    }
}
