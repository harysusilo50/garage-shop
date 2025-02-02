<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $appends = ['format_price'];

    public function getFormatPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
