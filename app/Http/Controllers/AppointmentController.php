<?php

namespace App\Http\Controllers;
use App\Mail\StudentCancel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Appointment;
use App\Models\StudentsCredits;
use Redirect,Response;
use Illuminate\Support\Facades\Validator;
use Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        $appointments = \DB::table('appointments')
                        ->leftJoin('users as s', 'appointments.user_id', '=', 's.id')
                        ->leftJoin('users as i', 'appointments.instructor_id', '=', 'i.id')
                        ->leftJoin('courses', 'appointments.course_id', '=', 'courses.id')
                        ->leftJoin('curriculum_lectures_quiz as clq', 'appointments.lecture_id', '=', 'clq.lecture_quiz_id')
                        ->select(
                            'appointments.*',
                            's.first_name as st_fname',
                            's.last_name as st_lname',
                            'courses.course_title',
                            's.timezone',
                            'clq.title as lecture_title'
                        )
                        ->where('appointments.instructor_id', '=', Auth::user()->id)
                        ->get();

        return view('instructor.appointments.index', compact('students', 'appointments'));
    }

    public function listings()
    {
        $appointments = \DB::table('appointments')
                        ->leftJoin('users as s', 'appointments.user_id', '=', 's.id')
                        ->leftJoin('users as i', 'appointments.instructor_id', '=', 'i.id')
                        ->leftJoin('courses', 'appointments.course_id', '=', 'courses.id')
                        ->leftJoin('curriculum_lectures_quiz as clq', 'appointments.lecture_id', '=', 'clq.lecture_quiz_id')
                        ->select(
                            'appointments.*',
                            's.first_name as st_fname',
                            's.last_name as st_lname',
                            'courses.course_title',
                            'clq.title as lecture_title',
                            's.timezone'
                        )
                        ->orderBy("appointments.id", "desc")
                        ->where('appointments.instructor_id', '=', Auth::user()->id)
                        ->get();
// echo'<pre>';print_r($appointments);exit;
        return view('instructor.appointments.listing', compact('appointments'));
    }

    public function create()
    {
        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        $courses = Course::where('instructor_id', '=', Auth::user()->id)->orderBy('course_title')->get();

        return view('instructor.appointments.create', compact('students', 'courses'));
    }

    public function edit($appointment_id)
    {
        $appointment = Appointment::where('id', '=', $appointment_id)->first();

        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        $courses = Course::where('instructor_id', '=', $appointment->instructor_id)->orderBy('course_title')->get();

        $sections = \DB::table("curriculum_sections")->select("section_id")->where("course_id", "=", $appointment->course_id)->get();
        $section_id = array();
        foreach ($sections as $value) {
            $section_id[] = $value->section_id;
        } 

        $lectures = \DB::table("curriculum_lectures_quiz")
                    ->where("publish", "=" ,1)
                    ->whereIn("section_id", $section_id)
                    ->orderBy("section_id")
                    ->orderBy("sort_order")
                    ->get();

        return view('instructor.appointments.edit', compact('appointment', 'students', 'courses', 'lectures'));
    }

    public function update(Request $request)
    {
        $validation_rules = [
            'title' => 'required|string|max:255',
            'user_id' => 'required',
            'instructor_id' => 'required',
            'course_id' => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
            'status' => 'required'
        ];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        $data = $request->all();
        $data['startdate'] = date("Y-m-d H:i:s", strtotime($data['startdate']));
        $data['enddate'] = date("Y-m-d H:i:s", strtotime($data['enddate']));

        if ($request->input("id")) {
            $appointment = Appointment::find($request->input("id"))->update($data);
        } else {
            $appointment = new Appointment($data);
            $appointment->save();
        }

        return redirect('appointment/listing')->with('success', 'Appointment added.');
    } 

    public function destroy($id)
    {

        $appointment = Appointment::where('id', $id)->first();//->delete();
        // $appointment->status = 3;
        

        if($appointment->credit_id > 0)
        {
            $credit = StudentsCredits::find($appointment->credit_id);
            $credit->increment('hours', 1);
        }

        
        // mail to student when teacher cancel lesson
        $appointment->instructor = User::find($appointment->instructor_id);
        $appointment->student = User::find($appointment->user_id);
        $data = $appointment;

        $appointment->delete();

        // if($data->student->id == 258)
        // {
        //     \Mail::to($data->student->email)->send(new StudentCancel($data));
        // }
        \Mail::to('talhanadeem1721@gmail.com')->send(new StudentCancel($data));


   
        return redirect('appointment/listing')->with('success', 'Appointment cancelled.');
    }

    public function getcourse(Request $request)
    {
        $courses = Course::where('instructor_id', '=', $request->input('instructor_id'))->orderBy('course_title')->pluck('course_title', 'id');
        return Response::json($courses);
    }

    public function getlecture(Request $request)
    {
        $sections = \DB::table("curriculum_sections")->select("section_id")->where("course_id", "=", $request->input("course_id"))->get();
        $section_id = array();
        foreach ($sections as $value) {
            $section_id[] = $value->section_id;
        } 

        $lectures = \DB::table("curriculum_lectures_quiz")
                    ->where("publish", "=" ,1)
                    ->whereIn("section_id", $section_id)
                    ->orderBy("section_id")
                    ->orderBy("sort_order")
                    ->pluck("title", "lecture_quiz_id");

        return Response::json($lectures);
    }
}
