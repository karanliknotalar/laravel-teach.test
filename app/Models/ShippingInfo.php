<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingInfo extends Model
{
    protected $fillable = [
        "invoice_id",
        "shipping_companies_id",
        "tracking_number",
    ];
}
