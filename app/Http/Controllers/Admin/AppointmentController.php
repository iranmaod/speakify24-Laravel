<?php

namespace App\Http\Controllers\Admin;
use App\Mail\TeacherCancel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Appointment;
use Redirect,Response;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index()
    {
        $instructors = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 2);
        })->get();

        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        $appointments = \DB::table('appointments')
                        ->leftJoin('users as i', 'appointments.instructor_id', '=', 'i.id')
                        ->leftJoin('users as s', 'appointments.user_id', '=', 's.id')
                        ->leftJoin('courses', 'appointments.course_id', '=', 'courses.id')
                        ->select(
                            'appointments.*',
                            'i.first_name as in_fname',
                            'i.last_name as in_lname',
                            's.first_name as st_fname',
                            's.last_name as st_lname',
                            's.timezone',
                            'courses.course_title'
                        )
                        ->get();

        return view('admin.appointments.index', compact('students', 'instructors', 'appointments'));
    }

    public function listings()
    {
        $appointments = \DB::table('appointments')
                        ->leftJoin('users as i', 'appointments.instructor_id', '=', 'i.id')
                        ->leftJoin('users as s', 'appointments.user_id', '=', 's.id')
                        ->leftJoin('courses', 'appointments.course_id', '=', 'courses.id')
                        ->select(
                            'appointments.*',
                            'i.first_name as in_fname',
                            'i.last_name as in_lname',
                            's.first_name as st_fname',
                            's.last_name as st_lname',
                            's.timezone',
                            'courses.course_title'
                        )
                        ->orderBy('appointments.id', 'desc')
                        ->paginate(10);

        return view('admin.appointments.listing', compact('appointments'));
    }

    public function create()
    {
        $instructors = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 2);
        })->get();

        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        return view('admin.appointments.create', compact('students', 'instructors'));
    }

    public function edit($appointment_id)
    {
        $appointment = Appointment::where('id', '=', $appointment_id)->first();

        $instructors = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 2);
        })->get();

        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        return view('admin.appointments.edit', compact('appointment', 'students', 'instructors'));
    }

    public function update(Request $request)
    {
        $validation_rules = [
            'title' => 'required|string|max:255',
            'user_id' => 'required',
            'instructor_id' => 'required',
            // 'course_id' => 'required',
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
  
        $data['startdate'] = date("Y-m-d H:i:s", strtotime($data['startdate'].' -1 hours'));
        $data['enddate'] = date("Y-m-d H:i:s", strtotime($data['enddate'].' -1 hours'));
      

        $course = \DB::table('courses')
                        ->where('instructor_id', 'like', '%"'.$data['instructor_id'].'"%')
                        ->first()
                        ;

        $data['course_id'] = $course->id;
        if ($request->input("id")) {
            $appointment = Appointment::find($request->input("id"))->update($data);
        } else {
            $appointment = new Appointment($data);
            $appointment->save();
        }

        return redirect('admin/appointment/listing')->with('success', 'Appointment added.');
    } 

    public function destroy($id)
    {
        if (!$id) {
            return back();
        }
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return back();
        }

        ///////sending email to instructor after admin cancel appoint
        $appointment->instructor = User::find($appointment->instructor_id);
        $appointment->student = User::find($appointment->user_id);
        $data = $appointment;

        $appointment->delete();
        if($data->instructor->id == 102)
        {
            \Mail::to($data->instructor->email)->send(new TeacherCancel($data));
        }

   
        return redirect('admin/appointment/listing')->with('success', 'Appointment deleted.');
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
