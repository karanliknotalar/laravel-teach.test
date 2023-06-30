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
        Schema::create('categories', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->string("name", 50);
            $table->string("slug", 100);
            $table->text("description")->nullable();
            $table->string("seo_description")->nullable();
            $table->string("seo_keywords")->nullable();
            $table->tinyInteger("status")->default(1);
            $table->string("image")->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign("parent_id")
                ->references("id")
                ->on("categories");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
