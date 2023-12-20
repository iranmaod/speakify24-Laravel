<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Role;
use App\Models\Instructor;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use Illuminate\Support\Facades\Storage;
use Image;
use SiteHelpers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if (isset($data['teacher'])) {
            return Validator::make($data, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'telephone' => 'required',
                'country_id' => 'required',
                'street' => 'required|max:100|string',
                'city' => 'required|max:100|string',
                'zip' => 'required|max:20|string',
                'language_teach_id' => 'required',
                'tax_number' => 'required|max:200|string',
                'paypal_id' => 'required|max:200|string',
                'language_speak_id' => 'required',
                'who' => 'required|max:150',
                'experience' => 'required|max:150',
                'love_job' => 'required|max:150',
                'cv' => 'required',
                'photo' => 'required',
                'terms' => 'required',
                'over_18' => 'required'
            ]);
        } else {
            return Validator::make($data, [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'terms' => 'required',
            ]);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $userData = array(
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'ip' => $data['ip'],
            'timezone' => $data['timezone'],
        );
        if (isset($data['offer'])) {
            $userData['offer'] = 1;
        }

        $user = User::create($userData);

        if (isset($data['teacher'])) {
            $user->roles()
                ->attach(Role::where('name', 'instructor')->first());

            $slug = $data['first_name'].'-'.$data['last_name'];
            $slug = str_slug($slug, '-');

            $results = \DB::select(\DB::raw("SELECT count(*) as total from instructors where instructor_slug REGEXP '^{$slug}(-[0-9]+)?$' "));

            $finalSlug = ($results['0']->total > 0) ? "{$slug}-{$results['0']->total}" : $slug;

            $request = request();

            $teacherCV = $request->file('cv');
            $teacherCV_url = '';
            if ($teacherCV) {
                $teacherCVSaveAsName = time() . "-cv." . $teacherCV->getClientOriginalExtension();

                $upload_path = 'storage/app/public/teacher_cvs/'.$user->id.'/';
                $teacherCV_url = $upload_path . $teacherCVSaveAsName;
                $success = $teacherCV->move($upload_path, $teacherCVSaveAsName);
                $teacherCV_url = 'teacher_cvs/'.$user->id.'/' . $teacherCVSaveAsName;
            }

            $photo = $request->file('photo');
            $photo_url = '';
            if ($photo) {
                // $photoSaveAsName = time() . "-photo." . $photo->getClientOriginalExtension();

                // $upload_path = 'storage/app/public/instructor/'.$user->id.'/';
                // $photo_url = $upload_path . $photoSaveAsName;
                // $success = $photo->move($upload_path, $photoSaveAsName);
                // $photo_url = 'instructor/'.$user->id.'/' . $photoSaveAsName;

                //get filename
                $file_name   = time() . "-photo." . $request->file('photo')->getClientOriginalName();

                // returns Intervention\Image\Image
                $image_make = Image::make($request->file('photo'))
                                        ->resize(300, null, function ($constraint) {
                                            $constraint->aspectRatio();
                                        })->encode('jpg');

                // create path
                $path = "instructor/".$user->id;

                //check if the file name is already exists
                $new_file_name = SiteHelpers::checkFileName($path, $file_name);

                //save the image using storage
                Storage::put($path."/".$new_file_name, $image_make->__toString(), 'public');

                $photo_url = $path."/".$new_file_name;
            }

            Instructor::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'contact_email' => $data['email'],
                'telephone' => $data['telephone'],
                'instructor_slug' => $finalSlug,
                'user_id' => $user->id,
                'language_speak_id' => $data['language_speak_id'],
                'language_teach_id' => $data['language_teach_id'],
                'country_id' => $data['country_id'],
                'street' => $data['street'],
                'city' => $data['city'],
                'zip' => $data['zip'],
                'tax_number' => $data['tax_number'],
                'paypal_id' => $data['paypal_id'],
                'who' => $data['who'],
                'experience' => $data['experience'],
                'love_job' => $data['love_job'],
                'cv' => $teacherCV_url,
                'instructor_image' => $photo_url,
            ]);

            \Mail::send([], [
                'data' => $data
            ], function ($message) use($data){
                $MailBody = 'Hi!<br /><b>'.$data['first_name'].' '.$data['last_name'].' ('.$data['email'].')</b> registered as teacher with following information.<br />'.
                'Telephone: <b>'.$data['telephone'].'</b><br />'.
                'Biography:<br />Who are you?'.$data['who'].'<br />'.
                'What teaching experience do you have?'.$data['experience'].'<br />'.
                'Why do you love your job?'.$data['love_job'].'<br />'.
                '<br /><br />Thanks!';
                $message->setBody($MailBody, 'text/html');
                $message->subject($data['first_name'].' '.$data['last_name'].' Registered');
                $message->from('registration@speakify24.com', $data['first_name'].' '.$data['last_name']);
                $message->to('info@speakify24.com');
            });

            // \Mail::send([], [
            //     'data' => $data
            // ], function ($message) use($data){
            //     $MailBody = 'Hi! <b>'.$data['first_name'].' '.$data['last_name'].' ('.$data['email'].')</b><br /><br />Thanks for registration, we will shortly approve your application.<br /><br />'.
            //     'Please click the following link to verify your account.<br />'.
            //     \Url::to('verify').'/'.base64_encode($data['email']).
            //     '<br /><br />Thanks!';
            //     $message->setBody($MailBody, 'text/html');
            //     $message->subject('Speakify Registration');
            //     $message->from('registration@speakify24.com', 'Speakify Team');
            //     $message->to($data['email']);
            // });

            $user->is_active = 0;
            $user->save();
        } else {
            $user->roles()
                ->attach(Role::where('name', 'student')->first());
        }

        return $user;
    }

    public function register(Request $request)
    {
        $requestData = $request->all();
        $this->validator($requestData)->validate();

        //Determine User type
        event(new Registered($user = $this->create($requestData)));

        if (!isset($requestData['teacher'])) {
            $this->guard()->login($user);
        } else {
            \Auth::logout();
        }

        return $this->registered($request, $user)
                        ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, $user)
    {
        $request->session()->flash('notification', 'Thank you for registering! We will contact you shorly.');
    }
}
    