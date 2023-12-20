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
use App\Models\Config;
use Illuminate\Support\Facades\App;

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

    public function instructorList(Request $request)
    {
        $show = true;
        if ( !\Auth::user() ) {
            $show = false;
        }
        $language_search = $request->input('language_id');
        $paginate_count = 8;
        
        $query = DB::table('instructors')
                        ->select('instructors.*', 'countries.name as country_name', 'ls.title as spoken', 'lt.title as taught')
                        ->leftJoin('countries', 'instructors.country_id', '=', 'countries.id')
                        ->leftJoin('users as u', 'instructors.user_id', '=', 'u.id')
                        ->leftJoin('languages as ls', 'instructors.language_speak_id', '=', 'ls.id')
                        ->leftJoin('languages as lt', 'instructors.language_teach_id', '=', 'lt.id')
                        ->where("u.is_active", 1)
                        ->whereNotNull("u.email_verified_at")
        ;

        if($language_search) {
            $query->whereIn('instructors.language_teach_id', $language_search);
        }

        $instructors = $query->groupBy('instructors.id')->paginate($paginate_count);

        $teacherArray = array();
        if ( count($instructors) > 0 ) {
            foreach($instructors as $key => $ins) {
                $ins->appointments = DB::table('appointments')->where('instructor_id', $ins->user_id)->get();
                $ins->metrics = Instructor::metrics($ins->id);
                $ins->course = DB::table('courses')->where('courses.instructor_id', 'like', '%"'.$ins->user_id.'"%')
                                    ->where('courses.language_id', '=', $ins->language_teach_id)
                                    ->first();
                $ins->lessons = \DB::table('courses')->select('curriculum_lectures_quiz.*', 'courses.price')
                        ->where('courses.instructor_id', 'like', '%"'.$ins->user_id.'"%')
                        ->leftJoin('curriculum_sections', 'curriculum_sections.course_id', '=', 'courses.id')                       
                        ->leftJoin('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
                        ->get();

                $ins->hours = $hours = 0;
                $ins->spent = 0;
                $ins->remaining = 0;
                $ins->transaction_id = 0;
                $ins->end_time = date('Y-m-d H:i:s', strtotime("+1 month"));
                if ( \Auth::user() && $ins->course ) {
                    $transaction = \DB::table('transactions')->where('user_id', \Auth::user()->id)
                                        ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime("-1 month")))
                                        ->where('course_id', $ins->course->id)
                                        ->orderBy('created_at', 'desc')
                                        ->first();

                    if ( $transaction ) {
                        $ins->end_time = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($transaction->created_at)));
                        $ins->transaction_id = $transaction->id;
                        if ( $transaction->type == 'package' ) {
                            $plan = \DB::table('course_prices')->where('id', $transaction->type_id)
                                        ->first();

                            $ins->hours = $hours = $plan->hours;
                        } else if ( $transaction->type == 'plan' ) {
                            $plan = \DB::table('subscription_plans')->where('id', $transaction->type_id)
                                        ->first();

                            $ins->hours = $hours = $plan->per_month;
                        }

                        $appointments = \DB::table('appointments')
                            ->where('user_id', \Auth::user()->id)
                            ->where('course_id', $transaction->course_id)
                            ->where('transaction_id', $transaction->id)
                            ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime("-1 month")))
                            // ->sum(\DB::raw("TIME_TO_SEC(time_taken)"))
                            ->get()
                            ;

                        $ins->spent = count($appointments);
                        // $ins->spent = $appointments;
                        $ins->remaining = $hours - $ins->spent;

                    } else {
                        $show = false;
                    }
                }
                $ins->show = $show;
                if ($ins->course != null) {
                    $teacherArray[] = $ins;
                } else {
                    unset($instructors[$key]);
                }
            }
        }

        $categories = Language::where('is_enabled', 1)->get();

        $session = $this->getlocale();
        $hourconfig = Config::where('code', 'pageHourly')->where('locale', $session)->get();
        $monthconfig = Config::where('code', 'pageMonthly')->where('locale', $session)->get();

        return view('site.instructors', compact('instructors', 'categories', 'hourconfig', 'monthconfig'));
        
    }

    public function instructorView($instructor_slug = '', Request $request)
    {
        $instructor = DB::table('instructors')
                        ->select('instructors.*', 'u.is_active', 'u.email_verified_at', 'countries.name as country_name', 'ls.title as spoken', 'lt.title as taught')
                        ->leftJoin('countries', 'instructors.country_id', '=', 'countries.id')
                        ->leftJoin('users as u', 'instructors.user_id', '=', 'u.id')
                        ->leftJoin('languages as ls', 'instructors.language_speak_id', '=', 'ls.id')
                        ->leftJoin('languages as lt', 'instructors.language_teach_id', '=', 'lt.id')
                        ->where('instructors.instructor_slug', $instructor_slug)
                        ->first()
        ;

        if (!$instructor) {
            return back();
        }
        if ($instructor->is_active != 1 || $instructor->email_verified_at == null) {
            return back();
        }

        $course = DB::table('courses')
                        ->where('instructor_id', 'like', '%"'.$instructor->user_id.'"%')
                        ->where('language_id', '=', $instructor->language_teach_id)
                        ->first()
                        ;

        $lessons = \DB::table('courses')
                        ->where('courses.instructor_id', 'like', '%"'.$instructor->user_id.'"%')
                        ->leftJoin('curriculum_sections', 'curriculum_sections.course_id', '=', 'courses.id')                       
                        ->leftJoin('curriculum_lectures_quiz', 'curriculum_lectures_quiz.section_id', '=', 'curriculum_sections.section_id')
                        ->get();

        $metrics = Instructor::metrics($instructor->id);

        $appointments = DB::table('appointments')->where('instructor_id', $instructor->user_id)->get();

        $reviews = DB::table('reviews')
                        ->select('reviews.*', 'instructors.first_name as teacher_fname', 'instructors.last_name as teacher_lname', 'users.first_name as user_fname', 'users.last_name as user_lname')
                        ->leftJoin('instructors', 'reviews.instructor_id', '=', 'instructors.id')
                        ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
                        ->where('instructor_id', $instructor->id)->get();

        $hours = 0;
        $spent = 0;
        $remaining = 0;
        $transaction_id = 0;

        $session_id = false;
        $transaction_id = \Session::get('transaction_id');
        $instructor_id = \Session::get('instructor_id');
        $course_id = \Session::get('course_id');
        $time = \Session::get('time');
        if ($instructor_id != '' && $course_id != '' && $time != '') {
            $session_id = true;
        }

        $end_time = date('Y-m-d H:i:s', strtotime("+1 month"));
        if ( \Auth::user() && $course ) {
            $transaction = \DB::table('transactions')->where('user_id', \Auth::user()->id)
                                ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime("-1 month")))
                                ->where('course_id', $course->id)
                                ->orderBy('created_at', 'desc')
                                ->first();

            if ( $transaction ) {
                $transaction_id = $transaction->id;
                $end_time = date('Y-m-d H:i:s', strtotime("+1 month", strtotime($transaction->created_at)));
                if ( $transaction->type == 'package' ) {
                    $plan = \DB::table('course_prices')->where('id', $transaction->type_id)
                                ->first();

                    $hours = $plan->hours * 60 * 60;
                } else if ( $transaction->type == 'plan' ) {
                    $plan = \DB::table('subscription_plans')->where('id', $transaction->type_id)
                                ->first();

                    $hours = $plan->per_month * 60 * 60;
                }

                $appointments = \DB::table('appointments')
                    ->where('user_id', \Auth::user()->id)
                    ->where('course_id', $transaction->course_id)
                    ->where('transaction_id', $transaction->id)
                    ->where('created_at', '>=', date("Y-m-d H:i:s", strtotime("-1 month")))
                    // ->sum(\DB::raw("TIME_TO_SEC(time_taken)"))
                    ->get()
                    ;

                $spent = count($appointments) * 45 * 60;
                // $spent = $appointments;
                $remaining = $hours - $spent;

            }
        }
        \Session::forget('time');
        \Session::forget('course_id');
        \Session::forget('instructor_id');
        \Session::forget('transaction_id');

        $session = $this->getlocale();
        $hourconfig = Config::where('code', 'pageHourly')->where('locale', $session)->get();
        $monthconfig = Config::where('code', 'pageMonthly')->where('locale', $session)->get();

        return view('site.instructor_view', compact(
            'instructor',
            'metrics',
            'course',
            'lessons',
            'appointments',
            'reviews',
            'hours',
            'spent',
            'remaining',
            'transaction_id',
            'end_time',
            'session_id',
            'time',
            'hourconfig',
            'monthconfig'
        ));
    }

    public function dashboard(Request $request)
    {
        $instructor_id = \Auth::user()->instructor->id;
        $instructor_user_id = \Auth::user()->instructor->user_id;
        $courses = DB::table('courses')
                        ->select('courses.*', 'categories.name as category_name')
                        ->leftJoin('categories', 'categories.id', '=', 'courses.category_id')
                        ->where('courses.instructor_id', 'like', '%"'.$instructor_user_id.'"%')
                        ->paginate(5);
        $metrics = Instructor::metrics($instructor_user_id);
        return view('instructor.dashboard', compact('courses', 'metrics'));
    }

    public function schedule() {
        $instructor = \Auth::user()->instructor;

        return view('instructor.schedule', compact('instructor'));
    }

    public function addschedule(Request $request)
    {
        $instructor = Instructor::find(\Auth::user()->instructor->id);
        $data = array();
        // echo'<pre>';print_r($request->all());
        if (!empty($request->input('select_day')) && !empty($request->input('start')) && !empty($request->input('end'))) {
            $data['select_day'] = $request->input('select_day');
            $data['start'] = $request->input('start');
            $data['end'] = $request->input('end');
            $instructor->schedule = json_encode($data);
        } else {
            $instructor->schedule = null;
        }
        // print_r($instructor);
        // exit;
        $instructor->save();

        return $this->return_output('flash', 'success', 'Schedule updated successfully', 'instructor-dashboard', '200');
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
            'who' => 'required|max:150',
            'experience' => 'required|max:150',
            'love_job' => 'required|max:150',
            'tax_number' => 'required',
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
        $instructor->who = $request->input('who');
        $instructor->experience = $request->input('experience');
        $instructor->love_job = $request->input('love_job');
        $instructor->tax_number = $request->input('tax_number');


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
    
    public function transactions(Request $request) {
        if($request->has('search') || $request->has('startdate') || $request->has('enddate')){
            $search = $request->input('search');
            $startdate = $request->input('startdate');
            $enddate = $request->input('enddate');

            $transactions = \DB::table('appointments')
                        ->leftJoin('users as u', 'appointments.user_id', '=', 'u.id')
                        ->leftJoin('courses as c', 'appointments.course_id', '=', 'c.id')
                        ->select(
                            'appointments.*',
                            'u.first_name as u_fname',
                            'u.last_name as u_lname',
                            'c.course_title',
                        )
                        ->where('appointments.instructor_id', \Auth::user()->instructor->user_id)
                        ->orderBy('appointments.created_at', 'desc')
                        ;

            if (!empty($search)) {
                $transactions->where(function ($q) use ($search) {
                    $q->where('u.first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('u.last_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('appointments.instructor_amount', 'LIKE', '%' . $search . '%')
                        ->orWhere('c.course_title', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($startdate)) {
                $transactions->where('appointments.created_at', '>=', date("Y-m-d H:i:s", strtotime($startdate)));
            }

            if (!empty($enddate)) {
                $transactions->where('appointments.created_at', '<=', date("Y-m-d H:i:s", strtotime($enddate)));
            }
            $transactions = $transactions->paginate(10);
        } else {
            $transactions = \DB::table('appointments')
                        ->leftJoin('users as u', 'appointments.user_id', '=', 'u.id')
                        ->leftJoin('courses as c', 'appointments.course_id', '=', 'c.id')
                        ->select(
                            'appointments.*',
                            'u.first_name as u_fname',
                            'u.last_name as u_lname',
                            'c.course_title',
                        )
                        ->where('appointments.instructor_id', \Auth::user()->instructor->user_id)
                        ->orderBy('appointments.created_at', 'desc')
                        ->paginate(10);
        }

        return view('instructor.transactions', compact('transactions'));
    }

    public function getlocale() {
        $session = App::getLocale();
        if (session()->get('locale') != '') {
            $session = session()->get('locale');
        }

        return $session;
    }
}
