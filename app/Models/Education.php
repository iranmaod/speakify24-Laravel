<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $table = 'instructor_educations';
    protected $guarded = array();
	
	public function country()
    {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }
}
