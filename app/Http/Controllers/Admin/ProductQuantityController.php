<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Helper;
use App\Http\Requests\Admin\ProductQuantityFormRequest;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\ProductQuantity;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProductQuantityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product_id = decrypt($request->product_id);

        $quantities = ProductQuantity::where('product_quantities.product_id', $product_id)
            ->leftJoin('product_media', function ($join) {
                $join->on('product_quantities.product_id', '=', 'product_media.product_id')
                    ->on('product_quantities.color', '=', 'product_media.color');
            })
            ->select(['product_quantities.*', DB::raw('IFNULL(product_media.images, "[]") as images')])
            ->get();
        if (count($quantities) == 0){

            return view("admin.pages.quantity.edit", compact("product_id"));
        }

        return view("admin.pages.quantity.index", compact("quantities"));
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
        $check = Product::where("id", $product_id)->select("id")->exists();

        if ($check) {

            for ($i = 0; $i < count($request["size"]); $i++) {

                if ($productQuantity = ProductQuantity::where([["product_id", "=", $product_id], ["size", "=", $request["size"][$i]], ["color", "=", $request["color"][$i]]])->first()) {

                    $productQuantity->update([
                        "price" => $request["price"][$i],
                        "size" => $request["size"][$i],
                        "color" => $request["color"][$i],
                        "quantity" => $request["quantity"][$i],
                    ]);

                } else {

                    ProductQuantity::create([
                        "product_id" => $product_id,
                        "price" => $request["price"][$i],
                        "size" => $request["size"][$i],
                        "color" => $request["color"][$i],
                        "quantity" => $request["quantity"][$i],
                    ]);
                }

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

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product_id = decrypt($id);
        $quantities = ProductQuantity::query()->where("product_id", $product_id)->with("product:id,name")->get();
        return view("admin.pages.quantity.edit", compact("quantities","product_id"));
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
        $result = null;

        try {
            $id = decrypt($id);
            $product_quantity = ProductQuantity::where("id", $id)->first();

            if ($product_quantity){

                $similar_rows_count = ProductQuantity::where('product_id', $product_quantity->product_id)
                    ->where('color', $product_quantity->color)
                    ->count();

                if ($similar_rows_count == 1){

                    $product_media = ProductMedia::where(["product_id" => $product_quantity->product_id, "color" => $product_quantity->color])->first();

                    if ($product_media){
                        $img_arr = json_decode($product_media->images, true);

                        foreach ($img_arr as $img){
                            Helper::fileDelete($img, true);
                        }

                        $product_media->delete();
                    }
                }
                $result = $product_quantity->delete();
            }

        } catch (Exception $e) {
            $error = $e->getMessage();
        }
        finally {
            return response(["result" => (bool)$result, "error" => "error"]);
        }
    }
}
