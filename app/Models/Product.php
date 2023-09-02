<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        "VAT_id",
        "status",
        "featured",
        "product_code"
    ];


    public function category(): HasOne
    {
        return $this->hasOne(Category::class, "id", "category_id")->where("status", "=", 1);
    }

    public function vat(): HasOne
    {
        return $this->hasOne(Vat::class, "id", "VAT_id");
    }

    public function product_size(): HasMany
    {
        return $this->hasMany(ProductQuantity::class, "product_id", "id")
            ->groupBy("product_quantities.size", "product_quantities.product_id");
    }

    public function low_price(): HasOne
    {
        return $this->hasOne(ProductQuantity::class, "product_id", "id")
            ->orderBy("product_quantities.price");
    }
}
