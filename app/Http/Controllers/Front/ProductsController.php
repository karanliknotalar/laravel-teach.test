<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductQuantity;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductsController extends Controller
{
//    private function filterQuery($input_array, $include_between = false, $include_orderby = false)
//    {
//        if (!array_key_exists("order", $tmp) || !array_key_exists("director", $tmp)) {
//            unset($tmp["order"]);
//            unset($tmp["director"]);
//        }
//        return $tmp;
//    }


    public function products(Request $request, $category_slug = null, $category_id = null, $sub_category = null)
    {
        $products = Product::where("status", "=", 1)
            ->join("product_quantities", "products.id", "product_quantities.product_id")
            ->orderBy("products.created_at", "desc")
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
                if (isset($request->min) && isset($request->max))
                    $query->whereBetween("price", [$request->min ?? 0, $request->max ?? $this->getMinMax(false)]);
                return $query;
            })
            ->where('product_quantities.price', function ($query) {
                $query->select('price')
                    ->from('product_quantities')
                    ->whereColumn('product_id', 'products.id')
                    ->orderBy('price')
                    ->limit(1);
            })
            ->with("category:id,name,slug_name")
            ->orderBy($request->order ?? "name", $request->director?? "asc")
            ->whereHas("category", function ($query) use ($category_id) {
                if (isset($category_id))
                    $query->where("category_id", $category_id)->orWhere("parent_id", $category_id);
                return $query;
            })
            ->paginate(12)
            ->appends($request->query());

        $sizes = $this->getSizesOrColors("size", $category_id);

        $max_price = $this->getMinMax(false);

        $colors = $this->getSizesOrColors("color", $category_id);

        return view("front.pages.products", compact("products", "sizes", "colors", "max_price"));
    }

    public function getSizesOrColors($column, $category_id = null)
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
