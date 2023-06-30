<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
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
            ->orderBy("created_at", "desc")
            ->select(["id", "category_id", "size", "color", "name", "slug_name", "image", "sort_description", "price"])
            ->where(function ($query) use ($request) {

                if (isset($request->start_price) && isset($request->end_price)) {
                    $query->whereBetween("price", [$request->start_price, $request->end_price]);
                }
                return $query->where($this->filterQuery($request->query()));
            })
            ->with("category:id,name,slug_name")
            ->orderBy($order_column, $order_director)
            ->whereHas("category", function ($query) use ($category_id) {
                if (isset($category_id)){
                    $query->where("category_id", $category_id)->orWhere("parent_id", $category_id);
                }
                return $query;
            })
            ->paginate(12)
            ->appends($this->filterQuery($request->query(), true, true));

        $min_price = Product::where("status", 1)
            ->select("price")
            ->min("price");
        $max_price = Product::where("status", 1)
            ->select("price")
            ->max("price");
        $size_list = Product::where("status", 1)
            ->select("size")
            ->groupBy("size")
            ->withCount("size")
            ->get();
        $color_list = Product::where("status", 1)
            ->select("color")
            ->groupBy("color")
            ->withCount("color")
            ->get();

        return view("front.pages.products", compact("products", "min_price", "max_price", "size_list", "color_list"));
    }


    public function product(Request $request, $id, $slug_name)
    {
        $product = Product::where("status", "=", 1)
            ->where("id", "=", $id)
            ->firstOrFail();

        $f_products = Product::where("status", "=", 1)
            ->where("category_id", "=", $product->category_id)
            ->where("id", "!=", $product->id)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view("front.pages.product", compact("product", "f_products"));
    }
}
