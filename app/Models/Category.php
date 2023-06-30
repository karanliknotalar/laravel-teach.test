<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "parent_id",
        "name",
        "slug",
        "description",
        "seo_description",
        "seo_keywords",
        "status",
        "image",
    ];

    public function items(): HasMany
    {
        return $this->hasMany(Product::class, "category_id", "id")->where("status", "=", 1);
    }

    public function sub_categories(): HasMany
    {
        return $this->hasMany(Category::class, "parent_id", "id")->withCount("items")->where("status", "=", 1);
    }

    public function base_category(): HasOne
    {
        return $this->hasOne(Category::class, "id", "parent_id")->where("status", "=", 1);
    }

    public function mainCategoryCounts()
    {

        $counts = $this->items()->count();
        foreach ($this->sub_categories as $sub_category) {
            $counts += $sub_category->items_count;
        }
        return $counts;
    }
}
