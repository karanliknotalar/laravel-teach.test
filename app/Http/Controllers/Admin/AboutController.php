<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class AboutController extends Controller
{
    public function edit()
    {
        $about = About::firstOrFail();
        return view("admin.pages.about.edit", compact("about"));
    }

    public function update(Request $request)
    {
//        return $request->all();
        $about = About::firstOrFail();

//        return $about;

        $imageName = Helper::getFileName($request->title, $request->image, "images/about/");

        $tempImg = $about->image;

        $result = $about->update([
            "title" => $request["title"],
            "content" => $request["content"] ?? "",
            "image" => $imageName ?? $about->image,
            "channel" => $request["channel"] ?? "",
        ]);

        if (!empty($imageName) && $result) {
            Helper::fileDelete($tempImg ?? null);
            Helper::fileSave($request->image, $imageName);
        }

        return $result ?
            back()->with("status", "Güncelleme işlemi başarılı.") :
            back()->withErrors(["Güncelleme işlemi sırasında hata oluştu."]);
    }

}
