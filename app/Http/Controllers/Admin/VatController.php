<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\VatRequest;
use App\Models\Vat;
use Exception;
use Illuminate\Routing\Controller;

class VatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vats = Vat::all();
        return view("admin.pages.vat.index", compact("vats"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.vat.edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(VatRequest $request)
    {
        $result = Vat::query()->create([
            "VAT" => $request["VAT"]
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
        $vat = Vat::where("id", $id)->firstOrFail();
        return view("admin.pages.vat.edit", compact("vat"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(VatRequest $request, string $id)
    {
        $id = decrypt($id);
        $vat = Vat::query()->where("id", "=", $id)->firstOrFail();

        if ($vat) {

            $result = $vat->update([
                "VAT" => $request["VAT"]
            ]);

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
            if ($id != 1 && $id != 2){
                $id = decrypt($id);
                $vat = Vat::where("id", $id)->firstOrFail();
                $result = $vat->delete();
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        } finally {
            return response(["result" => (bool)$result, "error" => $error]);
        }
    }
}
