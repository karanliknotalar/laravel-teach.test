<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("category_id");
            $table->string("name");
            $table->string("slug_name");
            $table->string("image")->nullable();
            $table->longText("description")->nullable();
            $table->text("sort_description")->nullable();
            $table->double("price", 10, 2);
            $table->string("size", 50);
            $table->string("color", 50);
            $table->integer("quantity")->default(0);
            $table->tinyInteger("status")->default(0);
            $table->timestamps();

            $table->foreign("category_id")->on("categories")->references("id");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
