<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $appends = ['format_amount'];

    protected $fillable = [
        'product_id',
        'qty',
        'type',
        'amount',
        'date',
        'description',
        'created_at',
        'updated_at'
    ];

    public function getFormatDateAttribute()
    {
        return \Carbon\Carbon::parse($this->date)->format('d M Y H:i:s');
    }

    public function getFormatAmountAttribute()
    {
        return number_format($this->amount, 0, ',', '.');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
