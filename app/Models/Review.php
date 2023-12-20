<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    //
    protected $table = 'reviews';

    protected $fillable = [
        'instructor_id', 'user_id', 'course_id', 'rating', 'review'
    ];
}
