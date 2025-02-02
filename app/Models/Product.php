<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Sluggable;
    protected $appends = ['thumbnail_url', 'format_price', 'format_discount_price', 'title_card', 'title_breadcumb', 'stock_in', 'stock_out'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getThumbnailUrlAttribute()
    {
        return asset('/storage/product_thumbnail/' . $this->thumbnail);
    }

    public function getFormatPriceAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function getFormatDiscountPriceAttribute()
    {
        return number_format($this->discount_price, 0, ',', '.');
    }

    public function getTitleCardAttribute()
    {
        if (strlen($this->name) > 28) {
            $result = substr($this->name, 0, 25);
            return $result . '...';
        }
        return $this->name;
    }

    public function getTitleBreadcumbAttribute()
    {
        if (strlen($this->name) > 10) {
            $result = substr($this->name, 0, 10);
            return $result . '...';
        }
        return $this->name;
    }

    public function variant()
    {
        return $this->hasMany(VariantProduct::class);
    }

    public function photo()
    {
        return $this->hasMany(PhotoProduct::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    public function stock_product()
    {
        return $this->hasMany(Stock::class);
    }
}
