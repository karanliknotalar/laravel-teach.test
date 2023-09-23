<?php

namespace App\Http\Controllers\Admin;

use App\Models\Invoice;
use App\Models\Shipping;
use App\Models\ShippingCompany;
use App\Models\ShippingInfo;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::withCount("orders")->with("coupon:id,name,price")->paginate(10);
        return view("admin.pages.order.index", compact("invoices"));
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
//        return $request->all();

        $invoiceId = decrypt($request["invoice_id"]);

        $result = ShippingInfo::create([
            "invoice_id" => $invoiceId,
            "shipping_companies_id" => $request["shipping_companies_id"],
            "tracking_number" => $request["tracking_number"],
        ]);

        if ($result) {
            Invoice::where("id", $invoiceId)->update(["order_status" => 1]);
        }

        return $result ?
            back()->with("status", "Kayıt işlemi başarılı.") :
            back()->withErrors(["Kayıt işlemi sırasında hata oluştu."]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $id = decrypt($id);
        $invoice = Invoice::where("id", $id)
            ->with("orders")
            ->with("coupon:id,name,price")
            ->with("user:id,name,email")
            ->first();
        return view("admin.pages.order.detail", compact("invoice"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = decrypt($id);
        $invoice = Invoice::where("id", $id)->select("id")->first();
        $shippingInfo = ShippingInfo::where("invoice_id", $id)->first();
        $shippingCompanies = ShippingCompany::where("status", 1)->select(["id", "name"])->get();
        return view("admin.pages.order.edit", compact("invoice", "shippingInfo", "shippingCompanies"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);

        $result = ShippingInfo::where("id", $id)->update([
            "shipping_companies_id" => $request["shipping_companies_id"],
            "tracking_number" => $request["tracking_number"],
        ]);

        return $result ?
            back()->with("status", "Güncelleme işlemi başarılı.") :
            back()->withErrors(["Güncelleme işlemi sırasında hata oluştu."]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
