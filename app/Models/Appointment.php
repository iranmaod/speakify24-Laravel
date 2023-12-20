<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    protected $table = 'appointments';

    protected $fillable = [
        'title', 'instructor_id', 'course_id', 'lecture_id', 'user_id', 'startdate', 'enddate', 'status'
    ];
}
