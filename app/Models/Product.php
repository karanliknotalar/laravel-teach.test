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
        "product_no",
        "price",
        "size",
        "color",
        "quantity",
        "status"
    ];

    public function category()
    {
        return $this->hasOne(Category::class, "id", "category_id")->where("status", "=", 1);
    }

    public function size()
    {
        return $this->hasMany(Product::class, "size", "size")->where("status", "=", 1);
    }

    public function color()
    {
        return $this->hasMany(Product::class, "color", "color")->where("status", "=", 1);
    }

}
