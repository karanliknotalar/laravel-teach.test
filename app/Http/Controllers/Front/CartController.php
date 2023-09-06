<?php

namespace App\Http\Controllers\Front;

use App\Helper\Helper;
use App\Http\Requests\InvoiceRequest;
use App\Models\Coupon;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductQuantity;
use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;

class CartController extends Controller
{

    public function cart()
    {
        $cartItems = session("cart", []);
        $totalPrice = 0;
        $unsetting_product = [];

        foreach ($cartItems as $cartId => $cartItem) {

            if (Product::where("id", $cartItem["product_id"])->exists() && ProductQuantity::where([["id", "=", $cartItem["product_quantity_id"]], ["quantity", ">=", $cartItem["quantity"]]])->exists()) {

                if (isset($cartItem["price"]) && isset($cartItem["quantity"])) {
                    $total = Helper::getVatIncluded($cartItem["price"], $cartItem["vat"]);
                    $totalPrice += $total * $cartItem["quantity"];
                }
            } else {
                $unsetting_product[$cartId] = $cartItem;
                unset($cartItems[$cartId]);
            }
        }
        if (session()->has("coupon")) {

            $second = Helper::timeToSecond(session("coupon")["expired_at"]);
            if ($second > 0 && count($cartItems) > 0 && $totalPrice > session("coupon")["price"]) {
                $totalPrice -= session("coupon")["price"];
            } else {
                session()->forget("coupon");
            }
        }
        session(["cart" => $cartItems]);

        $compact = compact("cartItems", "totalPrice", "unsetting_product");

        session(["totalPrice" => $totalPrice]);

        if (Route::is("cart.order") && !empty(session("cart")))
            return view("front.pages.order", $compact);

        return view("front.pages.cart", $compact);
    }

    public function addCart(Request $request)
    {
        $product_id = decrypt($request->product_id);
        $quantity = $request->quantity;
        $size = $request->size;
        $color = $request->color;

        $cartItems = session("cart", []);

        if (Product::where("id", $product_id)->exists()) {

            if ($productQuantity = ProductQuantity::where([["product_id", "=", $product_id], ["size", "=", $size], ["color", "=", $color], ["quantity", ">=", $quantity]])->first()) {

                $cartId = $product_id . "_" . $productQuantity->id;

                if (array_key_exists($cartId, $cartItems)) {

                    $tempStok = $cartItems[$cartId]["quantity"];
                    if ($productQuantity->quantity < $tempStok || $productQuantity->quantity < ($tempStok + $quantity))
                        return response(["success" => false, "error" => "stok", "message" => "stok yetersiz"]);

                    $cartItems[$cartId]["quantity"] += $quantity;

                } else {

                    $product = Product::where("id", $product_id)->with("vat:id,VAT")->first();

                    $cartItems[$cartId] = [
                        "name" => $product->name,
                        "slug_name" => $product->slug_name,
                        "image" => $product->image,
                        "price" => $productQuantity->price,
                        "quantity" => (int)$request->quantity,
                        "size" => $size,
                        "color" => $color,
                        "product_id" => $product_id,
                        "product_quantity_id" => $productQuantity->id,
                        "product_code" => $product->product_code,
                        "vat" => $product->vat->VAT
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

    public function addCoupon(Request $request)
    {
        $coupon = Coupon::where("name", $request->coupon_name ?? "")->where("status", 1)->first();

        if ($coupon) {

            $second = Helper::timeToSecond($coupon->expired_at);

            if (session()->has("coupon") && session("coupon")["name"] == $coupon->name) {
                return back()->with("status", "Kupon zaten ekli");
            }
            if ($second > 0) {
                session(["coupon" => ["price" => $coupon->price, "name" => $coupon->name, "expired_at" => $coupon->expired_at]]);
            } else {
                session()->forget("coupon");
                return back()->withErrors(["Kupon sona ermiş."]);
            }

        } else {
            session()->forget("coupon");
            return back()->withErrors(["Böyle bir kupon mevcut değil."]);
        }
        return back()->with("status", "Kupon Eklendi");
    }

    public function orderComplete(InvoiceRequest $request)
    {
        $user = $request->only("email");

        if (!Auth::check()) {

            if (!User::where("email", $request->email)->exists()) {
                $user = $request->only("email");
                $user["name"] = $request->f_name . " " . $request->l_name;
                $user["password"] = bcrypt($request->password);
                $user["status"] = 1;
                $user["agreement"] = 1;
                $user = User::create($user);
            } else {
                return back()->withErrors(["Bu mail ile kayıtlı üye mevcut."]);
            }
        }

        $invoice = Invoice::create([
            "user_id" => Auth::user()->id ?? $user->id,
            "order_no" => Helper::generateUniqOrderNo(10),
            "amount_paid" => session("totalPrice"),
            "country" => $request->country ?? "",
            "f_name" => $request->f_name ?? "",
            "l_name" => $request->l_name ?? "",
            "company_name" => $request->company_name ?? "",
            "address" => $request->address ?? "",
            "province" => $request->province ?? "",
            "district" => $request->district ?? "",
            "email" => $request->email ?? "",
            "phone" => $request->phone ?? "",
        ]);

        if ($invoice) {
            $cartItems = session("cart", []);
            foreach ($cartItems as $cartItem) {

                Order::create([
                    "user_id" => $invoice->user_id,
                    "product_id" => $cartItem["product_id"],
                    "order_no" => $invoice->order_no,
                    "product_code" => $cartItem["product_code"],
                    "price" => Helper::getVatIncluded($cartItem["price"], $cartItem["vat"]),
                    "size" => $cartItem["size"],
                    "color" => $cartItem["color"],
                    "quantity" => $cartItem["quantity"],
                ]);
            }
            session()->forget("cart");
            session()->forget("coupon");
            session()->forget("totalPrice");
        }
        return redirect(route("home.index"));
    }
}
