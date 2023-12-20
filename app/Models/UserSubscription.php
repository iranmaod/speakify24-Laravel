<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    //
    protected $table = 'user_subscriptions';

    protected $fillable = [
        'user_id', 'course_id', 'instructor_id', 'plan_id', 'payment_id', 'token', 'payment_status', 'start_date', 'next_billing'
    ];
}
