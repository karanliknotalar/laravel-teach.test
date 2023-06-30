<?php

namespace App\Http\Controllers\Front;

use App\Models\Product;
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
        return response($request->all());

        $product_id = $request->id;
        $quantity = $request->quantity;
        $size = $request->size;
        $cartItems = session("cart", []);

        $product = Product::find($product_id);

        if ($request->quantity < $product->quantity) {
            if (array_key_exists($product_id, $cartItems)) {
                $cartItems[$product_id]["quantity"] += $quantity;
            } else {
                $cartItems[$product_id] = [
                    "name" => $product->name,
                    "slug_name" => $product->slug_name,
                    "image" => $product->image,
                    "price" => $product->price,
                    "quantity" => $quantity,
                    "size" => $size,
                ];
            }
            session(["cart" => $cartItems]);

            return "ok";
        } else {
            return "stok";
        }

    }

    public function remove_cart(Request $request)
    {
        $cartItems = session()->pull('cart', []);

        if (array_key_exists($request->id, $cartItems)) {
            unset($cartItems[$request->id]);
        }
        session(["cart" => $cartItems]);
        return back();
    }
}
