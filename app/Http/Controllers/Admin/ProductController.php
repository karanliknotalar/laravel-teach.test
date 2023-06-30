<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::where("products.status", "=", "1")
            ->join("categories", "products.category_id", "=", "categories.id")
            ->select(["categories.name as category_name", "products.*"])
            ->get();

        return view("admin.pages.product.index", compact("products"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.product.edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
//        return decrypt($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = decrypt($id);
        $product = Product::where("id", $id)->get()->firstOrFail();
        return view("admin.pages.product.edit", compact("product"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $product = Product::query()->where("id", "=", $id)->firstOrFail();

        if ($product) {

            if (count($request->all()) == 2) {

                $product->status = $request->only("status")["status"];
                $result = $product->save();
                return response(["result" => (bool)$result]);

            } else {

                $request->validate([
                    "name" => "required",
                    "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                ]);

                $imageName = isset($request->image) ? $this->getImgName($request) : null;
                $tempImg = $product->image;

                $result = $product->update([
                    "name" => $request["name"],
                    "content" => $request["content"] ?? "",
                    "image" => $imageName ?? $product->image,
                    "status" => $request["status"] == "on",
                    "shop_url" => $request["shop_url"] ?? "",
                ]);

                if (!empty($imageName) && $result) {
                    Helper::fileDelete($tempImg ?? null);
                    Helper::fileSave($request->image, $imageName);
                }

                return $result ?
                    back()->with("status", "Güncelleme işlemi başarılı.") :
                    back()->withErrors(["store", "Güncelleme işlemi sırasında hata oluştu."]);
            }

        } else
            return back()->withErrors(["db", "Veritabanında böyle bir kayıt yok veya getirilemedi."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $id = decrypt($id);

        $product = Product::query()->where("id", $id)->firstOrFail();
        $result = $product->delete();

        if ($result) Helper::fileDelete($product->image ?? null);

        return response(["result" => (bool)$result]);
    }
}
