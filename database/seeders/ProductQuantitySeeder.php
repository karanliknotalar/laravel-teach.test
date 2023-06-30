<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Database\Seeder;

class ProductQuantitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::select("id", "name")->get();
        $count = 1;

        foreach ($products as $product) {

            for ($i = 0; $i < $count; $i++) {

                $size = ["S", "M", "L"][random_int(0, 2)];
                $color = ["Kırmızı", "Mavi", "Yeşil"][random_int(0, 2)];

                ProductQuantity::create([
                    "product_id" => $product->id,
                    "price" => [random_int(100, 9999), random_int(100, 9999), random_int(100, 9999), random_int(100, 9999)][random_int(0, 3)],
                    "size" => $size,
                    "color" => $color,
                    "quantity" => random_int(1, 10),
                ]);

                if ($count == 1){
                    $products->where("id", $product->id)->first()->update([
                        "name" => $product->name . " _ " . $size . " _ " . $color
                    ]);
                }

            }
        }
    }
}
