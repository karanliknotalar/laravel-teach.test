<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

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
            ->join("product_quantities", "products.id", "product_quantities.product_id")
            ->orderBy("products.created_at", "desc")
            ->select([
                "products.id",
                "products.category_id",
                "products.name",
                "products.slug_name",
                "products.image",
                "products.sort_description",
                "product_quantities.id as product_quantities_id",
                "product_quantities.price",
            ])
            ->where('product_quantities.price', '=', function ($query) {
                $query->select('price')
                    ->from('product_quantities')
                    ->whereColumn('product_id', 'products.id')
                    ->orderBy('price')
                    ->limit(1);
            })
            ->where(function ($query) use ($request) {

                if (isset($request->start_price) && isset($request->end_price)) {
                    $query->whereBetween("price", [$request->start_price, $request->end_price]);
                }
                return $query->where($this->filterQuery($request->query()));
            })
            ->with("category:id,name,slug_name")
            ->orderBy($order_column, $order_director)
            ->whereHas("category", function ($query) use ($category_id) {
                if (isset($category_id)) {
                    $query->where("category_id", $category_id)->orWhere("parent_id", $category_id);
                }
                return $query;
            })
            ->paginate(12)
            ->appends($this->filterQuery($request->query(), true, true));

        $min_price = $this->getMinMax(true);

        $max_price = $this->getMinMax(false);

        $sizes = $this->getSizesOrColors("size", $category_id);

        $colors = $this->getSizesOrColors("color", $category_id);

        return view("front.pages.products", compact("products", "min_price", "max_price", "sizes", "colors"));
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
                \DB::raw("COUNT(product_quantities.{$column}) as {$column}_count")
            ])
            ->groupBy("product_quantities.{$column}")
            ->get();
    }
}
