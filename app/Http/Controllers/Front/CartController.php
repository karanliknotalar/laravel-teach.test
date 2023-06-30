<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CartController extends Controller
{
    public function cart(Request $request)
    {

        $cartItems = session("cart", []);
        $totalPrice = 0;
        $unsetting_product = [];

        foreach ($cartItems as $cartId => $cartItem) {

            if (Product::where("id", $cartItem["product_id"])->exists() && ProductQuantity::where([["id", "=", $cartItem["product_quantity_id"]], ["quantity", ">=", $cartItem["quantity"]]])->exists()) {

                if (isset($cartItem["price"]) && isset($cartItem["quantity"])) {
                    $totalPrice += $cartItem["price"] * $cartItem["quantity"];
                }
            } else {
                $unsetting_product[$cartId] = $cartItem;
                unset($cartItems[$cartId]);
            }

        }

        session(["cart" => $cartItems]);
        return view("front.pages.cart", compact("cartItems", "totalPrice", "unsetting_product"));
    }

    public function addCart(Request $request)
    {

//        return $request->all();

        $product_id = decrypt($request->product_id);
        $quantity = $request->quantity;
        $size = $request->size;
        $color = $request->color;

        $cartItems = session("cart", []);

        if (Product::where("id", $product_id)->exists()) {

            if ($productQuantity = ProductQuantity::where([["product_id", "=", $product_id], ["size", "=", $size], ["color", "=", $color], ["quantity", ">=", $quantity]])->first()) {

                $cartId = $product_id . "_" . $productQuantity->id;

                if (array_key_exists($cartId, $cartItems)) {

                    if ($productQuantity->quantity <= $cartItems[$cartId]["quantity"])
                        return response(["success" => false, "error" => "stok", "message" => "stok yetersiz"]);

                    $cartItems[$cartId]["quantity"] += $quantity;

                } else {

                    $product = Product::where("id", $product_id)->first();

                    $cartItems[$cartId] = [
                        "name" => $product->name,
                        "slug_name" => $product->slug_name,
                        "image" => $product->image,
                        "price" => $productQuantity->price,
                        "quantity" => (int)$request->quantity,
                        "size" => $size,
                        "color" => $color,
                        "product_id" => $product_id,
                        "product_quantity_id" => $productQuantity->id
                    ];
                }
                session(["cart" => $cartItems]);

                return response(["success" => true, "message" => "ürün sepete eklendi"]);
            } else
                return response(["success" => false, "error" => "stok", "message" => "stok yetersiz"]);
        } else
            return response(["success" => false, "error" => "ürün", "message" => "ürün ile ilgili bir sorun oluştu"]);

    }

    public function removeCart(Request $request)
    {
        $product_id = decrypt($request->product_id);
        $productQuantity = decrypt($request->product_quantity_id);

        $id = $product_id . "_" . $productQuantity;

        $cartItems = session()->pull('cart', []);

        if (array_key_exists($id, $cartItems)) {
            unset($cartItems[$id]);
        }

        session(["cart" => $cartItems]);
        return back();
    }

    public function updateCartQuantity(Request $request)
    {

//        return $request->all();
        $cartId = decrypt($request->cartId);
        $product_id = explode("_", $cartId)[0];
        $product_quantity_id = explode("_", $cartId)[1];
        $quantity = $request->quantity;

        $cartItems = session("cart", []);

        if (Product::where("id", $product_id)->exists()) {

            if (ProductQuantity::where([["id", "=", $product_quantity_id], ["product_id", "=", $product_id], ["quantity", ">=", $quantity]])->exists()) {

                if (array_key_exists($cartId, $cartItems)) {

                    $cartItems[$cartId]["quantity"] = $quantity > 0 ? $quantity : 1;
                }

                session(["cart" => $cartItems]);

                return response(["success" => true, "message" => "sepet güncellendi"]);
            } else
                return response(["success" => false, "error" => "stok", "message" => "stok yetersiz"]);
        } else
            return response(["success" => false, "error" => "ürün", "message" => "ürün ile ilgili bir sorun oluştu"]);
    }
}
