<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, "order_no", "order_no")->with("product:id,name,image");
    }

    public function coupon(): HasOne
    {
        return $this->hasOne(Coupon::class, "id", "coupon_id");
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, "id", "user_id");
    }
}
