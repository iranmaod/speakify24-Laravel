<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursePrices extends Model {

	protected $table 		= 'course_prices';
	protected $primaryKey 	= 'id';

	public $timestamps = false;
			
	public function __construct() {
		parent::__construct();
	}

	public function getDateFormat()
    {
        return 'U';
    }

    public function user(){
    	return $this->belongsTo('User');
    }
}