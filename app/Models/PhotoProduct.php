<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoProduct extends Model
{
    use HasFactory;

    protected $appends = ['photo_url'];

    public function getPhotoUrlAttribute()
    {
        return asset('/storage/product_gallery/' . $this->image);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
