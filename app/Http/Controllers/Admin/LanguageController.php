<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use Illuminate\Support\Facades\Validator;
use DB;

class LanguageController extends Controller
{
   public function index(Request $request)
   {
        $paginate_count = 10;
        if($request->has('search')){
            $search = $request->input('search');
            $languages = Language::where('title', 'LIKE', '%' . $search . '%')
                           ->paginate($paginate_count);
        }
        else {
            $languages = Language::paginate($paginate_count);
        }
        
        return view('admin.languages.index', compact('languages'));
    }

    public function getForm($language_id='', Request $request)
    {
        if($language_id) {
            $language = Language::find($language_id);
        }else{
            $language = $this->getColumnTable('languages');
			$language->is_enabled = true;
			//var_dump($language);
        }
        return view('admin.languages.form', compact('language'));
    }

    public function saveLanguage(Request $request)
    {
        // echo '<pre>';print_r($_POST);exit;
        $language_id = $request->input('language_id');

        $validation_rules = ['title' => 'required|string|max:50'];

        $validator = Validator::make($request->all(),$validation_rules);

        // Stop if validation fails
        if ($validator->fails()) {
            return $this->return_output('error', 'error', $validator, 'back', '422');
        }

        if ($language_id) {
            $language = Language::find($language_id);
            $success_message = 'Language updated successfully';
        } else {
            $language = new Language();
            $success_message = 'Language added successfully';
        }

        $language->title = $request->input('title');
		$language->code = $request->input('code');         
        $language->is_enabled = $request->input('is_enabled');
        $language->save();

        return $this->return_output('flash', 'success', $success_message, 'admin/languages', '200');
    }

    public function deleteLanguage($language_id)
    {
        Language::destroy($language_id);
        return $this->return_output('flash', 'success', 'Language deleted successfully', 'admin/languages', '200');
    }
}
