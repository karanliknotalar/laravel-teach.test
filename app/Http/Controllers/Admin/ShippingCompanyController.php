<?php

namespace App\Http\Controllers\Admin;

use App\Models\ShippingCompany;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ShippingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipping_companies = ShippingCompany::all();
        return view("admin.pages.shipping_company.index", compact("shipping_companies"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $result = ShippingCompany::create([
            "name" => $request["name"],
            "tracking_url" => $request["tracking_url"],
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
        $shipping_companies = ShippingCompany::all();
        $shipping_company = ShippingCompany::where("id", $id)->first();
        return view("admin.pages.shipping_company.index", compact("shipping_companies", "shipping_company"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $shippingCompany = ShippingCompany::where("id", "=", $id)->first();

        if ($shippingCompany) {

            $result = $shippingCompany->update([
                "name" => $request["name"],
                "tracking_url" => $request["tracking_url"],
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
                $shippingCompany = ShippingCompany::where("id", $id)->first();
                $result = $shippingCompany->delete();
            }
        } catch (Exception $e) {
            $error = $e->getMessage();
        } finally {
            return response(["result" => (bool)$result, "error" => $error]);
        }
    }

    public function update_status(Request $request, $id)
    {
        $id = decrypt($id);
        $service = ShippingCompany::where("id", "=", $id)->first();

        if ($service) {

            $service->status = $request->only("status")["status"];
            $result = $service->save();
            return response(["result" => (bool)$result]);

        } else
            return response(["result" => false]);
    }
}
