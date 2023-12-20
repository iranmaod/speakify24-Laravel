<?php
/**
 * PHP Version 7.1.7-1
 * Functions for users
 *
 * @category  File
 * @package   Config
 * @author    Mohamed Yahya
 * @copyright ULEARN  
 * @license   BSD Licence
 * @link      Link
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;
use SiteHelpers;

/**
 * Class contain functions for admin
 *
 * @category  Class
 * @package   Config
 * @author    Mohamed Yahya
 * @copyright ULEARN
 * @license   BSD Licence
 * @link      Link
 */
class ConfigController extends Controller
{
   
    public function saveConfig(Request $request)
    {
        $files = Input::file();

        //get the input values from form
        $input = $request->all();
        $code = $request->input('code');

        unset($input['_token']);
        unset($input['code']);

        foreach($files as $file_key => $file_array) {
            //delete old file
            if (Storage::exists($input['old_'.$file_key])) {
                Storage::delete($input['old_'.$file_key]);
            }
            unset($input['old_'.$file_key]);
            //save the file in original name
            $file_name = $request->file($file_key)->getClientOriginalName();
            // create path
            $path = "config";

            //check if the file name is already exists
            $new_file_name = SiteHelpers::checkFileName($path, $file_name);

            $path = $request->file($file_key)->storeAs($path, $new_file_name);
            
            //upload the image and save the image name in array, to save it in DB
            $input[$file_key] = $path;
        }
        ///Seo code
        $seo_code =  [
            'seo_title' => $request->seo_title,
            'seo_description' => $request->seo_description,
            'seo_keywords' => $request->seo_keywords,
        ];
        
        //save the 
        Config::save_options($code, $input, $seo_code);
        return $this->return_output('flash', 'success', 'saved', 'back', '200');
    }

    
    public function pageHome(Request $request)
    {
        $config = Config::get_options('pageHome');
        $options = DB::table('options')->where('code', '=', 'pageHome')->first();
        return view('admin.config.page_home', compact('config', 'options'));
    }

    public function pageAbout(Request $request)
    {
        $config = Config::get_options('pageAbout');
        $options = DB::table('options')->where('code', '=', 'pageAbout')->first();
        return view('admin.config.page_about', compact('config', 'options'));
    }

    public function pageLogin(Request $request)
    {
        $config = Config::get_options('pageLogin');
        $options = DB::table('options')->where('code', '=', 'pageLogin')->first();
        return view('admin.config.page_login', compact('config', 'options'));
    }

    public function pageStudent(Request $request)
    {
        $config = Config::get_options('pageStudent');
        $options = DB::table('options')->where('code', '=', 'pageStudent')->first();
        return view('admin.config.page_student_register', compact('config', 'options'));
    }

    public function pageEmail(Request $request)
    {
        $config = Config::get_options('pageEmail');
        $options = DB::table('options')->where('code', '=', 'pageEmail')->first();
        $emailconfig = Config::where('code','bookingEmail')->first()->option_key;
       // dd($config);
        return view('admin.config.page_email', compact('config','emailconfig', 'options'));
    }

    public function pageEmailCancel(Request $request)
    {
        $config = Config::get_options('pageEmailCancel');
        $options = DB::table('options')->where('code', '=', 'pageEmailCancel')->first();
       // $emailconfig = Config::where('code','bookingEmail')->first()->option_key;
       // dd($config);
        return view('admin.config.page-email-cancel', compact('config', 'options'));
    }


    public function pageTeacher(Request $request)
    {
        $config = Config::get_options('pageTeacher');
        $options = DB::table('options')->where('code', '=', 'pageTeacher')->first();
        return view('admin.config.page_teacher_register', compact('config', 'options'));
    }

    public function pageTerm(Request $request)
    {
        $config = Config::get_options('pageTerm');
        $options = DB::table('options')->where('code', '=', 'pageTerm')->first();
        return view('admin.config.page_terms', compact('config', 'options'));
    }

    public function pagePlatform(Request $request)
    {
        $config = Config::get_options('pagePlatform');
        $options = DB::table('options')->where('code', '=', 'pagePlatform')->first();
        return view('admin.config.page_platform', compact('config', 'options'));
    }

    public function pageMethod(Request $request)
    {
        $config = Config::get_options('pageMethod');
        $options = DB::table('options')->where('code', '=', 'pageMethod')->first();
        return view('admin.config.page_method', compact('config', 'options'));
    }

    public function pageOurInstructors(Request $request)
    {
        $config = Config::get_options('pageOurteacher');
        $options = DB::table('options')->where('code', '=', 'pageOurteacher')->first();
        return view('admin.config.page_ourteacher', compact('config', 'options'));
    }

    public function pageChildrens(Request $request)
    {
        $config = Config::get_options('pageSchoolstudent');
        $options = DB::table('options')->where('code', '=', 'pageSchoolstudent')->first();
        return view('admin.config.page_schoolstudent', compact('config', 'options'));
    }

    public function pageCitizen(Request $request)
    {
        $config = Config::get_options('pageCitizen');
        $options = DB::table('options')->where('code', '=', 'pageCitizen')->first();
        return view('admin.config.page_citizen', compact('config', 'options'));
    }

    public function pageCompany(Request $request)
    {
        $config = Config::get_options('pageCompany');
        $options = DB::table('options')->where('code', '=', 'pageCompany')->first();
        return view('admin.config.page_company', compact('config', 'options'));
    }

    public function pagePrice(Request $request)
    {
        $config = Config::get_options('pagePrice');
        $options = DB::table('options')->where('code', '=', 'pagePrice')->first();
        return view('admin.config.page_price', compact('config', 'options'));
    }

    public function pageCertificate(Request $request)
    {
        $config = Config::get_options('pageCertificate');
        $options = DB::table('options')->where('code', '=', 'pageCertificate')->first();
        return view('admin.config.page_certificate', compact('config', 'options'));
    }

    public function pageEnglish(Request $request)
    {
        $config = Config::get_options('pageEnglish');
        $options = DB::table('options')->where('code', '=', 'pageEnglish')->first();
        return view('admin.config.page_english', compact('config', 'options'));
    }

    public function pageDutch(Request $request)
    {
        $config = Config::get_options('pageDutch');
        $options = DB::table('options')->where('code', '=', 'pageDutch')->first();
        return view('admin.config.page_dutch', compact('config', 'options'));
    }

    public function pageSpanish(Request $request)
    {
        $config = Config::get_options('pageSpanish');
        $options = DB::table('options')->where('code', '=', 'pageSpanish')->first();
        return view('admin.config.page_spanish', compact('config', 'options'));
    }

    public function pageItalian(Request $request)
    {
        $config = Config::get_options('pageItalian');
        $options = DB::table('options')->where('code', '=', 'pageItalian')->first();
        return view('admin.config.page_italian', compact('config', 'options'));
    }

    public function pageContact(Request $request)
    {
        $config = Config::get_options('pageContact');
        $options = DB::table('options')->where('code', '=', 'pageContact')->first();
        return view('admin.config.page_contact', compact('config', 'options'));
    }

    public function pageHourly(Request $request)
    {
        $config = Config::get_options('pageHourly');
        $options = DB::table('options')->where('code', '=', 'pageHourly')->first();
        return view('admin.config.page_hourly', compact('config', 'options'));
    }

    public function pageMonthly(Request $request)
    {
        $config = Config::get_options('pageMonthly');
        $options = DB::table('options')->where('code', '=', 'pageMonthly')->first();
        return view('admin.config.page_monthly', compact('config', 'options'));
    }

    public function pageImprint(Request $request)
    {
        $config = Config::get_options('pageImprint');
        $options = DB::table('options')->where('code', '=', 'pageImprint')->first();
        return view('admin.config.page_imprint', compact('config', 'options'));
    }

    public function pageAgreement(Request $request)
    {
        $config = Config::get_options('pageAgreement');
        $options = DB::table('options')->where('code', '=', 'pageAgreement')->first();
        return view('admin.config.page_agreement', compact('config', 'options'));
    }

    public function pageCondition(Request $request)
    {
        $config = Config::get_options('pageCondition');
        $options = DB::table('options')->where('code', '=', 'pageCondition')->first();
        return view('admin.config.page_condition', compact('config', 'options'));
    }


    public function settingGeneral(Request $request)
    {
        $config = Config::get_options('settingGeneral');
        $options = DB::table('options')->where('code', '=', 'settingGeneral')->first();
       // dd($config);
        return view('admin.config.setting_general', compact('config', 'options'));
    }

    public function settingPayment(Request $request)
    {
        $config = Config::get_options('settingPayment');
        $options = DB::table('options')->where('code', '=', 'settingPayment')->first();
        return view('admin.config.setting_payment', compact('config', 'options'));
    }

    public function settingEmail(Request $request)
    {
        $config = Config::get_options('settingEmail');
        $options = DB::table('options')->where('code', '=', 'settingEmail')->first();
        return view('admin.config.setting_email', compact('config', 'options'));
    }

    ///new///
    public function saveEmailLang(Request $request)
    {
        $emailconfig = Config::where('code',$request->code)->update([
            'option_key' => $request->option_key
         ]);
        return redirect()->back();
    }


    public function pageReset(Request $request)
    {
        $config = Config::get_options('pageReset');
        $options = DB::table('options')->where('code', '=', 'pageReset')->first();
        return view('admin.config.page-reset', compact('config', 'options'));
    }

    


}
