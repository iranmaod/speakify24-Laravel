<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentsCredits extends Model
{
    protected $table = 'students_credits';
    protected $fillable = [
        'user_id','total_hours', 'hours', 'lang_id', 'start_time', 'end_time', 'weekly_hours', 'canc_credits','cancelled'
    ];
}
