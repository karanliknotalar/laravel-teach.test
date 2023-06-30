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


    public function product(Request $request, $slug = null)
    {

        $product = Product::with("product_size:product_id,size")
            ->with("low_price:product_id,size,color,price")
            ->where("status", "=", 1)
            ->where("slug", "=", $slug)
            ->firstOrFail();

        $f_products = Product::query()->with("low_price:product_id,price")
            ->where("status", "=", 1)
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
