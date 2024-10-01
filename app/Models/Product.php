<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function gallery()
    {
        return $this->hasMany(ProductGallery::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }



}
