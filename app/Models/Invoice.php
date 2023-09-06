<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        "user_id",
        "coupon_id",
        "order_no",
        "amount_paid",
        "payment_method",
        "payment_status",
        "country",
        "f_name",
        "l_name",
        "company_name",
        "address",
        "province",
        "district",
        "email",
        "phone",
        "order_status",
    ];
}
