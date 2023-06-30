<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ProductQuantityFormRequest;
use App\Models\Product;
use App\Models\ProductQuantity;
use Exception;
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
    public function store(ProductQuantityFormRequest $request)
    {

        $product_id = decrypt($request->product_id);
        $check = Product::where("id", $product_id)->select("id");

        $productQuantity = ProductQuantity::query()->where("product_id", $product_id);
        $result = $productQuantity->delete();

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
        $error = null;
        $result = false;

        try {
            $id = decrypt($id);
            $result = ProductQuantity::where("id", $id)->firstOrFail()->delete();

        } catch (Exception $e) {

            $error = $e->getMessage();
        } finally {

            return response(["result" => (bool)$result, "error" => $error]);
        }
    }
}
