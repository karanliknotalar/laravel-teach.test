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
            ->with("low_price_product:product_id,size,color,price")
            ->with("vat:id,VAT")
            ->with(["product_media" => function ($query) {
                $query->where('color', function ($query) {
                    $query->select('color')
                        ->from('product_quantities')
                        ->whereColumn('product_id', 'product_medias.product_id')
                        ->limit(1);
                })->select(["product_id", "images"]);
            }])
            ->where("status", "=", 1)
            ->where("slug_name", "=", $slug_name)
            ->first();

        $f_products = Product::where("status", "=", 1)
            ->with("low_price_product:product_id,price")
            ->with("vat:id,VAT")
            ->with("product_media:id,product_id,images,showcase_id")
            ->where("category_id", "=", $product->category_id)
            ->where("id", "!=", $product->id)
            ->whereHas('low_price_product', function ($query) {
                $query->whereNotNull('price');
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $seo = [
            "seo_title" => $product->name,
            "seo_description" => $product->description ?? "",
            "seo_keywords" => join(",", explode(" ", $product->name)),
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
            ->with(["product_media" => function ($query) use ($request) {
                $query->where('color', $request->color)->select(["product_id", "images","showcase_id"]);
            }])
            ->select("price", "id", "product_id")
            ->first();

        $view = "";
        $product = Product::where("id", decrypt($request->id))->select(["name","image"])->first();

        if ($request->ajax()) {
            $showcase_id = $price->product_media->showcase_id ?? 0;
            $images = isset($price->product_media) ? json_decode($price->product_media->images) : [];

            $view = view("front.ajax.product-gallery", compact("images","product","showcase_id"))->render();
            return response(
                [
                    "price" => number_format($price->price, 2),
                    "vat" => number_format(Helper::getVat($price->price, $price->product->vat->VAT), 2),
                    "total" => number_format(Helper::getVatIncluded($price->price, $price->product->vat->VAT), 2),
                    "images" => $view,
                ]);
        }
        return response(
            [
                "price" => number_format($price->price, 2),
                "vat" => number_format(Helper::getVat($price->price, $price->product->vat->VAT), 2),
                "total" => number_format(Helper::getVatIncluded($price->price, $price->product->vat->VAT), 2),
                "images" => $view,
            ]);
    }
}
