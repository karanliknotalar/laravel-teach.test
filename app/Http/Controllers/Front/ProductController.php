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


    public function product(Request $request, $id, $slug_name = null)
    {
        $product = Product::with("product_quantity:product_id,size")
            ->where("status", "=", 1)
            ->where("id", "=", $id)
            ->firstOrFail();

//        return $product;

        $f_products = Product::where("status", "=", 1)
            ->where("category_id", "=", $product->category_id)
            ->where("id", "!=", $product->id)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        return view("front.pages.product", compact("product", "f_products"));
    }

    public function size(Request $request)
    {
        $colors = ProductQuantity::where("product_id", "=", decrypt($request->id))
            ->where("size", "=", $request->size)
            ->select("color")
            ->groupBy("color")
            ->get();
        return response($colors);
    }

    public function color(Request $request)
    {
        $price = ProductQuantity::where("product_id", "=", decrypt($request->id))
            ->where("size", "=", $request->size)
            ->where("color", "=", $request->color)
            ->select("price")
            ->first();

        return response(["price" => number_format($price->price, 2)]);
    }
}
