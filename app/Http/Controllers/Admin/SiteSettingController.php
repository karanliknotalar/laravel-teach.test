<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Models\SiteSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $site_settings = SiteSetting::get();
        return view("admin.pages.site_setting.index", compact("site_settings"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.site_setting.edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if ($request->ajax()) {
            $view = null;
            if ($request->type == "textarea") {
                $view = view("admin.pages.site_setting.helper.textarea")->render();
            } elseif ($request->type == "text" || $request->type == "email") {
                $view = view("admin.pages.site_setting.helper.text")->render();
            } elseif ($request->type == "image") {
                $view = view("admin.pages.site_setting.helper.image")->render();
            }
            return response(["html" => $view, "result" => true]);
        }

        $imageName = "";

        if ($request->hasFile("image")) {
            $imageName = Helper::getFileName($request->name, $request->image, "images/settings/");
            Helper::fileSave($request->image, $imageName);
        }

        $result = SiteSetting::create([
            "name" => $request->name,
            "content" => $request["content"] ?? $imageName,
            "type" => $request->type,
        ]);

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
        $site_setting = SiteSetting::where("id", $id)->first();
        return view("admin.pages.site_setting.edit", compact("site_setting"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);

        $site_setting = SiteSetting::where("id", $id)->first();

        $imageName = null;
        $tempImg = $site_setting->type == "image" && $request->type == "image" ? $site_setting->content : null;

        if ($request->hasFile("image")) {
            $imageName = Helper::getFileName($request->name, $request->image, "images/settings/");
            Helper::fileSave($request->image, $imageName);
            Helper::fileDelete($tempImg ?? null);
        } elseif ($request->type != "image")
            Helper::fileDelete($site_setting->content ?? null);

        $imageName = $imageName ?? $tempImg;

        $result = $site_setting->update([
            "name" => $request->name,
            "content" => $request["content"] ?? $imageName,
            "type" => $request->type,
        ]);

        return $result ?
            back()->with("status", "Kayıt işlemi başarılı.") :
            back()->withErrors(["Kayıt işlemi sırasında hata oluştu."]);
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
            $site_setting = SiteSetting::where("id", $id)->firstOrFail();
            $result = $site_setting->delete();

            if ($result) Helper::fileDelete($site_setting->type == "image" ? $site_setting->content : null);

        } catch (Exception $e) {

            $error = $e->getMessage();
        } finally {

            return response(["result" => (bool)$result, "error" => $error]);
        }

    }

}
