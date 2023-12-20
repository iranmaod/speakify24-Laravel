<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // select all users except logged in user
        // $users = User::where('id', '!=', Auth::id())->get();

        $msgUsers = array();
        $layout = 'layouts.frontend.index';
        
        if( Auth::user()->hasRole('student') ) {
            $appUsers = DB::table('appointments')
                        ->select('appointments.instructor_id', 'instructors.first_name', 'instructors.last_name')
                        // ->join('courses', 'courses.id', '=', 'appointments.course_id')
                        ->join('instructors', 'instructors.user_id', '=', 'appointments.instructor_id')
                        // ->join('course_taken', 'course_taken.course_id', '=', 'courses.id')
                        ->where('appointments.user_id', Auth::id())
                        ->groupBy('appointments.instructor_id')
                        ->get();

            if ( count( $appUsers ) > 0 ) {
                foreach($appUsers as $user) {
                    $msgUsers[$user->instructor_id] = $user->instructor_id;
                }
            }

            $adminUsers = DB::table('role_user')->select('user_id')->where('role_id', 3)->get();
            foreach($adminUsers as $admin) {
                $msgUsers[$admin->user_id] = $admin->user_id;
            }

            // count how many message are unread from the selected user
            $users = DB::select("select users.id, users.first_name, users.last_name, instructors.instructor_image, users.email, count(is_read) as unread 
            from users LEFT JOIN messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
            LEFT JOIN instructors ON users.id = instructors.user_id where users.id IN('".implode("','",$msgUsers)."') 
            group by users.id");
        } else if ( Auth::user()->hasRole('instructor') ) {
            $appUsers = DB::table('appointments')
                        ->select('appointments.user_id')
                        ->where('appointments.instructor_id', Auth::id())
                        ->groupBy('appointments.user_id')
                        ->get();

            if ( count( $appUsers ) > 0 ) {
                foreach($appUsers as $user) {
                    $msgUsers[$user->user_id] = $user->user_id;
                }
            }

            $adminUsers = DB::table('role_user')->select('user_id')->where('role_id', 3)->get();
            foreach($adminUsers as $admin) {
                $msgUsers[$admin->user_id] = $admin->user_id;
            }
            $layout = 'layouts.backend.index';

            // count how many message are unread from the selected user
            $users = DB::select("select users.id, users.first_name, users.last_name, users.email, count(is_read) as unread 
            from users LEFT JOIN messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
            where users.id IN('".implode("','",$msgUsers)."') 
            group by users.id");
        } else {
            // count how many message are unread from the selected user
            $users = DB::select("select users.id, users.first_name, users.last_name, instructors.instructor_image, users.email, count(is_read) as unread 
            from users LEFT JOIN messages ON users.id = messages.from and is_read = 0 and messages.to = " . Auth::id() . "
            LEFT JOIN instructors ON users.id = instructors.user_id where users.id !=  " . Auth::id() . "
            group by users.id");
            $layout = 'layouts.backend.index';
        }

        return view('messages.home', [
            'users' => $users,
            'layout' => $layout
        ]);
    }

    public function getMessage($user_id)
    {
        $my_id = Auth::id();

        // Make read all unread message
        Message::where(['from' => $user_id, 'to' => $my_id])->update(['is_read' => 1]);

        // Get all message from selected user
        $messages = Message::where(function ($query) use ($user_id, $my_id) {
            $query->where('from', $user_id)->where('to', $my_id);
        })->oRwhere(function ($query) use ($user_id, $my_id) {
            $query->where('from', $my_id)->where('to', $user_id);
        })->get();

        return view('messages.index', ['messages' => $messages]);
    }

    public function sendMessage(Request $request)
    {
        $from = Auth::id();
        $to = $request->receiver_id;
        $message = $request->message;

        $data = new Message();
        $data->from = $from;
        $data->to = $to;
        $data->message = $message;
        $data->is_read = 0; // message will be unread when sending message
        $data->save();
    }
}