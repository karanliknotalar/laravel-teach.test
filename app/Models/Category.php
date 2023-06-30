<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        "parent_id",
        "name",
        "slug_name",
        "description",
        "seo_description",
        "seo_keywords",
        "status",
        "image",
        "thumbnail",
        "order",
    ];


    public function items(): HasMany
    {
        return $this->hasMany(Product::class, "category_id", "id");
    }

    public function sub_categories(): HasMany
    {
        return $this->hasMany(Category::class, "parent_id", "id")->withCount("items");
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
