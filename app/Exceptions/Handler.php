<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use App\Models\User;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if(strpos($request->url(), 'https://speakify24.de/login') !== false || strpos($request->url(), 'https://speakify24.de/register') !== false)
        {
            return parent::render($request, $exception);
        }
        if(strpos($request->url(), 'https://speakify24.de/listing') !== false || strpos($request->url(), 'https://speakify24.de/messages') !== false)
        {
            return parent::render($request, $exception);
        }    
            return response()->view('errors.500', ['exception'=>$exception], 500);

        if (strpos($request->url(), 'https://speakify24.de/email/verify') !== false && $exception->getMessage() == 'Invalid signature.') {
            $url = $request->url();
            $id = explode("https://speakify24.de/email/verify/", $url);
            User::find($id[1])->sendEmailVerificationNotification();
            return redirect('/')->with('success', 'Link is expired, Verification email is sent again.');
        } else if (strpos($request->url(), 'https://speakify24.de/register') === false ) {
            return response()->view('errors.500', ['exception'=>$exception], 500);
        }

    }
}
