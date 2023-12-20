<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Coupon;
use Redirect,Response;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function edit($coupon_id)
    {
        $coupon = Coupon::where('id', '=', $coupon_id)->first();

        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request)
    {
        $validation_rules = [
            'name' => 'required|string|max:128',
            'code' => 'required|string|max:20',
            'discount' => 'required',
            'type' => 'required',
            'number_of_usage' => 'required|integer',
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
            $coupon = Coupon::find($request->input("id"))->update($data);
        } else {
            $coupon = new Coupon($data);
            $coupon->save();
        }

        return redirect('admin/coupons')->with('success', 'Coupon added.');
    } 

    public function destroy($id)
    {
        $coupon = Coupon::where('id',$id)->delete();
   
        return redirect('admin/coupons')->with('success', 'Coupon deleted.');
    }
}
