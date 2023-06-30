<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "category_id",
        "name",
        "slug_name",
        "image",
        "description",
        "sort_description",
        "price",
        "size",
        "color",
        "quantity",
        "status"
    ];

    public function category()
    {
        return $this->hasOne(Category::class, "id", "category_id");
    }

    public function size(){
        return $this->hasMany(Product::class,"size","size");
    }

    public function color(){
        return $this->hasMany(Product::class,"color","color");
    }

}
