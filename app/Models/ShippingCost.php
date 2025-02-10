<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
    use HasFactory;

    protected $appends = ['format_cost'];

    public function getFormatCostAttribute()
    {
        return number_format($this->cost, 0, ',', '.');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
