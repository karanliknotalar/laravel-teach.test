<?php

namespace App\Http\Controllers\Front;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductQuantity;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductsController extends Controller
{

    public function products(Request $request, $category_slug = null, $category_id = null, $sub_category = null)
    {

        foreach ($request->query() as $key => $value) {

            if (empty($value)) {
                unset($request[$key]);
            }
        }

        $products = Product::where("status", "=", 1)
            ->join("product_quantities", function ($join) {
                $join->on("products.id", "=", "product_quantities.product_id")
                    ->whereRaw("product_quantities.id = (SELECT id FROM product_quantities WHERE product_id = products.id ORDER BY price ASC LIMIT 1)");
            })
            ->select([
                "products.*",
                "product_quantities.id as product_quantities_id",
                "product_quantities.price",
                "product_quantities.size",
                "product_quantities.color",
            ])
            ->where(function ($query) use ($request) {
                if (isset($request->size))
                    $query->whereIn("size", explode(",", $request->size));
                if (isset($request->color))
                    $query->whereIn("color", explode(",", $request->color));
                if (isset($request->min) || isset($request->max))
                    $query->whereBetween("price", [$request->min ?? 0, $request->max ?? $this->getMinMax(false)]);
                return $query;
            })
            ->where('product_quantities.price', function ($query) {
                $query->selectRaw('MIN(price)')
                    ->from('product_quantities')
                    ->whereColumn('product_id', 'products.id');
            })
            ->with("category:id,name,slug_name")
            ->with("vat:id,VAT")
            ->orderBy($request->order ?? "updated_at", $request->director ?? "desc")
            ->whereHas("category", function ($query) use ($category_id) {
                if (isset($category_id))
                    $query->where("category_id", $category_id)->orWhere("parent_id", $category_id);
                return $query;
            })
            ->paginate(12)
            ->appends($request->query());

//        return $products;
//        if ($request->ajax()){
//            $view = view("front.ajax.products-list", compact("products"))->render();
//            return response(["data"=> $view]);
//        }

        $sizes = $this->getSizesOrColors($request, "size", $category_id);

        $min_max_price = ["min"=>$this->getMinMax(true), "max"=>$this->getMinMax(false)];

        $colors = $this->getSizesOrColors($request, "color", $category_id);

        $category = Category::where("id", $category_id)->select(["id", "seo_description", "seo_keywords", "image", "name"])->first();

        $seo = [
            "seo_title" => $category->name ?? "",
            "seo_description" => $category->seo_description ?? "",
            "seo_keywords" => $category->seo_keywords ?? "",
            "seo_image" => $category->image ?? ""
        ];

        return view("front.pages.products", compact("products", "sizes", "colors", "seo", "min_max_price"));
    }

    public function getSizesOrColors($request, $column, $category_id = null)
    {
        return ProductQuantity::join("products", "product_quantities.product_id", "products.id")
            ->where("products.status", "=", 1)
            ->whereIn('products.category_id', function ($query) use ($category_id) {
                if (isset($category_id)) {
                    $query->select('categories.id')
                        ->from('categories')
                        ->where('categories.id', $category_id)
                        ->orWhere('categories.parent_id', $category_id);
                } else {
                    $query->select('categories.id')
                        ->from('categories');
                }
            })
            ->where(function ($query) use ($request) {
                if (isset($request->size))
                    $query->whereIn("size", explode(",", $request->size));
                if (isset($request->color))
                    $query->whereIn("color", explode(",", $request->color));
                if (isset($request->min) || isset($request->max))
                    $query->whereBetween("price", [$request->min ?? 0, $request->max ?? $this->getMinMax(false)]);
                return $query;
            })
            ->select([
                "product_quantities.{$column}",
                DB::raw("COUNT(product_quantities.{$column}) as {$column}_count")
            ])
            ->groupBy("product_quantities.{$column}")
            ->get();
    }

    public function getMinMax($min = true)
    {
        $result = Product::where("status", "=", 1)
            ->join("product_quantities", "products.id", "product_quantities.product_id")
            ->select("product_quantities.price")
            ->where('product_quantities.price', '=', function ($query) {
                $query->select('price')
                    ->from('product_quantities')
                    ->whereColumn('product_id', 'products.id')
                    ->orderBy('price')
                    ->limit(1);
            });
        if ($min)
            return $result->min("product_quantities.price");
        else
            return $result->max("product_quantities.price");
    }
}
