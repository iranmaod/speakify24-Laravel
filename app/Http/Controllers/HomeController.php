<?php

namespace App\Http\Controllers;
use App\Mail\TeacherBooking;
use App\Mail\StudentReminder;
use App\Mail\StudentReminderHour;
use App\Mail\TeacherReminder;
use App\Mail\TeacherReminderHour;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactAdmin;
use App\Models\Config;
use App\Models\Subscription;
use App\Models\Language;
use App\Models\UserSubscription;
use App\Models\Course;
use App\Models\CoursePrices;
use App\Models\Appointment;
use App\Models\Transaction;
use App\Models\Credit;
use App\Models\CourseTaken;
use App\Models\Instructor;


use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\Payer;
use PayPal\Api\ShippingAddress;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Signer;
use Lcobucci\JWT\Signer\Key\InMemory;

use Illuminate\Support\Facades\App;

use Firebase\JWT\JWT;

use App\Models\Country;
use App\Models\Coupon;
use App\Models\CouponUsed;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth', ['except' => ['checkUserEmailExists']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($locale = null, Request $request)
    {
        $latestTab_courses = DB::table('courses')
                    ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
                    ->selectRaw('AVG(course_ratings.rating) AS average_rating')
                    ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
                    ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
                    ->where('courses.is_active',1)
                    ->groupBy('courses.id')
                    ->limit(8)
                    ->orderBy('courses.updated_at', 'desc')
                    ->get();
        
        $freeTab_courses = DB::table('courses')
                    ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
                    ->selectRaw('AVG(course_ratings.rating) AS average_rating')
                    ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
                    ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
                    ->where('courses.is_active',1)
                    ->groupBy('courses.id')
                    ->limit(8)
                    ->where('courses.price', 0)
                    ->get();

        $discountTab_courses = DB::table('courses')
                    ->select('courses.*', 'instructors.first_name', 'instructors.last_name')
                    ->selectRaw('AVG(course_ratings.rating) AS average_rating')
                    ->leftJoin('course_ratings', 'course_ratings.course_id', '=', 'courses.id')
                    ->join('instructors', 'instructors.id', '=', 'courses.instructor_id')
                    ->where('courses.is_active',1)
                    ->groupBy('courses.id')
                    ->limit(8)
                    ->where('courses.strike_out_price', '<>' ,null)
                    ->get();

        $instructors = DB::table('instructors')
                        ->select('instructors.*')
                        ->join('users', 'users.id', '=', 'instructors.user_id')
                        ->where('users.is_active',1)
                        ->groupBy('instructors.id')
                        ->limit(8)
                        ->get();

        $session = $this->getlocale();
        $config = Config::where('code', 'pageHome')->where('locale', $session)->get();

        return view('site/home', compact('latestTab_courses', 'freeTab_courses', 'discountTab_courses', 'instructors', 'config'));
    }

    /**
     * Function to check whether the email already exists
     *
     * @param array $request All input values from form
     *
     * @return true or false
     */
    public function checkUserEmailExists(Request $request)
    {
        $email = $request->input('email');
        
        $users = User::where('email',$email)->first();
        
        echo $users ? "false" : "true";
    }

    public function blogList(Request $request)
    {
        $paginate_count = 3;
        $blogs = Blog::join('blog_translations as t', function ($join) {
            $join->on('blogs.id', '=', 't.blog_id')
                ->where('t.locale', '=', 'en')
                ;
        }) 
        ->groupBy('blogs.id')
        ->orderBy('blogs.id', 'desc')
        ->with('translations')
        ->get();
        // echo'<pre>';print_r($blogs);exit;
        $archieves = DB::table('blogs')
                ->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) blog_count'))
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();
        
        return view('site.blogs.list', compact('blogs', 'archieves'));
    }

    public function blogView($blog_slug = '', Request $request)
    {
        $paginate_count = 1;
        $blog =  Blog::where('blog_slug',$blog_slug)->first();

        $archieves = DB::table('blogs')
                ->select(DB::raw('YEAR(created_at) year, MONTH(created_at) month, MONTHNAME(created_at) month_name, COUNT(*) blog_count'))
                ->groupBy('year')
                ->groupBy('month')
                ->orderBy('year', 'desc')
                ->orderBy('month', 'desc')
                ->get();

        return view('site.blogs.view', compact('blog', 'archieves'));
    }

    public function pageAbout(Request $request)
    {
        $session = $this->getlocale();
        $config = Config::where('code', 'pageAbout')->where('locale', $session)->get();
        // dd($config);
        return view('site.pages.about', compact('config'));
    }

    public function pageContact(Request $request)
    {
        $session = $this->getlocale();
        $admin_email = Config::get_option('settingGeneral', 'admin_email');
        return view('site.pages.contact');
    }

    public function contactAdmin(Request $request)
    {   
        $admin_email = Config::get_option('settingGeneral', 'admin_email');
        Mail::to($admin_email)->send(new ContactAdmin($request));
        return $this->return_output('flash', 'success', 'Thanks for your message, will contact you shortly', 'back', '200');
    }

    public function getCheckTime()
	{
		$reset_site_at = Config::get_option('lastResetTime', 'lastResetTime');
		
		$reset_minutes = 60 * 60;
        
        if(($reset_site_at+$reset_minutes) - time() > 0)
		{
			echo ($reset_site_at+$reset_minutes) - time();
		}
		else
		{
			echo $reset_minutes;
		}
		
	}

    public function profile()
    {
        return view('site.users.profile');
    }

    public function subscriptionplans($course_id = null, $instructor_id = null, $type = null, Request $request)
    {
        $lesson_id = 0;
        $time = '';
        if($request->method() == 'POST'){
            $lesson_id = $request->input('lesson_id');
            $time = $request->input('time');
        }

        if ($type == '1') {
            $subscriptions = Subscription::where('status', '1')->where('course_id', $course_id)->get();

            $user_sub = UserSubscription::where('user_id', \Auth::user()->id)
                                        ->where('payment_status', 'Active')
                                        ->where('course_id', $course_id)
                                        ->where('instructor_id', $instructor_id)
                                        ->orderBy('id', 'desc')->first();
    
            // if ($user_sub && $user_sub->payment_status == 'Active') {
            //     return redirect('/')->with('success', 'You have already subscribed this course.');
            // }
            return view('site.choose_plan', compact(
                'subscriptions',
                'course_id',
                'instructor_id',
                'type',
                'lesson_id',
                'time'
            ));
        } else if ($type == '2') {
            $prices = CoursePrices::where('course_id', $course_id)->get();
            $course = Course::find($course_id);
            return view('site.choose_plan', compact(
                'prices',
                'course',
                'instructor_id',
                'type',
                'lesson_id',
                'time'
            ));
        }
    }

    public function registerTeacher()
    {
        $session = $this->getlocale();
        $config = Config::where('code', 'pageTeacher')->where('locale', $session)->get();

        $languages = Language::where("is_enabled", "=", "1")->get();
		$countries = Country::get();

        return view('site.register_teacher', compact('languages', 'config', 'countries'));
    }

    public function subscribe($id, $course_id, $instructor_id, $time)
    {
        if ($id == '') {
            return redirect()->route('instructor.list');
        }
        $subscription = Subscription::find($id);

        if ($subscription && $subscription->status) {
            \Session::put('time', $time);
			\Session::save();

            $coupon_id = \Session::get('coupon_id');
            $coupon = array();
            $priceINT = $subscription->price;
            if ($coupon_id) {
                $coupon = Coupon::where('id', $coupon_id)->first();
                if ($coupon->type == 'flat') {
                    $priceINT = $subscription->price - $coupon->discount;
                } else {
                    $priceINT = $subscription->price - ($subscription->price * $coupon->discount / 100);
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

            $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    \Config::get('paypal.client_id'),
                    \Config::get('paypal.secret')
                )
            );
            $apiContext->setConfig(array(
                'mode' => 'live',
            ));

            $plan = new Plan();
            $plan->setName($subscription->name)
                ->setDescription($subscription->name)
                ->setType('fixed');

            // Set billing plan definitions
            $paymentDefinition = new PaymentDefinition();
            $paymentDefinition->setName('Regular Payments')
                ->setType('REGULAR')
                ->setFrequency('Month')
                ->setFrequencyInterval('1')
                ->setCycles('12')
                ->setAmount(new Currency(array('value' => $priceINT, 'currency' => 'EUR')));

            // Set charge models
            $chargeModel = new ChargeModel();
            $chargeModel->setType('SHIPPING')
                ->setAmount(new Currency(array('value' => 0, 'currency' => 'EUR')));
            $paymentDefinition->setChargeModels(array($chargeModel));

            $main_id = $id . '-' . $course_id . '-' . $instructor_id;
            // Set merchant preferences
            $merchantPreferences = new MerchantPreferences();
            $merchantPreferences->setReturnUrl(url('/processpayment/'.$main_id))
                ->setCancelUrl(url('/cancelpayment/'.$main_id))
                ->setAutoBillAmount('yes')
                ->setInitialFailAmountAction('CONTINUE')
                ->setMaxFailAttempts('0')
                ->setSetupFee(new Currency(array('value' => 0, 'currency' => 'EUR')));

            $plan->setPaymentDefinitions(array($paymentDefinition));
            $plan->setMerchantPreferences($merchantPreferences);
            
            try {
                $createdPlan = $plan->create($apiContext);

                \Session::put('createdplan_id', $createdPlan->getId());
			    \Session::save();

                try {
                    $patch = new Patch();
                    $value = new PayPalModel('{"state":"ACTIVE"}');
                    $patch->setOp('replace')
                        ->setPath('/')
                        ->setValue($value);
                    $patchRequest = new PatchRequest();
                    $patchRequest->addPatch($patch);
                    $createdPlan->update($patchRequest, $apiContext);
                    $patchedplan = Plan::get($createdPlan->getId(), $apiContext);

                    $startDate = date('c', time() + 3600);

                    // Create new agreement
                    $agreement = new Agreement();
                    $agreement->setName($subscription->name)
                        ->setDescription($subscription->name)
                        ->setStartDate($startDate);
        
                    // Set plan id
                    $plan = new Plan();
                    $plan->setId($patchedplan->getId());
                    $agreement->setPlan($plan);
        
                    // Add payer type
                    $payer = new Payer();
                    $payer->setPaymentMethod('paypal');
                    $agreement->setPayer($payer);
        
                //     // Adding shipping details
                //     $shippingAddress = new ShippingAddress();
                //     $shippingAddress->setLine1('11 First Street')
                //         ->setCity('Saratoga')
                //         ->setState('CA')
                //         ->setPostalCode('95073')
                //         ->setCountryCode('US');
                //     $agreement->setShippingAddress($shippingAddress);
        
                    try {
                        // Create agreement
                        $agreement = $agreement->create($apiContext);
                      
                        // Extract approval URL to redirect user
                        $approvalUrl = $agreement->getApprovalLink();
                        return redirect()->away($approvalUrl);
                    } catch (PayPal\Exception\PayPalConnectionException $ex) {
                        echo'<pre>';print_r($ex);exit;
                    } catch (Exception $ex) {
                        echo'<pre>';print_r($ex);exit;
                    }
                } catch (PayPal\Exception\PayPalConnectionException $ex) {
                    echo'<pre>';print_r($ex);exit;
                } catch (Exception $ex) {
                    echo'<pre>';print_r($ex);exit;
                }
            } catch (PayPal\Exception\PayPalConnectionException $ex) {
                echo'<pre>';print_r($ex);exit;
            } catch (Exception $ex) {
                echo'<pre>';print_r($ex);exit;
            }
        } else {
            return back();
        }
    }

    public function processpayment($id, Request $request)
    {
        $agreement = new \PayPal\Api\Agreement();
        $apiContext = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                \Config::get('paypal.client_id'),
                \Config::get('paypal.secret')
            )
        );
        $apiContext->setConfig(array(
            'mode' => 'live',
        ));

        try {
            // Execute agreement
            $agreement->execute($request->get('token'), $apiContext);

            $main = explode('-', $id);
            $data = array();

            $subscription = Subscription::find($id);
            \Session::put('instructor_id', $main[2]);

            $data['user_id'] = \Auth::user()->id;
            $data['plan_id'] = $main[0];
            $data['course_id'] = $main[1];
            $data['instructor_id'] = $main[2];
            $data['payment_id'] = \Session::get('createdplan_id');//$agreement->getId();
            $data['token'] = $request->get('token');
            $data['payment_status'] = '';//$agreement->getState();
            $data['start_date'] = date("Y-m-d H:i:s", time());//date("Y-m-d H:i:s", strtotime($agreement->getStartDate()));
            $data['next_billing'] = date("Y-m-d H:i:s", strtotime("+1 month"));
            $data['created_at'] = date("Y-m-d H:i:s", time());
            $data['updated_at'] = date("Y-m-d H:i:s", time());

            $userSubs = new UserSubscription($data);
            $userSubs->save();

            date_default_timezone_set('UTC');

            $time = \Session::get('time');
            $time = explode("|", $time);
            // $startTime = date("Y-m-d H:i:s", strtotime($time[0]));
            // $endTime = date("Y-m-d H:i:s", strtotime($time[1]));
            $start = date("Y").env('DAYLIGHT_SAVING_START');
            $end = date("Y").env('DAYLIGHT_SAVING_END');
            $now = date("Y-m-d", strtotime($time[0]));

            if ($now > $start && $now < $end) {
                $startTime = date("Y-m-d H:i:s", strtotime(substr($time[0], 0, 19).' +1 hours'));
                $endTime = date("Y-m-d H:i:s", strtotime(substr($time[1], 0, 19).' +1 hours'));
            } else {
                $startTime = date("Y-m-d H:i:s", strtotime(substr($time[0], 0, 19)));
                $endTime = date("Y-m-d H:i:s", strtotime(substr($time[1], 0, 19)));
            }
            
            \Session::forget('time');
            $amount = 0;
            $instructor = Instructor::where('user_id', $main[2])->first();
            if ($instructor) {
                $amount = $instructor->amount;
            }

            $appointment = new Appointment;
            $appointment->title = 'New ' . \Auth::user()->id . ' ' . $main[2];
            $appointment->user_id = \Auth::user()->id;
            $appointment->course_id = $main[1];
            $appointment->instructor_id = $main[2];
            $appointment->instructor_amount = $amount;
            $appointment->startdate = $startTime;
            $appointment->enddate = $endTime;
            $appointment->status = '1';
            $appointment->save();

            $response_data = array(
                "TOKEN" => 'success',
                "status" => "succeeded",
                "Timestamp" => time(),
                "id" => \Session::get('createdplan_id'),
                'ACK' => 'Success',
                "agreement_id" => $agreement->getId(),
            );
            \Session::forget('createdplan_id');

            $coupon_id = \Session::get('coupon_id');
            $coupon = array();
            $priceINT = $subscription->price;
            if ($coupon_id) {
                $coupon = Coupon::where('id', $coupon_id)->first();
                if ($coupon->type == 'flat') {
                    $priceINT = $subscription->price - $coupon->discount;
                } else {
                    $priceINT = $subscription->price - ($subscription->price * $coupon->discount / 100);
                }
                
                if ( $priceINT < 0 ) {
                    $priceINT = 0;
                }
            }
            \Session::forget('coupon_id');

            $transaction = new Transaction;
			$transaction->user_id = \Auth::user()->id;
			$transaction->course_id = $main[1];
			$transaction->amount = floatval($priceINT);
			$transaction->status = 'completed';
			$transaction->type = 'plan';
			$transaction->type_id = $main[0];
			$transaction->payment_method = 'express_checkout';
            $transaction->order_details = json_encode($response_data);
            $transaction->status = 'completed';
            $transaction->appointment_id = $appointment->id;
			$transaction->save();

            $appointment->transaction_id = $transaction->id;
            $appointment->save();

            $courseTaken = new CourseTaken;
            $courseTaken->user_id = \Auth::user()->id;
            $courseTaken->course_id = $main[1];
            $courseTaken->save();

            $this->save_credits($transaction->id);

            if($appointment->course_id == '12'){
                $param = 'language_id%5B%5D=2';
            }elseif($appointment->course_id == '13'){
                $param = 'language_id%5B%5D=3';
            }elseif($appointment->course_id == '16'){
                $param = 'language_id%5B%5D=5';
            }elseif($appointment->course_id == '14'){
                $param = 'language_id%5B%5D=4';
            }else{
                $param = '';
            }

            ////sending email to instructor while booking
        $appointment->instructor = User::find($appointment->instructor_id);
        $appointment->student = User::find($appointment->user_id);
        $data = $appointment;
        if($data->instructor->id == 102)
        {
            Mail::to($data->instructor->email)->send(new TeacherBooking($data));
        }
       
        return redirect()->route('instructor.list', [$param])->with('success', 'You have subscribed to monthly package successfully.');
        } catch (PayPal\Exception\PayPalConnectionException $ex) {
            echo '<pre>';
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
            exit;
        } catch (Exception $ex) {
            echo '<pre>';
            print_r($ex);
            exit;
        }
    }

    public function cancelpayment($id, Request $request)
    {
        echo'<pre>';print_r($request->all());exit;
    }

    public function joinmeeting($api_id = null, $name = null, Request $request)
    {
        $user = \Auth::getUser();
        if (!$user) {
            return redirect('/login');
        }
        $appointment_id = 0;
        $appointment = array();
        $user_id = \Auth::getUser()->id;
        if( $request->method() == 'POST' ){
            $appointment_id = $request->input('appointment_id');
            $appointment = Appointment::where('id', $appointment_id)->first();
        }

        if ($name != null) {
            $stname = explode("_", $name);
            $appointment_id = $stname[1];
            $appointment = Appointment::where('id', $appointment_id)->first();
        }

        if (!$appointment) {
            return redirect('/')->with('error', 'Appointment not found.');
        }

        if ($user_id != $appointment->instructor_id && $user_id != $appointment->user_id) {
            return redirect('/')->with('error', 'You are not allowed to join this conference.');
        }

        $path = storage_path() . "/pk.pk";

        $mod = false;
        if ($user_id == $appointment->instructor_id) {
            $mod = true;
            $appointment->start = 1;
            $appointment->updated_at = date("Y-m-d H:i:s", time());
            $appointment->save();
        }

        $payload = array(
            'iss' => 'chat',
            'aud' => 'jitsi',
            'exp' => time() + 7200,
            'nbf' => time(),
            'room'=> '*',
            'sub' => "vpaas-magic-cookie-f28545654cdf498f82c4dea3a5a591e5",
            'context' => [
                'user' => [
                    'moderator' => $mod,
                    'email' => $user->email,
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'avatar' => "",
                    'id' => $user->id
                ],
                'features' => [
                    'recording' => "true",
                    'livestreaming' => "true",
                    'transcription' => "true",
                    'outbound-call' => "true"
                ]
            ]
        );

        $token = JWT::encode($payload, \File::get($path), "RS256", "vpaas-magic-cookie-f28545654cdf498f82c4dea3a5a591e5/faab46");

        return view('site.join_meeting', compact(
            'api_id',
            'name',
            'appointment_id',
            'appointment',
            'user',
            'token'
        ));
    }

    public function meetdata(Request $request) {
        $user = \Auth::getUser();
        $appointment_id = $request->input('appointment_id');
        $appointment = Appointment::where('id', $appointment_id)->first();
        $appointTime = date("H:i:s", strtotime($appointment->enddate) - strtotime($appointment->startdate));

        $time = $request->input('time');
        // if ($user->id == $appointment->instructor_id) {
        //     return redirect('/')->with('success', 'Video conference completed successfully.');
        // }
        $timeparts = explode(":", $time);
        $hours = $timeparts[0];
        $minutes = $timeparts[1];
        $seconds = '00';
        if ( $timeparts[2] > '00' ) {
            $seconds = $timeparts[2];
        }

        if (strtotime($hours.':'.$minutes.':'.$seconds) < strtotime($appointTime)) {
            if ($appointment->start != 4) {
                $appointment->start = 2;
            }
            if ($user->id == $appointment->instructor_id) {
                $appointment->start = 4;
            }
        } else {
            $appointment->start = 3;
            $appointment->status = 4;
        }
        
        if ($appointment) {
            $appointment->time_taken = date("H:i:s", strtotime($appointment->time_taken) + strtotime($hours.':'.$minutes.':'.$seconds));
            $appointment->updated_at = date("Y-m-d H:i:s", time());
            $appointment->save();
        }

        // $timeString = '';
        // if ((int) $hours > 0) {
        //     $timeString .= $hours . ' hours and ';
        // }

        // if ((int) $minutes > 0) {
        //     $timeString .= $minutes . ' minutes and ';
        // }

        // if ((int) $seconds > 0) {
        //     $timeString .= $seconds . ' seconds';
        // }

        // if ($user->id == $appointment->user_id) {
            return redirect('/')->with('success', 'Video conference completed successfully.');
        // }
    }

    public function checkmeeting() {
        $appointment = Appointment::where('user_id', \Auth::user()->id)
                                    ->where('status', '1')
                                    ->whereIn('start', ['1', '2'])
                                    ->orderBy('updated_at', 'desc')
                                    ->first();

        if ($appointment) {
            if (time() <= strtotime($appointment->enddate)) {
                echo json_encode($appointment); exit;
            } else {
                $appointment->status = 4;
                $appointment->updated_at = date("Y-m-d H:i:s", time());
                $appointment->save();
                echo json_encode(array());exit;
            }
        } else {
            echo json_encode(array());exit;
        }
    }

    public function locale($locale) {
        if ($locale) {
            App::setLocale($locale);
            session()->put('locale', $locale);
            return redirect()->back()->with('success', 'Locale ' . $locale . ' set.');
        } else {
            return redirect()->back()->with('error', 'Locale not set.');
        }
    }

    public function getlocale() {
        $session = App::getLocale();
        if (session()->get('locale') != '') {
            $session = session()->get('locale');
        }

        return $session;
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
        
		//save credit for student
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

    public function saveLoginSessionData(Request $request) {
        if (!empty($request->all())) {
            \Session::put('transaction_id', $request->input('transaction_id'));
			\Session::put('course_id', $request->input('course_id'));
			\Session::put('instructor_id', $request->input('instructor_id'));
			\Session::put('time', $request->input('time'));
			\Session::save();
            return json_encode(array(
                'status' => true
            ));
        }
        return json_encode(array(
            'status' => false
        ));
    }

    public function verify($email) {
        $email = base64_decode($email);
        return redirect('/')->with('success', 'Your email has been verified.');
    }

    public function applycoupon(Request $request)
    {
        if ( !empty( $request->input("coupon") ) ) {
            $coupon = Coupon::where('code', $request->input("coupon"))
                            ->where('status', '1')
                            ->whereRaw('number_of_usage > used')
                            ->first();

            if ($coupon) {
                if (time() > strtotime($coupon->startdate) && time() < strtotime($coupon->enddate)) {
                    \Session::put('coupon_id', $coupon->id);
                    \Session::save();
                    echo json_encode(array(
                        'status' => true,
                        'message' => 'Coupon Applied.',
                        'coupon' => $coupon
                    ));
                    exit;
                } else {
                    echo json_encode(array(
                        'status' => false,
                        'message' => 'Coupon expired.'
                    ));
                    exit;
                }
            } else {
                echo json_encode(array(
                    'status' => false,
                    'message' => 'Provided coupon is invalid.'
                ));
                exit;
            }
        } else {
            echo json_encode(array(
                'status' => false,
                'message' => 'Please enter coupon.'
            ));
            exit;
        }
    }

    public function unreadMessages() {
        $messages = \DB::table('messages')->where('to', \Auth::user()->id)
                            ->where('is_read', '0')
                            ->get();

        echo json_encode(array('count' => count($messages)));exit;
    }

    public function sendremindermail() {
        $start = date('Y-m-d H:i:s', strtotime('+26 hours'));

        $appointments = Appointment::where('startdate', '>=', $start)
                                    ->where('status', 1)
                                    ->get();

        if (count($appointments) > 0) {
            foreach ($appointments as $appointment) {
                $appointment->instructor = User::find($appointment->instructor_id);
                $appointment->student = User::find($appointment->user_id);

                $data = $appointment;

            // echo "<pre>";
            // print_r($data);exit;


                Mail::to('talhanadeem1721@gmail.com')->send(new StudentReminder($data));

                Mail::to('talhanadeem1721@gmail.com')->send(new TeacherReminder($data));


            }

            echo 'Appointment Reminder sent successfully.'; exit;
        } else {
            echo 'No Appointment found.'; exit;
        }
    }



    ///send hours mail
    public function sendhourmail() {
        $start = date('Y-m-d H:i:s', strtotime('+1 hours'));

        $appointments = Appointment::where('startdate', '>=', $start)
                                    ->where('status', 1)
                                    ->get();

        if (count($appointments) > 0) {
            foreach ($appointments as $appointment) {
                $appointment->instructor = User::find($appointment->instructor_id);
                $appointment->student = User::find($appointment->user_id);

                $data = $appointment;

            // echo "<pre>";
            // print_r($data);


                Mail::to('talhanadeem1721@gmail.com')->send(new StudentReminderHour($data));

                Mail::to('talhanadeem1721@gmail.com')->send(new TeacherReminderHour($data));


               
            }

            echo 'Appointment Reminder sent successfully.'; exit;
        } else {
            echo 'No Appointment found.'; exit;
        }
    }
}
