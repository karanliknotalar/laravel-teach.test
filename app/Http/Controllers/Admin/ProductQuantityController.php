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

        return view("admin.pages.quantity.edit", compact("product_id"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            "price.*" => 'required|min:1',
            "size.*" => 'required|min:1',
            "color.*" => 'required|min:1',
            "quantity.*" => 'required|min:1',
            "product_id" => "required",
        ]);

        $product_id = decrypt($request->product_id);
        $check = Product::where("id", $product_id)->select("id");

        $ProductQuantity = ProductQuantity::query()->where("product_id", $product_id);
        $result = $ProductQuantity->delete();

        if ($check && $result) {

            for ($i = 0; $i < count($request["size"]); $i++) {

                ProductQuantity::create([
                    "product_id" => $product_id,
                    "price" => $request["price"][$i],
                    "size" => $request["size"][$i],
                    "color" => $request["color"][$i],
                    "quantity" => $request["quantity"][$i],
                ]);

            }
        }

        return $check ?
            back()->with("status", "Kaydetme işlemi başarılı.") :
            back()->withErrors(["Kaydetme işlemi sırasında hata oluştu."]);

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
        $quantities = ProductQuantity::query()->where("product_id", decrypt($id))->with("product:id,name")->get();
        return view("admin.pages.quantity.edit", compact("quantities"));
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
