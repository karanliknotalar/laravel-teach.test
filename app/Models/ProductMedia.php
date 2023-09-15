<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ProductMedia extends Model
{
    use HasFactory;

    protected $table = 'product_medias';

    protected $fillable = [
        "product_id",
        "color",
        "images",
        "showcase_id"
    ];

    public function product (): HasOne
    {
        return $this->hasOne(Product::class, "id", "product_id");
    }
}
