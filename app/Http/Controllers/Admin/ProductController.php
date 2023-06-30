<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Requests\Admin\ProductFormRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Str;

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
    public function store(ProductFormRequest $request)
    {

        $imageName = isset($request->image) ? $this->getImgName($request) : null;

        $result = Product::create([
            "category_id" => $request["category_id"],
            "name" => $request["name"],
            "slug_name" => Str::slug($request["name"]),
            "description" => $request["description"],
            "sort_description" => $request["sort_description"],
            "size" => $request["size"][0],
            "color" => $request["color"][0],
            "quantity" => $request["quantity"][0],
            "image" => $imageName,
            "status" => $request["status"] == "on",
        ]);

        if ($result) {

            for ($i = 0; $i < count($request["size"]); $i++) {
                ProductQuantity::create([
                    "product_id" => $result->id,
                    "price" => $request["price"][$i],
                    "size" => $request["size"][$i],
                    "color" => $request["color"][$i],
                    "quantity" => $request["quantity"][$i],
                ]);
            }
        }

        if (!empty($imageName) && $result) {
            Helper::fileSave($request->image, $imageName);
        }

        return $result ?
            back()->with("status", "Ekleme işlemi başarılı.") :
            back()->withErrors(["store", "Ekleme işlemi sırasında hata oluştu."]);
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
        $product = Product::query()->where("id", $id)->with("category:id,name")->firstOrFail();
        $categories = Category::select(["id", "name", "parent_id"])->get();

        return view("admin.pages.product.edit", compact("product", "categories"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request, string $id)
    {
        $id = decrypt($id);
        $product = Product::query()->where("id", "=", $id)->firstOrFail();

        if ($product) {

            if (count($request->all()) == 2) {

                $product->status = $request->only("status")["status"];
                $result = $product->save();
                return response(["result" => (bool)$result]);

            } else {

                $imageName = isset($request->image) ? $this->getImgName($request) : null;
                $tempImg = $product->image;

                $result = $product->update([
                    "category_id" => $request["category_id"],
                    "name" => $request["name"],
                    "slug_name" => Str::slug($request["name"]),
                    "description" => $request["description"],
                    "sort_description" => $request["sort_description"],
                    "image" => $imageName ?? $product->image,
                    "status" => $request["status"] == "on",
                ]);

                if (!empty($imageName) && $result) {
                    Helper::fileDelete($tempImg ?? null);
                    Helper::fileSave($request->image, $imageName);
                }

                return $result ?
                    back()->with("status", "Güncelleme işlemi başarılı.") :
                    back()->withErrors(["Güncelleme işlemi sırasında hata oluştu."]);
            }

        } else
            return back()->withErrors(["Veritabanında böyle bir kayıt yok veya getirilemedi."]);
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

    public function getImgName($request): string
    {
        return Helper::getFileFullPath("images/products/", $request->name, $request->image);
    }
}
