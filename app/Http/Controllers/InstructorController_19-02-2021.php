<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use App\Models\Role;
use App\Models\Language;
use App\Models\Job;
use App\Models\Education;
use App\Models\Country;
use App\Models\Instructor;
use App\Models\InstructionLevel;
use App\Models\Credit;
use App\Models\WithdrawRequest;
use Illuminate\Support\Facades\Validator;
use App\Library\ulearnHelpers;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;
use SiteHelpers;
use Crypt;
use URL;
use Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactInstructor;

class InstructorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->model = new Instructor();
    }

    public function instructorList()
    {
        $paginate_count = 8;
        
        $instructors = DB::table('instructors')->groupBy('instructors.id')->paginate($paginate_count);
        return view('site.instructors', compact('instructors'));
        
    }

    public function instructorView($instructor_slug = '', Request $request)
    {
        $instructor = Instructor::where('instructor_slug', $instructor_slug)->first();
        $metrics = Instructor::metrics($instructor->id);
        return view('site.instructor_view', compact('instructor', 'metrics'));
    }

    public function dashboard(Request $request)
    {
        $instructor_id = \Auth::user()->instructor->id;
        $courses = DB::table('courses')
                        ->select('courses.*', 'categories.name as category_name')
                        ->leftJoin('categories', 'categories.id', '=', 'courses.category_id')
                        ->where('courses.instructor_id', $instructor_id)
                        ->paginate(5);
        $metrics = Instructor::metrics($instructor_id);
        return view('instructor.dashboard', compact('courses', 'metrics'));
    }

    public function contactInstructor(Request $request)
    {
        $instructor_email = $request->instructor_email;
        Mail::to($instructor_email)->send(new ContactInstructor($request));
        return $this->return_output('flash', 'success', 'Thanks for your message, will contact you shortly', 'back', '200');
    }
    public function becomeInstructor(Request $request)
    {
        if(!\Auth::check()){
            return $this->return_output('flash', 'error', 'Please login to become an Instructor', 'back', '422');
        }

        $instructor = new Instructor();

        $instructor->user_id = \Auth::user()->id;
        $instructor->first_name = $request->input('first_name');
        $instructor->last_name = $request->input('last_name');
        $instructor->contact_email = $request->input('contact_email');

        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');

        //create slug only while add
        $slug = $first_name.'-'.$last_name;
        $slug = str_slug($slug, '-');

        $results = DB::select(DB::raw("SELECT count(*) as total from instructors where instructor_slug REGEXP '^{$slug}(-[0-9]+)?$' "));

        $finalSlug = ($results['0']->total > 0) ? "{$slug}-{$results['0']->total}" : $slug;
        $instructor->instructor_slug = $finalSlug;

        $instructor->telephone = $request->input('telephone');
        $instructor->paypal_id = $request->input('paypal_id');
        $instructor->biography = $request->input('biography');
        $instructor->save();

        $user = User::find(\Auth::user()->id);

        $role = Role::where('name', 'instructor')->first();
        $user->roles()->attach($role);
        
        return redirect()->route('instructor.dashboard') ;
    }

    public function getProfile(Request $request)
    {
        $instructor = Instructor::where('user_id', \Auth::user()->id)->first();
		$languages = Language::where('is_enabled', 1)->get();
		$countries = Country::get();
        //echo '<pre>';print_r($languages);exit;
        return view('instructor.profile', compact('instructor','languages','countries'));
    }
	
	public function getJob(Request $request)
    {
		$instructor = Instructor::where('user_id', \Auth::user()->id)->first();
		$jobs = Job::where('instructor_id', $instructor->id)->get();
		//$jobs = $this->model->jobs($instructor->id);
		//$languages = Language::where('is_enabled', 1)->get();
		//$countries = Country::get();
		//$this->data['course'] = 
        //echo '<pre>';print_r($jobs);exit;
        return view('instructor.job', compact('instructor','jobs'));
    }
	
	public function getEdu(Request $request)
    {
		$instructor = Instructor::where('user_id', \Auth::user()->id)->first();
		$works = Education::with('country')->where('instructor_id', $instructor->id)->get();
		$countries = Country::get();
       //echo '<pre>';print_r($works->language->title);exit;
        return view('instructor.work', compact('instructor','works','countries'));
    }
	
	public function postInstructorJObDelete(Request $request){
        $this->model->postJobDelete($request->input('jobid'));
        echo '1';
    }
	
	public function postInstructorEduDelete(Request $request){
        $this->model->postEduDelete($request->input('eduid'));
        echo '1';
    }
	public function postInstructorEduSave(Request $request)
    {   
        $data['instructor_id'] = $request->input('instructor_id');
		if($request->input('workid') == 0){
			if($request->hasFile('file_name')) {
				$document = $request->file('file_name');
				//print_r($document->getClientOriginalName());exit;
				$file_tmp_name = $document->getPathName();
				$file_name = explode('.',$document->getClientOriginalName());			   
				$file_type = $document->getClientOriginalExtension();
				$file_title = $document->getClientOriginalName();
				$file_size = $document->getSize();
				$file_name = $file_name[0].'_'.time().rand(4,9999);
				$data['file_name'] = $file_name.'.'.$file_type;				
				//$request->file('file_name')->storeAs('education/'.$newID, $file_name.'.'.$file_type);
			 }
		}		 
        //$data['file_name'] = 'education/'.$lid.'/'.$file_name.'.'.$file_type;		
        $data['school'] = $request->input('school');
        $data['degree'] = $request->input('degree');
		$data['major'] = $request->input('major');
        $data['city'] = $request->input('city');
		$data['country_id'] = $request->input('country_id');
        //$data['degree'] = $request->input('degree');
		$data['startdate'] = $request->input('start_date');
		$data['enddate'] = $request->input('end_date');
		//$data['description'] = $request->input('description');
        $now_date = date("Y-m-d H:i:s");
        $data['createdOn'] = $now_date;
        $data['updatedOn'] = $now_date;
        
        if($request->input('workid') == 0){
			Session::flash('success','Education Added Suucessfully!');
            $newID = $this->model->insertEduRow($data , '');
			if($request->hasFile('file_name')) {
				$request->file('file_name')->storeAs('education/'.$newID, $file_name.'.'.$file_type);
			 }
        } else {
			//Session::flash('success','Education Updated Suucessfully!');
            $newID = $this->model->insertEduRow($data , $request->input('workid'));
        }
		
		 		
        echo $newID;
    }
	
	public function postInstructorEduDocSave($lid,Request $request)
    {   
            //$education_id = $request->input('work_id');
			$ulearn = new ulearnHelpers();
            $document = $request->file('lectureres');
			//print_r($lid);exit;
            $file_tmp_name = $document->getPathName();
            $file_name = explode('.',$document->getClientOriginalName());
            $file_name = $file_name[0].'_'.time().rand(4,9999);
            $file_type = $document->getClientOriginalExtension();
            $file_title = $document->getClientOriginalName();
            $file_size = $document->getSize();
            
            /*if($file_type == 'pdf'){
                $pdftext = file_get_contents($document);
                $pdfPages = preg_match_all("/\/Page\W/", $pdftext, $dummy);
            } else {
                $pdfPages = '';
            }*/
            
            $request->file('lectureres')->storeAs('education/'.$lid, $file_name.'.'.$file_type);
       
            //$data['file_name'] = 'education/'.$lid.'/'.$file_name.'.'.$file_type;
			$data['file_name'] = $file_name.'.'.$file_type;
			$now_date = date("Y-m-d H:i:s"); 
            $data['updatedOn'] = $now_date;
            if(!empty($lid)){
               $newID = $this->model->insertEduRow($data , $lid);
            
                $return_data = array(
                    'status'=>true,
                    'file_id'=> $lid,
					'file_name'=> $data['file_name'],
                    'file_title'=> $file_title,
                    'file_size'=> $ulearn->HumanFileSize($file_size)
                );
			}else{
                $return_data = array(
                    'status'=>false,
                );
            }	
        
        echo json_encode($return_data);
        exit;
    }
	
	public function postInstructorJobSave(Request $request)
    {   
        $data['instructor_id'] = $request->input('instructor_id');
        $data['company'] = $request->input('company');
        $data['position'] = $request->input('position');
		$data['startdate'] = $request->input('startdate');
		$data['enddate'] = $request->input('enddate');
		$data['description'] = $request->input('description');
        $now_date = date("Y-m-d H:i:s");
        $data['createdOn'] = $now_date;
        $data['updatedOn'] = $now_date;
        
        if($request->input('jobid') == 0){
			Session::flash('success','Work Added Suucessfully!');
            $newID = $this->model->insertJobRow($data , '');
        } else {
			//Session::flash('success','Work Updated Suucessfully!');
            $newID = $this->model->insertJobRow($data , $request->input('jobid'));
        }
        echo $newID;
    }

    public function saveProfile(Request $request)
    {
        // echo '<pre>';print_r($_FILES);exit;
        $validation_rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'contact_email' => 'required|string|email|max:255',
            'telephone' => 'required|string|max:255',
            'paypal_id' => 'required|string|email|max:255',
            'biography' => 'required',            
        ];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }
		
		$user_id = \Auth::user()->id;		
        $instructor = Instructor::where('user_id', $user_id)->first();
        $instructor->first_name = $request->input('first_name');
        $instructor->last_name = $request->input('last_name');
        $instructor->contact_email = $request->input('contact_email');

        $instructor->telephone = $request->input('telephone');
        $instructor->mobile = $request->input('mobile');
		
		$instructor->link_youtube = $request->input('link_youtube');
        $instructor->city = $request->input('city');
        $instructor->country_id  = $request->input('country_id');
        $instructor->is_native = $request->input('is_native');
		$instructor->is_instant_booking = $request->input('is_instant_booking');
		$instructor->language_speak_id = $request->input('language_speak_id');
		$instructor->language_teach_id = $request->input('language_teach_id');

        /*$instructor->link_facebook = $request->input('link_facebook');
        $instructor->link_linkedin = $request->input('link_linkedin');
        $instructor->link_twitter  = $request->input('link_twitter');
        $instructor->link_googleplus = $request->input('link_googleplus');*/

        $instructor->paypal_id = $request->input('paypal_id');
        $instructor->biography = $request->input('biography');


        if (Input::hasFile('course_image') && Input::has('course_image_base64')) {
            //delete old file
            $old_image = $request->input('old_course_image');
            if (Storage::exists($old_image)) {
                Storage::delete($old_image);
            }

            //get filename
            $file_name   = $request->file('course_image')->getClientOriginalName();

            // returns Intervention\Image\Image
            $image_make = Image::make($request->input('course_image_base64'))->encode('jpg');

            // create path
            $path = "instructor/".$instructor->id;
            
            //check if the file name is already exists
            $new_file_name = SiteHelpers::checkFileName($path, $file_name);

            //save the image using storage
            Storage::put($path."/".$new_file_name, $image_make->__toString(), 'public');

            $instructor->instructor_image = $path."/".$new_file_name;
            
        }

        $instructor->save();
		if($user_id){
			$user = User::find($user_id);
			$user->first_name = $request->input('first_name');
			$user->last_name = $request->input('last_name');
			$user->save();
		}

        return $this->return_output('flash', 'success', 'Profile updated successfully', 'instructor-profile', '200');

    }

    public function credits(Request $request)
    {
        $credits = Credit::where('instructor_id', \Auth::user()->instructor->id)
                        ->where('credits_for', 1)
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);

        return view('instructor.credits', compact('credits'));
    }

    public function withdrawRequest(Request $request)
    {
        $withdraw_request = new WithdrawRequest();

        $withdraw_request->instructor_id = \Auth::user()->instructor->id;
        $withdraw_request->paypal_id = $request->input('paypal_id');
        $withdraw_request->amount = $request->input('amount');
        $withdraw_request->save();

        return $this->return_output('flash', 'success', 'Withdraw requested successfully', 'instructor-credits', '200');
    }

    public function listWithdrawRequests(Request $request)
    {
        $withdraw_requests = WithdrawRequest::where('instructor_id', \Auth::user()->instructor->id)
                            ->paginate(10);

        return view('instructor.withdraw_requests', compact('withdraw_requests'));
    }
    
}
