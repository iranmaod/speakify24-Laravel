<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponUsed extends Model
{
    //
    protected $table = 'coupon_used';

    protected $fillable = [
        'coupon_id', 'user_id'
    ];
}
