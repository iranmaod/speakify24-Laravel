<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Verified;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request)
    {
        // $user = User::find($request->route('id'));

        if (!auth()->check()) {
            auth()->loginUsingId($request->route('id'));
        }

        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }
    
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }
    
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
    
        if ($request->user()->hasRole('instructor')) {
            \Auth::logout();
            return redirect('/')->with('success', 'Your Email Address has been verified. Please wait for admin to approve your profile');
        }
        return redirect($this->redirectPath())->with('verified', true)->with('success', 'Your Email Address has been verified.');
    }
}
