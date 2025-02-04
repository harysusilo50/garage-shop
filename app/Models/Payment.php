<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $appends = ['payment_img_url','format_date'];

    public function getPaymentImgUrlAttribute()
    {
        return asset('storage/' . $this->payment_img);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getFormatDateAttribute()
    {
        return \Carbon\Carbon::parse($this->created_at)->format('d M Y H:i:s');
    }

}
