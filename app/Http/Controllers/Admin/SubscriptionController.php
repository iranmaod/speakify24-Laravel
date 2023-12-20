<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Subscription;
use Redirect,Response;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = \DB::table('subscription_plans')
                        ->leftJoin('courses', 'subscription_plans.course_id', '=', 'courses.id')
                        ->select(
                            'subscription_plans.*',
                            'courses.course_title'
                        )
                        ->get();

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $courses = Course::where('is_active', '1')->get();
        return view('admin.subscriptions.create', compact('courses'));
    }

    public function edit($subscription_id)
    {
        $courses = Course::where('is_active', '1')->get();
        $subscription = Subscription::where('id', '=', $subscription_id)->first();

        return view('admin.subscriptions.edit', compact('subscription', 'courses'));
    }

    public function update(Request $request)
    {
        $validation_rules = [
            'name' => 'required|string|max:255',
            // 'hours' => 'required|integer|min:1',
            'per_month' => 'required|integer|min:1',
            'course_id' => 'required',
            'price' => 'required|integer|min:1',
            'status' => 'required',
            // 'expiry' => 'required'
        ];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        $data = $request->all();

        // $data['expiry'] = date("Y-m-d H:i:s", strtotime($data['expiry']));
        $data['updated_at'] = date("Y-m-d H:i:s", time());
        if ($request->input("id")) {
            $subscription = Subscription::find($request->input("id"))->update($data);
            $message = 'Subscription updated.';
        } else {
            $data['created_at'] = date("Y-m-d H:i:s", time());
            $subscription = new Subscription($data);
            $subscription->save();
            $message = 'Subscription added.';
        }

        return redirect('admin/subscriptions')->with('success', $message);
    } 

    public function destroy($id)
    {
        $subscription = Subscription::where('id',$id)->delete();
   
        return redirect('admin/subscriptions')->with('success', 'Subscription deleted.');
    }

    public function teacherweek()
    {
        $transactions = \DB::table('appointments')
                ->leftJoin('users as u', 'appointments.instructor_id', '=', 'u.id')
                ->leftJoin('courses as c', 'appointments.course_id', '=', 'c.id')
                ->select(
                    'appointments.*',
                    'u.first_name as u_fname',
                    'u.last_name as u_lname',
                    'c.course_title',
                    \DB::raw("(SUM(appointments.instructor_amount)) as total"),
                    \DB::raw("(COUNT(appointments.instructor_amount)) as count"),
                )
                ->whereMonth('appointments.enddate', date('m'))
                ->whereYear('appointments.enddate', date('Y'))
                ->groupBy('appointments.instructor_id')
                ->get();
// echo date('Y').'<br />'.date('m').'<br /><pre>';print_r($transactions);exit;
        return view('admin.subscriptions.teacherweek', compact('transactions'));
    }
}
