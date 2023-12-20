<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Instructor extends Model
{
    protected $table = 'instructors';
    protected $guarded = array();

    
    public function courses()
    {
        return $this->hasMany('App\Models\Course', 'instructor_id', 'id');
    }
	public function jobs()
    {
        return $this->hasMany('App\Models\Job', 'instructor_id', 'id');
    }
	public function educations()
    {
        return $this->hasMany('App\Models\Education', 'instructor_id', 'id');
    }
	
	public static function postJobDelete($id){
		
		\DB::table('instructor_jobs')->where('id', '=', $id)->delete();
		
	}
	public static function postEduDelete($id){
		
		\DB::table('instructor_educations')->where('id', '=', $id)->delete();
		
	}
	
	public  function insertJobRow($data,$id){	
       
       $table = 'instructor_jobs';
	   $key = 'id';
	    if($id == NULL )
        {
			 $data['createdOn'] = date("Y-m-d H:i:s");	
			 $data['updatedOn'] = date("Y-m-d H:i:s");	
			 $id = \DB::table( $table)->insertGetId($data);
            
        } else {
            // Update here 
			// update created field if any
			if(isset($data['createdOn'])) unset($data['createdOn']);	
			if(isset($data['updatedOn'])) $data['updatedOn'] = date("Y-m-d H:i:s");			
			 \DB::table($table)->where($key,$id)->update($data);
        }    
        return $id;    
	}
	
	public  function insertEduRow($data,$id){	
       
       $table = 'instructor_educations';
	   $key = 'id';
	    if($id == NULL )
        {
			 $data['createdOn'] = date("Y-m-d H:i:s");	
			 $data['updatedOn'] = date("Y-m-d H:i:s");	
			 $id = \DB::table( $table)->insertGetId($data);
            
        } else {
            // Update here 
			// update created field if any
			if(isset($data['createdOn'])) unset($data['createdOn']);	
			if(isset($data['updatedOn'])) $data['updatedOn'] = date("Y-m-d H:i:s");			
			 \DB::table($table)->where($key,$id)->update($data);
        }    
        return $id;    
	}

    public static function metrics($instructor_id)
    {
        $metrics = array();
        $metrics['courses'] = \DB::table('courses')->where('instructor_id', 'like', '%"'.$instructor_id.'"%')->count();
        $metrics['lectures'] = \DB::table('courses')
                                ->where('courses.instructor_id', 'like', '%"'.$instructor_id.'"%')
                                ->leftJoin('curriculum_sections', 'curriculum_sections.course_id', '=', 'courses.id')                       
                                ->leftJoin('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
                                ->count();
        $metrics['videos'] = \DB::table('courses')
                                ->where('courses.instructor_id', 'like', '%"'.$instructor_id.'"%')
                                ->where('curriculum_lectures_quiz.media_type', 0)
                                ->leftJoin('curriculum_sections', 'curriculum_sections.course_id', '=', 'courses.id')                       
                                ->leftJoin('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
                                ->count();
        return $metrics;
    }

    public static function admin_metrics()
    {
        $metrics = array();
        $metrics['courses'] = \DB::table('courses')->count();
        $metrics['students'] = \DB::table('users')
                                ->where('roles.name', 'student')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')                       
                                ->count();
        $metrics['instructors'] = \DB::table('users')
                                ->where('roles.name', 'instructor')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')                       
                                ->count();
        $metrics['pending_teacher'] = \DB::table('users')
                                ->where('roles.name', 'instructor')
                                ->where('users.is_active', '0')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')                       
                                ->count();
        $metrics['active_teacher'] = \DB::table('users')
                                ->where('roles.name', 'instructor')
                                ->where('users.is_active', '1')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')                       
                                ->count();
        $metrics['denied_teacher'] = \DB::table('users')
                                ->where('roles.name', 'instructor')
                                ->where('users.is_active', '3')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')                       
                                ->count();
        $metrics['inactive_teacher'] = \DB::table('users')
                                ->where('roles.name', 'instructor')
                                ->where('users.is_active', '2')
                                ->leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
                                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')                       
                                ->count();
        return $metrics;
    }
}
