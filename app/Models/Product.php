<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "category_id",
        "name",
        "slug",
        "image",
        "description",
        "sort_description",
        "status"
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class, "id", "category_id")->where("status", "=", 1);
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
    private function generateSlug($name): array|string|null
    {
        if (static::whereSlug($slug = Str::slug($name))->exists()) {
            $max = static::whereName($name)->latest('id')->skip(1)->value('slug');
            if (isset($max[-1]) && is_numeric($max[-1])) {
                return preg_replace_callback('/(\d+)$/', function($mathces) {
                    return $mathces[1] + 1;
                }, $max);
            }
            return "{$slug}-2";
        }
        return $slug;
    }
}
