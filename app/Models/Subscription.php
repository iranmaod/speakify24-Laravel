<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    protected $table = 'subscription_plans';

    protected $fillable = [
        'name', 'description', 'price', 'hours', 'per_month', 'course_id', 'status', 'expiry'
    ];
}
