<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        "status"
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, "id", "category_id")->where("status", "=", 1);
    }

}
