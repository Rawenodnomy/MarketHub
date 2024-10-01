<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    // $subcategories = Subcategory::with('category')->get();

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
