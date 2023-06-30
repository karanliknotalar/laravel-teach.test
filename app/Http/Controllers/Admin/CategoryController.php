<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::query()->with("base_category:id,name")->get();
        return view("admin.pages.category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $main_categories = Category::query()->where("parent_id", "=", null)->select(["name", "id"])->get();
        return view("admin.pages.category.edit", compact("main_categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $imageName = isset($request->image) ? $this->getImgName($request) : null;

        $is_main_category = $request->categoryType == "main";

        if ($is_main_category) $request->validate(["image" => 'required']);

        $result = Category::query()->create([
            "parent_id" => $is_main_category ? null : $request["parent_id"],
            "name" => $request["name"],
            "slug_name" => Str::slug($request["name"]),
            "description" => $request["description"] ?? null,
            "seo_description" => $request["seo_description"],
            "seo_keywords" => $request["seo_keywords"],
            "image" => $imageName,
            "status" => $request->status == "on",
        ]);

        if (!empty($imageName) && $result) Helper::fileSave($request->image, $imageName);

        return $result ?
            back()->with("status", "Kayıt işlemi başarılı.") :
            back()->withErrors(["Kayıt işlemi sırasında hata oluştu."]);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = decrypt($id);

        $main_categories = Category::query()->where("parent_id", "=", null)->select(["name", "id"])->get();
        $category = Category::query()->where("id", "=", $id)->firstOrFail();

        return view("admin.pages.category.edit", compact("main_categories", "category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $category = Category::query()->where("id", "=", $id)->firstOrFail();

        if ($category) {

            if (count($request->all()) == 2) {

                $category->status = $request->only("status")["status"];
                $result = $category->save();
                return response(["result" => (bool)$result]);

            } else {

                $request->validate([
                    "name" => "required",
                    "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                    "categoryType" => "required",
                    "status" => "required",
                ]);

                $imageName = isset($request->image) ? $this->getImgName($request) : null;
                $tempImg = $category->image;
                $is_main_category = $request->categoryType == "main";

                if ($is_main_category) {
                    $request->validate(["image" => 'required']);
                } else {
                    $request->validate(["parent_id" => 'required|numeric']);
                }

                $result = $category->update([
                    "parent_id" => $is_main_category ? null : $request["parent_id"],
                    "name" => $request["name"],
                    "slug_name" => Str::slug($request["name"]),
                    "description" => $request["description"] ?? null,
                    "seo_description" => $request["seo_description"],
                    "seo_keywords" => $request["seo_keywords"],
                    "image" => $imageName ?? $category->image,
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
        $category = Category::query()->where("id", $id)->firstOrFail();
        $result = $category->delete();

        if ($result) Helper::fileDelete($category->image ?? null);

        return response(["result" => (bool)$result]);
    }

    public function getImgName($request): string
    {
        return Helper::getFileFullPath("images/categories/", $request->name, $request->image);
    }
}
