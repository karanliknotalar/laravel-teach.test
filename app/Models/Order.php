<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "user_id",
        "product_id",
        "order_no",
        "product_code",
        "price",
        "size",
        "color",
        "quantity",
    ];
}
