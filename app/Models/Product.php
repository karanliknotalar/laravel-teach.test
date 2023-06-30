<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        "category_id",
        "name",
        "slug_name",
        "image",
        "description",
        "sort_description",
        "status"
    ];


    public static function creating($callback)
    {
        static::created(function ($request) {
            $request->slug_name = $request->generateSlug($request->name);
            $request->save();
        });
    }

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


    public function sluggable(): array
    {
        return [
            'slug_name' => [
                'source' => 'name'
            ]
        ];
    }
}
