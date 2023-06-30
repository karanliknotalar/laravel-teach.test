<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductQuantity;
use DB;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductsController extends Controller
{
    private function filterQuery($input_array, $include_between = false, $include_orderby = false)
    {
        $tmp = [];
        foreach ($input_array as $key => $value) {

            if ($key == "size" && !empty($value))
                $tmp["size"] = $value;
            if ($key == "color" && !empty($value))
                $tmp["color"] = $value;

            if ($include_between) {

                if ($key == "start_price" && !empty($value))
                    $tmp["start_price"] = $value;
                if ($key == "end_price" && !empty($value))
                    $tmp["end_price"] = $value;
            }

            if ($include_orderby) {

                if ($key == "order" && !empty($value))
                    $tmp["order"] = $value;
                if ($key == "director" && !empty($value))
                    $tmp["director"] = $value;
            }

        }

        if (!array_key_exists("start_price", $tmp) || !array_key_exists("end_price", $tmp)) {
            unset($tmp["start_price"]);
            unset($tmp["end_price"]);
        }
        if (!array_key_exists("order", $tmp) || !array_key_exists("director", $tmp)) {
            unset($tmp["order"]);
            unset($tmp["director"]);
        }
        return $tmp;
    }


    public function products(Request $request, $category_slug = null, $category_id = null)
    {
        $order_column = $request->query("order") ?? "id";
        $order_director = $request->query("director") ?? "asc";

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
                if (isset($request->start_price) && isset($request->end_price))
                    $query->whereBetween("price", [$request->start_price, $request->end_price]);
                return $query->where($this->filterQuery($request->query()));
            })
            ->where('product_quantities.price', function ($query) {
                $query->select('price')
                    ->from('product_quantities')
                    ->whereColumn('product_id', 'products.id')
                    ->orderBy('price')
                    ->limit(1);
            })
            ->with("category:id,name,slug")
            ->orderBy($order_column, $order_director)
            ->whereHas("category", function ($query) use ($category_id) {
                if (isset($category_id))
                    $query->where("category_id", $category_id)->orWhere("parent_id", $category_id);
                return $query;
            })
            ->paginate(12)
            ->appends($this->filterQuery($request->query(), true, true));

//        return $products;


        $sizes = $this->getSizesOrColors("size", $category_id);

        $colors = $this->getSizesOrColors("color", $category_id);

        return view("front.pages.products", compact("products", "sizes", "colors"));
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
}
