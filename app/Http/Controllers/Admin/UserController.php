<?php
/**
 * PHP Version 7.1.7-1
 * Functions for users
 *
 * @category  File
 * @package   User
 * @author    Mohamed Yahya
 * @copyright ULEARN  
 * @license   BSD Licence
 * @link      Link
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Instructor;
use App\Models\Role;
use App\Models\Language;
use App\Models\Country;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use App\Models\UserSubscription;
use Image;
use SiteHelpers;

/**
 * Class contain functions for admin
 *
 * @category  Class
 * @package   User
 * @author    Mohamed Yahya
 * @copyright ULEARN
 * @license   BSD Licence
 * @link      Link
 */
class UserController extends Controller
{
    /**
     * Function to display the dashboard contents for admin
     *
     * @param array $request All input values from form
     *
     * @return contents to display in dashboard
     */
    public function index(Request $request)
    {
        $paginate_count = 10;
        $search = '';
        if($request->has('search')){
            $search = $request->input('search');
            $users = User::whereHas('RoleUser', function ($query) {
                                $query->where('role_id', '<>', 3);
                            })
                           ->where(function ($q) use ($search) {
                            $q->where('first_name', 'LIKE', '%' . $search . '%')
                               ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                               ->orWhere('email', 'LIKE', '%' . $search . '%');
                           })
                           ->orderBy('id', 'desc')
                           ->paginate($paginate_count);
        }
        else {
            $users = User::whereHas('RoleUser', function ($query) {
                $query->where('role_id', '<>', 0);
            })->orderBy('id', 'desc')->paginate($paginate_count);
        }
        
        return view('admin.users.index', compact('users', 'search'));
    }

    public function getForm($user_id='', Request $request)
    {
        if($user_id) {
            $user = User::with('instructor')->find($user_id);
        }else{
            $user = $this->getColumnTable('users');
        }
        $languages = Language::where('is_enabled', 1)->get();
		$countries = Country::get();

        return view('admin.users.form', compact('user','languages','countries'));
    }

    public function saveUser(Request $request)
    {
        $instructorEnable = False;
        $user_id = $request->input('user_id');

        //validation rules
        if ($user_id) {
            
            $validation_rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'roles' => 'required'
            ];

        } else {
            
            $validation_rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6',
                'roles' => 'required'
            ];

        }

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        $newUserEmail = false;
        if ($user_id) {
            $user = User::find($user_id);
            // Detach all roles for the existing user to update new roles...
            $user->roles()->detach();
            $success_message = 'User updated successfully';
        } else {
            $newUserEmail = true;
            $user = new User();
            $success_message = 'User added successfully';
        }
		
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->comm_lang = $request->input('comm_lang');
        $password = $request->input('password');
        if($password) {
            $user->password = bcrypt($password);
        }        

        $email = false;
        if ($user->is_active == '0' && $request->input('is_active') == '1') {
            $email = true;
        }

        if ($request->input('verify') == '1') {
            $user->email_verified_at = date("Y-m-d H:i:s", time());
        }

        $user->is_active = $request->input('is_active');
        $user->save();	
		
        if($request->exists('roles')) {
            $roles = $request->input('roles');
			if (in_array("instructor", $roles)) {
				$instructorEnable = TRUE;
			}
            foreach ($roles as $role_name) {
                $role = Role::where('name', $role_name)->first();
                $user->roles()->attach($role);
            }
        }
        if ($newUserEmail) {
            $data = $request->all();
            \Mail::send([], [
                'data' => $data
            ], function ($message) use($data, $password){
                $MailBody = 'Hi '.$data['first_name'].' '.$data['last_name'].'!<br />'.
                'Congratulation. Speakify24 Team has added your profile.<br />Please click the link below to verify your email.<br />'.
                \Url::to('verify').'/'.base64_encode($data['email']).'<br />Your credentials are below.<br /><br />'.
                'Email: <b>'.$data['email'].'</b><br />Password: <b>'.$password.'</b>'.
                '<br /><br />Thanks!';
                $message->setBody($MailBody, 'text/html');
                $message->subject('Speakify24 Approved');
                $message->from('info@speakify24.com', 'Speakify24 Team');
                $message->to($data['email']);
            });
        }

		if ($instructorEnable) {
            $instructor_id = $request->input('instructor_id');
            if ($instructor_id) {
                $instructor = Instructor::find($instructor_id);
            } else {
                $instructor = new Instructor();
            }
            
            $teacherCV = $request->file('cv');
            $teacherCV_url = '';
            if ($teacherCV) {
                $teacherCVSaveAsName = time() . "-cv." . $teacherCV->getClientOriginalExtension();

                $upload_path = 'storage/app/public/teacher_cvs/'.$user->id.'/';
                $instructor->cv = 'teacher_cvs/' .$user->id.'/' . $teacherCVSaveAsName;
                $success = $teacherCV->move($upload_path, $teacherCVSaveAsName);
            }

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

			$instructor->user_id =  $user->id;
			$instructor->first_name = $request->input('first_name');
			$instructor->last_name = $request->input('last_name');
			$instructor->contact_email = $request->input('email');
			$instructor->telephone = $request->input('telephone');
			$instructor->mobile = $request->input('mobile');
			$instructor->paypal_id = $request->input('paypal_id');
			$instructor->amount = $request->input('amount');
			$instructor->link_youtube = $request->input('youtube_link');
			$instructor->city = $request->input('city');
			$instructor->country_id = $request->input('country_id');
			$instructor->is_native = $request->input('is_native');
			$instructor->is_instant_booking = $request->input('is_instant_booking');
			$instructor->language_speak_id = $request->input('language_speak_id');
			$instructor->language_teach_id = $request->input('language_teach_id');
            $instructor->who = $request->input('who');
            $instructor->experience = $request->input('experience');
            $instructor->love_job = $request->input('love_job');
            $instructor->tax_number = $request->input('tax_number');

			$instructor->save();
            if ($email) {
                $data = $request->all();
                \Mail::send([], [
                    'data' => $data
                ], function ($message) use($data){
                    $MailBody = 'Hi '.$data['first_name'].' '.$data['last_name'].'!<br />'.
                    'Congratulation. Your account has been approved by Speakify24.<br />You can access your account using your credentials'.
                    '<br /><br />Thanks!';
                    $message->setBody($MailBody, 'text/html');
                    $message->subject('Speakify24 Approved');
                    $message->from('info@speakify24.com', 'Speakify24 Team');
                    $message->to($data['email']);
                });
            }
		}
        
        
        return $this->return_output('flash', 'success', $success_message, 'admin/users', '200');
    }

    public function getData()
    {
        return DataTables::eloquent(User::query())
                            ->addColumn(
                                'user',
                                function (User $user) {
                                    return '<span class="badge badge-primary">Primary</span>';
                                }
                            )
        ->make(true);
    }

    public function exportData(Request $request) {
        if($request->has('search')){
            
            $search = $request->input('search');
            $users = User::whereHas('RoleUser', function ($query) {
                                $query->where('role_id', '<>', 3);
                            })
                           ->where(function ($q) use ($search) {
                            $q->where('first_name', 'LIKE', '%' . $search . '%')
                               ->orWhere('last_name', 'LIKE', '%' . $search . '%')
                               ->orWhere('email', 'LIKE', '%' . $search . '%');
                           })
                           ->orderBy('id', 'desc')
                           ->get();
        }
        else {
            $users = User::whereHas('RoleUser', function ($query) {
                $query->where('role_id', '<>', 3);
            })->orderBy('id', 'desc')->get();
        }

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=users.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('ID', 'First Name', 'Last Name', 'Email Address', 'Verified', 'Active', 'Offer');

        $callback = function() use ($users, $columns)
        {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);


            foreach($users as $row) {
                $verified = 'No';
                if ($row->email_verified_at != null) $verified = 'Yes';
                $approved = 'No';
                if ($row->is_active == 1) $approved = 'Yes';
                $offer = 'No';
                if ($row->offer == 1) $offer = 'Yes';
                fputcsv($file, array($row->id, $row->first_name, $row->last_name, $row->email, $verified, $approved, $offer));
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    public function subscriptions(Request $request) {
        if($request->has('search') || $request->has('startdate') || $request->has('enddate')){
            $search = $request->input('search');
            $startdate = $request->input('startdate');
            $enddate = $request->input('enddate');
            $transactions = \DB::table('transactions')
                            ->where('status','completed')
                            ->select(
                                'transactions.*', 'users.first_name as user_fname', 'users.last_name as user_lname',

                                'courses.course_title'
                            )
                            ->join('users', 'users.id', '=', 'transactions.user_id')
                          
                            ->join('courses', 'courses.id', '=', 'transactions.course_id')
                            ->orderBy('transactions.id', 'desc');

            if (!empty($search)) {
                $transactions->where(function ($q) use ($search) {
                    $q->where('users.first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('users.last_name', 'LIKE', '%' . $search . '%')
                       
                        ->orWhere('courses.course_title', 'LIKE', '%' . $search . '%');
                });
            }

            if (!empty($startdate)) {
                $transactions->where('transactions.created_at', '>=', date("Y-m-d H:i:s", strtotime($startdate)));
            }

            if (!empty($enddate)) {
                $transactions->where('transactions.created_at', '<=', date("Y-m-d H:i:s", strtotime($enddate)));
            }

            if('transactions.appointment_id' != 0)
            {
                $transactions = $transactions
                    ->join('appointments', 'appointments.id', '=', 'transactions.appointment_id')
                    ->join('instructors', 'instructors.user_id', '=', 'appointments.instructor_id')
                    ->select(
                        'appointments.instructor_id',
                    'instructors.first_name as ins_fname', 'instructors.last_name as ins_lname',
                );
            }
            $transactions = $transactions->paginate(10);

        } else {
            $transactions = \DB::table('transactions')
                            ->where('status','completed')
                            ->select(
                                'transactions.*', 'users.first_name as user_fname', 'users.last_name as user_lname',   
                                'courses.course_title'
                            )
                            ->join('users', 'users.id', '=', 'transactions.user_id')
                            ->join('courses', 'courses.id', '=', 'transactions.course_id')
                            ->orderBy('transactions.id', 'desc');
                            


                            if('transactions.appointment_id' != 0)
                            {
                                $transactions = $transactions
                                 ->join('appointments', 'appointments.id', '=', 'transactions.appointment_id')
                                 ->join('instructors', 'instructors.user_id', '=', 'appointments.instructor_id')
                                 ->select(
                                     'appointments.instructor_id',
                                    'instructors.first_name as ins_fname', 'instructors.last_name as ins_lname',
                                );
                            }
                            $transactions = $transactions->paginate(10);

                         
        
        }

        return view('admin.users.subscriptions', compact('transactions'));
    }
}
