<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductQuantity extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_id",
        "price",
        "size",
        "color",
        "quantity",
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, "id", "product_id")->with("vat:id,VAT");
    }
    public function product_media(): HasOne
    {
        return $this->hasOne(ProductMedia::class, "product_id", "product_id");
    }

}
