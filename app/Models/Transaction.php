<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $appends = ['format_total_price', 'format_date'];

    public function getFormatTotalPriceAttribute()
    {
        return number_format($this->total_price, 0, ',', '.');
    }

    public function getFormatDateAttribute()
    {
        return \Carbon\Carbon::parse($this->date)->format('d M Y H:i:s');
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
