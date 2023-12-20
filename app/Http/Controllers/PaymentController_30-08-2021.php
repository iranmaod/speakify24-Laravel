<?php  
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Validator, Input, Redirect; 
use App\Models\Course;
use App\Models\Transaction;
use App\Models\Credit;
use App\Models\Config;
use App\Models\CourseTaken;
use App\Models\Instructor;
use App\Models\CoursePrices;
use App\Models\Appointment;

use App\Models\Coupon;
use App\Models\CouponUsed;

class PaymentController extends Controller {

	public function __construct()
	{
		
	}
	
	function getSuccess()
	{
		$gateway = \Omnipay::gateway('paypal');

		//get the transaction id from session, so as to update the status and order details
		$transaction = Transaction::find(\Session::get('transaction_id'));

		if($transaction->amount!=0){
		//get values from db and pass it to paypal
		$express_checkout = Config::get_options('settingPayment');

		$gateway->setUsername($express_checkout['en']['username']);
		$gateway->setPassword($express_checkout['en']['password']);
		$gateway->setSignature($express_checkout['en']['signature']);

		if($express_checkout['en']['test_mode'] == '1') {
			$gateway->setTestMode(true);
		} else {
			$gateway->setTestMode(false);
		}

		$response = $gateway->completePurchase([
			'amount'    => floatval($transaction->amount),
			'currency' => 'EUR',
			'returnUrl' => url('payment/success'),
			'cancelUrl' => url('payment/failure'),
		])->send();

		$response_data = $response->getData();
		}else{
			$response_data = array(
					"TOKEN" => 'success',
					"status" => "succeeded",
					"Timestamp"=>time(),
					'ACK' =>'Success',
			);
		}

		// date_default_timezone_set('UTC');
		$course_id = \Session::get('course_id');
		$course = Course::find($course_id);
		$time = \Session::get('time');
		$time = explode("|", $time);
		$startTime = date("Y-m-d H:i:s", strtotime($time[0]));
		$endTime = date("Y-m-d H:i:s", strtotime($time[1]));

		$amount = 0;
		$instructor = Instructor::where('user_id', \Session::get('instructor_id'))->first();
		if ($instructor) {
			$amount = $instructor->amount;
		}

		$appointment = new Appointment;
		$appointment->title = 'New ' . \Auth::user()->id . ' ' . \Session::get('instructor_id');
		$appointment->user_id = \Auth::user()->id;
		$appointment->course_id = $course_id;
		$appointment->transaction_id = $transaction->id;
		$appointment->instructor_id = \Session::get('instructor_id');
		$appointment->instructor_amount = $amount;
		$appointment->startdate = $startTime;
		$appointment->enddate = $endTime;
		$appointment->status = '1';
		$appointment->save();

		\Session::forget('lesson_id');
		\Session::forget('time');

		if(isset($response_data['ACK'])){
			//process only if the acknowledgement is success
			if($response_data['ACK'] == 'Success')
			{
				$save_transaction['id'] = \Session::get('transaction_id');
				$save_transaction['order_details'] = json_encode($response_data);
				$save_transaction['status'] = 'completed';
				$save_transaction['appointment_id'] = $appointment->id;
				$transaction_id = $this->save_transaction($save_transaction);
			
				// add for taken course by user
				$courseTaken = new CourseTaken;
				$courseTaken->user_id = \Auth::user()->id;
				$courseTaken->course_id = $course_id;
				$courseTaken->save();

				\Session::forget('course_id');
				\Session::forget('transaction_id');

				return view('site/course/success')->with('course', $course)->with('title', 'Course')->with('status', 'success')->with('transId', $transaction_id);
			}else{
				return view('site/course/success')->with('course', $course)->with('status', 'failed')->with('transId', \Session::get('transaction_id'))->with('title', 'Course');
			}
		}else{
			return view('site/course/success')->with('course', $course)->with('status', 'failed')->with('transId', \Session::get('transaction_id'))->with('title', 'Course');
		}
	}

	function getFailure(Request $request)
	{
		$save_transaction['id'] = \Session::get('transaction_id');
		$save_transaction['status'] = 'failed';
		$save_transaction['order_details'] = json_encode(array('token'=>$request->input('token')));
		$transaction_id = $this->save_transaction($save_transaction);
		$course_id = \Session::get('course_id');
		$course = Course::find($course_id);

		\Session::forget('course_id');
		\Session::forget('transaction_id');

		return view('site/course/success')->with('course', $course)->with('status', 'failed')->with('transId', $transaction_id)->with('title', 'Course');
	}

	function paymentForm(Request $request)
	{
		// get all values from form
		$payment_method = $request->input('payment_method');
		$course_title = $request->input('course_title');
		$course_id = $request->input('course_id');
		$time = $request->input('time');
		$p_id = $request->input('course_p_id');
		$instructor_id = $request->input('instructor_id');

		$courseprice = CoursePrices::find($p_id);
		$coupon_id = \Session::get('coupon_id');
        $coupon = array();
		$priceINT = $courseprice->price;
        if ($coupon_id) {
            $coupon = Coupon::where('id', $coupon_id)->first();
			if ($coupon->type == 'flat') {
				$priceINT = $courseprice->price - $coupon->discount;
			} else {
				$priceINT = $courseprice->price - ($courseprice->price * $coupon->discount / 100);
			}
			
			if ( $priceINT < 0 ) {
				$priceINT = 0;
			}

			$couponUsed = new CouponUsed;
			$couponUsed->coupon_id = $coupon_id;
			$couponUsed->user_id = \Auth::user()->id;
			$couponUsed->price = $priceINT;
			$couponUsed->save();

			$coupon->increment('used');
        }
		\Session::forget('coupon_id');

		$gateway = \Omnipay::gateway('paypal');

		$paypal = Config::get_options('settingPayment');

		$course = Course::find($course_id);
		$paypal_amount = $amount = $priceINT;

		//get values from db and pass it to paypal
		$gateway->setUsername($paypal['en']['username']);
		$gateway->setPassword($paypal['en']['password']);
		$gateway->setSignature($paypal['en']['signature']);

		if($paypal['en']['test_mode'] == '1') {
			$gateway->setTestMode(true);
		} else {
			$gateway->setTestMode(false);
		}
		
		//save the transaction details in DB
		$transaction = new Transaction;
		$transaction->user_id = \Auth::user()->id;
		$transaction->course_id = $course_id;
		$transaction->amount = floatval($priceINT);
		$transaction->status = 'pending';
		$transaction->type = 'package';
		$transaction->type_id = $p_id;
		$transaction->payment_method = $payment_method;

		$transaction->save();

		\Session::put('transaction_id', $transaction->id);
		\Session::put('course_id', $course_id);
		\Session::put('instructor_id', $instructor_id);
		\Session::put('time', $time);
		\Session::save();
		
		if($amount==0){
			return Redirect::to('payment/success');
		}

		$response = $gateway->purchase([
					'amount'    => floatval($paypal_amount),
					'currency' => 'EUR',
					'description' => 'Course Title: '.$course_title,
					'returnUrl' => url('payment/success'),
					'cancelUrl' => url('payment/failure'),
					])->send();


		if ($response->isRedirect()) {
			// redirect to offsite payment gateway
			$response->redirect();
		} else {
			echo'<pre>';print_r($response);exit;
			// payment failed: display message to customer
			return Redirect::to('payment/form')->withErrors(['payment_error', true]);
		}
	}

	function save_transaction($data)
	{
		//check if the status is completed
		$completed = in_array('completed', $data) ? true : false;
		
		//check if there is transaction id, if so find it or else create a new one
		$transaction = array_key_exists('id', $data) ? Transaction::find($data['id']) : new Transaction;
		//insert all the values in object
		foreach ($data as $key => $value) 
		{
			$transaction->$key = $value;
		}
		$transaction->save();


		//process the invoice generation(get transaction details and save it in invoice table), if the status is completed
		if($completed)
		{
			//save credits
			$this->save_credits($transaction->id);
		}
		return $transaction->id;
	}

	function save_credits($transaction_id)
	{
		//get transaction details
		$transaction = Transaction::find($transaction_id);

		//get commision percentage from db
		
		$commision_percentage = Config::get_option('settingGeneral', 'admin_commission');
		//calculate the credits
		$amount = $transaction->amount;
		$admin_credit = ($amount * $commision_percentage)/100;
		$instructor_credit = $amount - $admin_credit;

		//get instructor id for the course id
		$course = Course::find($transaction->course_id);
		$instructor_id = \Session::get('instructor_id');
        $instructor = Instructor::where('user_id', $instructor_id)->first();
		\Session::forget('instructor_id');

		//save credit for instructor
		$credit = new Credit;
		$credit->transaction_id = $transaction_id;
		$credit->instructor_id = $instructor->id;
		$credit->course_id = $transaction->course_id;
		$credit->user_id = $transaction->user_id;
		$credit->is_admin = 0;
		$credit->credits_for = 1;
		$credit->credit = $instructor_credit;
		$credit->created_at = time();

		$credit->save();

        //update the total credits
        $instructor = Instructor::find($instructor->id)->increment('total_credits', $instructor_credit);
        
		//save credit for instructor
		$credit = new Credit;
		$credit->transaction_id = $transaction_id;
		$credit->instructor_id = 0;
		$credit->course_id = $transaction->course_id;
		$credit->user_id = $transaction->user_id;
		$credit->is_admin = 1;
		$credit->credits_for = 2;
		$credit->credit = $admin_credit;
		$credit->save();
	}

}
