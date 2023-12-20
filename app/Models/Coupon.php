<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    //
    protected $table = 'coupons';

    protected $fillable = [
        'name', 'code', 'discount', 'type', 'number_of_usage', 'used', 'startdate', 'enddate', 'status'
    ];
}
