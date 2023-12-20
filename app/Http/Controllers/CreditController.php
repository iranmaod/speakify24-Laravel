<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Course;
use App\Models\Transaction;
use App\Models\StudentsCredits;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;
class CreditController extends Controller
{
    public function index()
    {
    
        $credits = \DB::table('students_credits')
                        ->leftJoin('users as s', 'students_credits.user_id', '=', 's.id')
                        ->leftJoin('courses', 'students_credits.lang_id', '=', 'courses.id')
                        ->select(
                            'students_credits.*',
                            's.first_name',
                            's.last_name',
                            'courses.course_title',
                        )
                        ->orderBy('id', 'DESC')
                        ->paginate(10);



        // echo "<pre>";
        // print_r($credits);exit;
        return view('admin.credits.index', compact('credits'));

    }
    public function view()
    {
    
        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        $languages = Course::all();
       
        return view('admin.credits.create', compact('students','languages'));
    }
    public function create(Request $request)
    {
        $validation_rules = [
            'hours' => 'required',
            'lang_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }


        $startTime = date("Y-m-d H:i:s", strtotime($request->start_time));
        $endTime = date("Y-m-d H:i:s", strtotime($request->end_time));

        $credits = new StudentsCredits;
        $credits->user_id = $request->user_id;
        $credits->total_hours = $request->hours;
        $credits->hours = $request->hours;
        $credits->lang_id = $request->lang_id;
        $credits->start_time = $startTime;
        $credits->end_time = $endTime;
        $credits->weekly_hours = $request->weekly_hours;
        $credits->weekly_hours_remaining = $request->weekly_hours;
        $credits->canc_credits = $request->max_credits;
        $credits->cancelled_remaining = $request->max_credits;
        $credits->save();


        $transaction = new Transaction();
        $transaction->appointment_id = 0;
        $transaction->user_id = $request->user_id;
        $transaction->course_id = $request->lang_id;
        $transaction->status = 'completed';
        $transaction->type_id = 34;
        $transaction->payment_method = 'by_admin';
        $transaction->type = 'admin_credits';
        $transaction->credit_id = $credits->id;
        $transaction->save();

        return $this->return_output('flash', 'success', 'Credit Created successfully.', 'credits', '200');
                   

    }


    public function edit($id)
    {
        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        $languages = Course::all();
        $credits = StudentsCredits::find($id);
        return view('admin.credits.edit',compact('credits','students','languages'));
    }

    public function update(Request $request, $id)
    {

        $validation_rules = [
            'hours' => 'required',
            'lang_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        $startTime = date("Y-m-d H:i:s", strtotime($request->start_time));
        $endTime = date("Y-m-d H:i:s", strtotime($request->end_time));

        $transaction = Transaction::where('credit_id',$id)->first();
        

        $credits = StudentsCredits::find($id);
        $credits->user_id = $request->user_id;
        $credits->total_hours = $request->hours;
        $credits->hours = $request->re_hours;
        $credits->lang_id = $request->lang_id;
        $credits->start_time = $startTime;
        $credits->end_time = $endTime;
        $credits->weekly_hours = $request->weekly_hours;
        // $credits->weekly_hours_remaining = $request->weekly_hours;
        $credits->canc_credits = $request->max_credits;
        // $credits->cancelled_remaining = $request->max_credits;
        $credits->update();

        $transaction->course_id = $request->lang_id;
        $transaction->update();
        return $this->return_output('flash', 'success', 'Credit updated successfully.', 'credits', '200');
    }

    public function delete($id)
    {
        $credits = StudentsCredits::find($id);
        $transaction = Transaction::where('credit_id',$id)->first();
        $credits->delete();
        $transaction->delete();
        return $this->return_output('flash', 'success', 'Credit deleted successfully.', 'credits', '200');
    }
}
