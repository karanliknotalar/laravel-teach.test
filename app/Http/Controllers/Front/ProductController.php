<?php

namespace App\Http\Controllers\Front;

use App\Helper\Helper;
use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{


    public function product(Request $request, $slug_name = null)
    {

        $product = Product::with("product_size:product_id,size")
            ->with("low_price:product_id,size,color,price")
            ->with("vat:id,VAT")
            ->where("status", "=", 1)
            ->where("slug_name", "=", $slug_name)
            ->firstOrFail();

        $f_products = Product::query()->with("low_price:product_id,price")
            ->with("vat:id,VAT")
            ->where("status", "=", 1)
            ->where("category_id", "=", $product->category_id)
            ->where("id", "!=", $product->id)
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $seo = [
            "seo_title" => $product->name,
            "seo_description" => $product->description ?? "",
            "seo_keywords" => join(",", explode(" ",$product->name)),
            "seo_image" => $product->image
        ];

        return view("front.pages.product", compact("product", "f_products", "seo"));
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
            ->with("product:id,VAT_id")
            ->where("size", "=", $request->size)
            ->where("color", "=", $request->color)
            ->select("price", "id", "product_id")
            ->first();

        return response(
            [
                "price" => number_format($price->price, 2),
                "vat" => number_format(Helper::getVat($price->price, $price->product->vat->VAT), 2),
                "total" => number_format(Helper::getVatIncluded($price->price, $price->product->vat->VAT), 2)
            ]);
    }
}
