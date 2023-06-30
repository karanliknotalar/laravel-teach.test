<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ServiceRequest;
use App\Models\Service;
use Illuminate\Routing\Controller;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();

        return view("admin.pages.service.index", compact("services"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.service.edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {

        $result = Service::create([
            "title" => $request["title"],
            "content" => $request["content"] ?? null,
            "icon" => $request["icon"] ?? null,
            "status" => $request["status"] == "on",
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
        $service = Service::where("id", $id)->firstOrFail();

        return view("admin.pages.service.edit", compact("service"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceRequest $request, string $id)
    {
        $id = decrypt($id);
        $service = Service::query()->where("id", "=", $id)->firstOrFail();

        if ($service) {

            if (count($request->all()) == 2) {

                $service->status = $request->only("status")["status"];
                $result = $service->save();
                return response(["result" => (bool)$result]);

            } else {

                $result = $service->update([
                    "title" => $request["title"],
                    "content" => $request["content"] ?? null,
                    "icon" => $request["icon"] ?? null,
                    "status" => $request["status"] == "on",
                ]);

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

        $slider = Service::query()->where("id", $id)->firstOrFail();
        $result = $slider->delete();

        return response(["result" => (bool)$result]);
    }
}
