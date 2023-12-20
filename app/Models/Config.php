<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use File;
use Illuminate\Support\Facades\Storage;
use DB;

class Config extends Model
{   
    protected $table = 'options';
    public $timestamps = false;
    protected $guarded = array();

    public static function get_options($code = '')
    {
        $options = DB::table('options')->where('code', '=', $code)->get();
        
        $return = array();
        foreach($options as $results)
        {
            $return[$results->locale][$results->option_key] = $results->option_value;
        }
        return $return; 
    }

    public static function get_option($code = '', $option_key = '')
    {
        $option = DB::table('options')
                ->where('code', '=', $code)
                ->where('option_key', '=', $option_key)
                ->first();
        
        return $option ? $option->option_value : '';
    }
    
    public static function save_options($code, $values, $seo_code)
    {
    
        //get the options first, this way, we can know if we need to update or insert options
        //we're going to create an array of keys for the requested code
        $options = Config::get_options($code);
        
        //loop through the options and add each one as a new row
        foreach($values as $key=>$value)
        {
            if ($key != 'seo_title' && $key != 'seo_description' && $key != 'seo_keywords') {
                // dd($key);
                foreach($value as $locale => $item) {
                    //if the key currently exists, update the option
                    if(array_key_exists($locale, $options))
                    {
                        DB::table('options')
                                ->where('option_key', $key)
                                ->where('code', $code)
                                ->where('locale', $locale)
                                ->update([
                                    'option_value' => $item,
                                    'seo_title' => $seo_code['seo_title'],
                                    'seo_description' => $seo_code['seo_description'],
                                    'seo_keywords' => $seo_code['seo_keywords'],
                                ]);
                    }
                    //if the key does not exist, add it
                    else
                    {
                        DB::table('options')->insert([
                            'code' => $code,
                            'option_key' => $key, 
                            'locale' => $locale, 
                            'option_value' => $value,
                            'seo_title' => $seo_code['seo_title'],
                            'seo_description' => $seo_code['seo_description'],
                            'seo_keywords' => $seo_code['seo_keywords'],
                            ]);
                    }
                }
            }
            
            
        }
    }
    
}
