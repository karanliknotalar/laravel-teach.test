<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("coupon_id")->nullable();
            $table->string("order_no")->unique();
            $table->double("amount_paid", 10, 2);
            $table->string("payment_method")->nullable();
            $table->tinyInteger("payment_status")->default(0);
            $table->string("country")->nullable();
            $table->string("f_name")->nullable();
            $table->string("l_name")->nullable();
            $table->string("company_name")->nullable();
            $table->string("address")->nullable();
            $table->string("province")->nullable();
            $table->string("district")->nullable();
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->tinyInteger("order_status")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
