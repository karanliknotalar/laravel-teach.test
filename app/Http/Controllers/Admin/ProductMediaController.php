<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Models\Product;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductMediaController extends Controller
{
    public function images(Request $request, $product_id, $color)
    {
        $product_id = decrypt($product_id);

        $product = Product::where("id", $product_id)
            ->with("product_media", function ($query) use ($product_id, $color) {
            return $query->where(["product_id" => $product_id, "color" => $color]);
        })->select(["id","name"])->first();

        return view("admin.pages.product_media.edit", compact("product", "color"));
    }

    public function add(Request $request)
    {

        $product_id = decrypt($request->product_id);

        $img_arr = [];
        $imagesM = ProductMedia::where("product_id", $product_id)->where("color", $request->color)->first();

        if ($imagesM) {
            $img_arr = json_decode($imagesM->images);
        }

        $product = Product::where("id", $product_id)->select(["id", "name", "product_code"])->first();

        if ($product) {

            foreach ($request->image as $img) {

                $imageName = Helper::getFileName($product->product_code . "_r" . rand(1000, 9999), $img, "images/products/" . $product->product_code . "/" . $request->color . "/");
                Helper::fileSave($img, $imageName);
                $img_arr[] = $imageName;

            }

            ProductMedia::updateOrCreate(
                [
                    'id' => $imagesM->id ?? null,
                ],
                [
                    'product_id' => $product_id,
                    'color' => $request->color,
                    'images' => json_encode($img_arr),
                ]

            );

            return response(["success" => true, "message" => "Resimler yüklendi..."]);
        }
        return response(["success" => true]);
    }

    public function delete(Request $request)
    {
        $product_media_id = decrypt($request->id);
        $image = $request->image;

        $productMedia = ProductMedia::where("id", $product_media_id)->first();

        if ($productMedia) {
            $img_arr = json_decode($productMedia->images, true);
            $key = array_search($image, $img_arr);

            if ($key !== false) {
                unset($img_arr[$key]);
                Helper::fileDelete($image, true);
            }

            $img_count = count($img_arr);

            if ($img_count > 0){
                $productMedia->update([
                    "images" => json_encode(array_values($img_arr))
                ]);
            } else {
                $productMedia->delete();
            }

            return response(["result" => true, "img_count" => $img_count, "message" => "Silindi"]);
        }
        return response(["result" => false, "message" => "Hata"]);
    }

    public function delete_all(Request $request){
        $product_media_id = decrypt($request->product_media_id);

        $product_media = ProductMedia::where("id", $product_media_id)->first();

        if ($product_media) {
            $img_arr = json_decode($product_media->images, true);
            foreach ($img_arr as $img){
                Helper::fileDelete($img, true);
            }

            $product_media->delete();
        }

        return back();
    }
}
