<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        "user_id",
        "product_id",
        "order_no",
        "product_code",
        "price",
        "VAT",
        "size",
        "color",
        "quantity",
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }

    public function productQuantity(): HasMany
    {
        return $this->hasMany(ProductQuantity::class, "product_id", "product_id");
    }
}
