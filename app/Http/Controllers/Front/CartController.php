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
//        session()->pull("cart", []);
        $totalPrice = 0;

        foreach ($cartItems as $cartItem) {
            if (isset($cartItem["price"]) && isset($cartItem["quantity"]))
                $totalPrice += $cartItem["price"] * $cartItem["quantity"];
        }

        return view("front.pages.cart", compact("cartItems", "totalPrice"));
    }

    public function add_cart(Request $request)
    {
//        return response($request->all());

        $product_id = decrypt($request->product_id);
        $quantity = $request->quantity;
        $size = $request->size;
        $color = $request->color;

//        return $product_id

        $cartItems = session("cart", []);

        if (Product::where("id", $product_id)->exists()) {

            if ($productQuantity = ProductQuantity::where([["product_id", "=", $product_id], ["size", "=", $size], ["color", "=", $color], ["quantity", ">=", $quantity]])->first()) {

                $cartId = $product_id . "_" . $productQuantity->id;

                if (array_key_exists($cartId, $cartItems)) {

                    $cartItems[$cartId]["quantity"] += $quantity;

                } else {

                    $product = Product::where("id", $product_id)->first();

                    $cartItems[$cartId] = [
                        "name" => $product->name,
                        "slug_name" => $product->slug_name,
                        "image" => $product->image,
                        "price" => $productQuantity->price,
                        "quantity" => $request->quantity,
                        "size" => $size,
                        "color" => $color,
                        "product_id" => $product_id,
                        "product_quantity_id" => $productQuantity->id,
                    ];
                }
                session(["cart" => $cartItems]);

                return response(["success" => true, "message" => "ürün sepete eklendi"]);
            } else
                return response(["quantity" => true, "message" => "stok yetersiz"]);
        } else
            return response(["error" => true, "message" => "ürün ile ilgili bir sorun oluştu"]);

    }

    public function remove_cart(Request $request)
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
}
