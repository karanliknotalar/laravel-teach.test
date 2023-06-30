<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function product()
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }
}
