<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CouponRequest;
use App\Models\Coupon;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::get();
        return view("admin.pages.coupon.index", compact("coupons"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.coupon.edit");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CouponRequest $request)
    {
        $result = Coupon::create([
            "name" => $request["name"],
            "price" => $request["price"],
            "expired_at" => $request["expired_at"],
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

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = decrypt($id);
        $coupon = Coupon::where("id", $id)->firstOrFail();

        return view("admin.pages.coupon.edit", compact("coupon"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CouponRequest $request, string $id)
    {
        $id = decrypt($id);
        $coupon = Coupon::query()->where("id", "=", $id)->firstOrFail();

        if ($coupon) {

            $result = $coupon->update([
                "name" => $request["name"],
                "price" => $request["price"],
                "expired_at" => $request["expired_at"],
                "status" => $request["status"] == "on",
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
            $id = decrypt($id);

            $result = Coupon::where("id", $id)->firstOrFail()->delete();

        } catch (Exception $e) {

            $error = $e->getMessage();
        } finally {

            return response(["result" => (bool)$result, "error" => $error]);
        }
    }
    public function update_status(Request $request, $id)
    {
        $id = decrypt($id);
        $coupon = Coupon::query()->where("id", "=", $id)->firstOrFail();

        if ($coupon) {

            $coupon->status = $request->only("status")["status"];
            $result = $coupon->save();
            return response(["result" => (bool)$result]);

        } else
            return response(["result" => false]);
    }
}
