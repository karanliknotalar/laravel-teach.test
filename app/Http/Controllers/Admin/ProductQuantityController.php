<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $product_id = $request->id ?? null;

        return view("admin.pages.quantity.create", compact("product_id"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        return decrypt();

        $request->validate([
            "price.*" => 'required|min:1|decimal:2',
            "size.*" => 'required|min:1',
            "color.*" => 'required|min:1',
            "quantity.*" => 'required|min:1',
            "product_id" => "required",
        ]);

        $product_id = decrypt($request->product_id);
        $check = Product::where("id", $product_id)->select("id");

        if ($check) {
            for ($i = 0; $i < count($request["size"]); $i++) {

                $checkQuantity = ProductQuantity::where("size", $request["size"][$i])->where("color", $request["color"][$i])->first("id");

                if (!$checkQuantity) {
                    ProductQuantity::create([
                        "product_id" => $product_id,
                        "price" => $request["price"][$i],
                        "size" => $request["size"][$i],
                        "color" => $request["color"][$i],
                        "quantity" => $request["quantity"][$i],
                    ]);
                } else {
                    return back()->withErrors(["Bu renk: " . $request["color"][$i] . " ve beden: " . $request["size"][$i] . " mevcut"]);
                }
            }
        }

        return $check ?
            back()->with("status", "Ekleme işlemi başarılı.") :
            back()->withErrors(["Ekleme işlemi sırasında hata oluştu."]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $quantities = ProductQuantity::query()->where("product_id", decrypt($id))->with("product:id,name")->get();
        return view("admin.pages.quantity.index", compact("quantities"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = decrypt($id);

        $product = ProductQuantity::query()->where("id", $id)->firstOrFail();
        $result = $product->delete();

        return response(["result" => (bool)$result]);
    }
}
