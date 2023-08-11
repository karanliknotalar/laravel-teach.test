<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Requests\Admin\SliderFormRequest;
use App\Models\Slider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::query()->orderBy("updated_at", "desc")->get();

        return view("admin.pages.slider.index", compact("sliders"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.slider.edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderFormRequest $request)
    {
        $imageName = Helper::getFileName($request->name, $request->image, "images/sliders/");

        $request["status"] = $request->status == "on";

        $result = Slider::query()->create([
            "name" => $request["name"],
            "content" => $request["content"] ?? null,
            "image" => $imageName,
            "shop_url" => $request["shop_url"] ?? null,
            "status" => $request["status"],
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

        $slider = Slider::query()->where("id", $id)->firstOrFail();

        return view("admin.pages.slider.edit", compact("slider"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderFormRequest $request, string $id)
    {
        $id = decrypt($id);
        $slider = Slider::query()->where("id", "=", $id)->firstOrFail();

        if ($slider) {

            $imageName = Helper::getFileName($request->name, $request->image, "images/sliders/");
            $tempImg = $slider->image;

            $result = $slider->update([
                "name" => $request["name"],
                "content" => $request["content"] ?? "",
                "image" => $imageName ?? $slider->image,
                "status" => $request["status"] == "on",
                "shop_url" => $request["shop_url"] ?? "",
            ]);

            if (!empty($imageName) && $result) {
                Helper::fileDelete($tempImg ?? null);
                Helper::fileSave($request->image, $imageName);
            }

            return $result ?
                back()->with("status", "Güncelleme işlemi başarılı.") :
                back()->withErrors(["Güncelleme işlemi sırasında hata oluştu."]);

        } else
            return back()->withErrors(["Veritabanında böyle bir kayıt yok veya getirilemedi."]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $error = null;
        $result = false;

        try {
            $id = decrypt($id);
            $slider = Slider::where("id", $id)->firstOrFail();
            $result = $slider->delete();

            if ($result) Helper::fileDelete($slider->image ?? null);

        } catch (Exception $e) {

            $error = $e->getMessage();
        } finally {

            return response(["result" => (bool)$result, "error" => $error]);
        }
    }

    public function update_status(Request $request, $id)
    {
        $id = decrypt($id);
        $slider = Slider::query()->where("id", "=", $id)->firstOrFail();

        if ($slider) {

            $slider->status = $request->only("status")["status"];
            $result = $slider->save();
            return response(["result" => (bool)$result]);

        } else
            return response(["result" => false]);
    }

}
