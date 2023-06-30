<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductQuantity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductQuantitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::select("id")->get();

        foreach ($products as $product) {

            for ($i = 0; $i < 3; $i++) {

                ProductQuantity::create([
                    "product_id" => $product->id,
                    "price" => [random_int(100, 9999), random_int(100, 9999), random_int(100, 9999), random_int(100, 9999)][random_int(0, 3)],
                    "size" => ["S", "M", "L", "X"][random_int(0, 3)],
                    "color" => ["Kırmızı", "Mavi", "Yeşil", "Sarı"][random_int(0, 3)],
                    "quantity" => random_int(1, 99),
                ]);
            }
        }
    }
}
