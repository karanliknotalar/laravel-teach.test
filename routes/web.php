<?php

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

Route::get("/urunler", [ProductController::class, "products"])->name("page.products");
Route::get("/urunler/{category}/{id}", [ProductController::class, "products"])->name("page.products_with_category");
Route::get("/urun/{id}/{slug_name}", [ProductController::class, "product"])->name("page.product");

Route::get("/hakkimizda", [PageController::class, "about"])->name("page.about");
Route::get("/iletisim", [PageController::class, "contact"])->name("page.contact");
Route::post("/iletisim", [AjaxController::class, "contact_post"])->name("page.contact_post");
Route::get("/user-logout", [UserAuthController::class, "user_logout"])->name("user-auth.user_logout");

Route::group(["prefix" => "/sepet"], function () {
    Route::get("/", [CartController::class, "cart"])->name("page.cart");
    Route::post("/ekle", [CartController::class, "add_cart"])->name("cart.add-cart");
    Route::post("/sil", [CartController::class, "remove_cart"])->name("cart.remove-cart");
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

    Route::resource("slider", "Admin\SliderController")->except("show")g;
    Route::resource("product", "Admin\ProductController")->except("show");
    Route::resource("category", "Admin\CategoryController")->except("show");
    Route::resource("product-quantity","Admin\ProductQuantityController")->except("update", "index");


});

