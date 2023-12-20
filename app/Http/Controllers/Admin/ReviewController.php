<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Review;
use Redirect,Response;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = \DB::table('reviews')
            ->leftJoin('users as i', 'reviews.instructor_id', '=', 'i.id')
            ->leftJoin('users as s', 'reviews.user_id', '=', 's.id')
            ->leftJoin('courses', 'reviews.course_id', '=', 'courses.id')
            ->select(
                'reviews.*',
                'i.first_name as in_fname',
                'i.last_name as in_lname',
                's.first_name as st_fname',
                's.last_name as st_lname',
                'courses.course_title'
            )
            ->get();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        $instructors = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 2);
        })->get();

        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        return view('admin.reviews.create', compact('students', 'instructors'));
    }

    public function edit($review_id)
    {
        $instructors = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 2);
        })->get();

        $students = User::whereHas('RoleUser', function ($query) {
            $query->where('role_id', '=', 1);
        })->get();

        $review = Review::where('id', '=', $review_id)->first();

        return view('admin.reviews.edit', compact('students', 'instructors', 'review'));
    }

    public function update(Request $request)
    {
        $validation_rules = [
            'instructor_id' => 'required',
            'user_id' => 'required',
            'review' => 'required|string|max:255'
        ];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        $data = $request->all();

        if ($request->input("id")) {
            $data['updated_at'] = date("Y-m-d H:i:s", time());
            $review = Review::find($request->input("id"))->update($data);
        } else {
            $data['created_at'] = date("Y-m-d H:i:s", time());
            $review = new Review($data);
            $review->save();
        }

        return redirect('admin/testimonials')->with('success', 'Review added.');
    } 

    public function destroy($id)
    {
        $review = Review::where('id',$id)->delete();
   
        return redirect('admin/testimonials')->with('success', 'Review deleted.');
    }
}
