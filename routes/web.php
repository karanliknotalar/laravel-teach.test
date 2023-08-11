<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductQuantityController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\ProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::fallback(function () {
    return back();
});

Route::get("/", [HomeController::class, "index"])->name("home.index");

Route::get("/indirimdeki-urunler", [PageController::class, "products"])->name("page.indirimdeki-urunler");

Route::get("/urunler/{category?}/{id?}/{sub_category?}", [ProductsController::class, "products"])->name("page.products");
//Route::get("/urunler/{category?}/{id?}", [ProductsController::class, "products"])->name("page.products_with_category");

Route::get("/urun/{slug_name}", [ProductController::class, "product"])->name("page.product");
Route::post("/urun/size", [ProductController::class, "size"])->name("product.size");
Route::post("/urun/color", [ProductController::class, "color"])->name("product.color");


Route::get("/hakkimizda", [PageController::class, "about"])->name("page.about");
Route::get("/iletisim", [PageController::class, "contact"])->name("page.contact");
Route::post("/iletisim", [AjaxController::class, "contact_post"])->name("page.contact_post");
Route::get("/user-logout", [UserAuthController::class, "user_logout"])->name("user-auth.user_logout");

Route::group(["prefix" => "/sepet"], function () {
    Route::get("/", [CartController::class, "cart"])->name("page.cart");
    Route::post("/ekle", [CartController::class, "addCart"])->name("cart.add-cart");
    Route::post("/sil", [CartController::class, "removeCart"])->name("cart.remove-cart");
    Route::post("/guncelle", [CartController::class, "updateCartQuantity"])->name("cart.update-cart-quantity");
    Route::post("/kupon-ekle", "Front\CartController@addCoupon")->name("cart.add-coupon");
});

Route::group(["middleware" => "guest"], function () {
    Route::get("/login", [AdminAuthController::class, "login"])->name("login");
    Route::post("/login", [AdminAuthController::class, "login_auth"])->name("auth.login");

    Route::get("/user-login", [UserAuthController::class, "user_login"])->name("auth.user_login");
    Route::post("/user-login", [UserAuthController::class, "user_login_post"]);

    Route::get("/user-register", [UserAuthController::class, "user_register"])->name("auth.user_register");
    Route::post("/user-register", [UserAuthController::class, "user_register_post"]);

    Route::get("/password-reset", [UserAuthController::class, "password_reset"])->name("password.reset");
    Route::post("/password-reset", [UserAuthController::class, "password_reset"]);

    Route::post("/password-update", [UserAuthController::class, "password_update"])->name("user-auth.password_update");
});

Route::group(["prefix" => "admin", "middleware" => ["admin.dashboard.shared", "auth", "isAdmin"]], function () {
    Route::get("/", [DashboardController::class, "index"])->name("dashboard.index");
    Route::get("/logout", [AdminAuthController::class, "logout"])->name("admin-auth.logout");

    Route::resource("slider", "Admin\SliderController")->except("show");
    Route::resource("product", "Admin\ProductController")->except("show");
    Route::resource("category", "Admin\CategoryController")->except("show");
    Route::resource("product-quantity", "Admin\ProductQuantityController")->except("update", "index");
    Route::resource("service", "Admin\ServiceController")->except("show");

    Route::post("product/update-status/{id}", "Admin\ProductController@update_status")->name("product.update-status");
    Route::post("slider/update-status/{id}", "Admin\SliderController@update_status")->name("slider.update-status");
    Route::post("category/update-status/{id}", "Admin\CategoryController@update_status")->name("category.update-status");
    Route::post("service/update-status/{id}", "Admin\ServiceController@update_status")->name("service.update-status");
    Route::post("coupon/update-status/{id}", "Admin\CouponController@update_status")->name("coupon.update-status");

    Route::get("about", [AboutController::class, "edit"])->name("about.edit");
    Route::post("about", [AboutController::class, "update"])->name("about.update");

    Route::resource("contact", "Admin\ContactController")->only("index", "show", "destroy");
    Route::resource("site-settings", "Admin\SiteSettingController")->except("show");
    Route::resource("coupon", "Admin\CouponController")->except("show");

});

