<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use HasFactory;
    use Sluggable;

    protected $appends = ['image_url'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function getImageUrlAttribute()
    {
        return asset('/storage/brand/' . $this->image);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
