<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Blog extends Model implements TranslatableContract
{
    use Translatable;
    protected $table = 'blogs';
    protected $guarded = array();
    public $translatedAttributes = ['blog_title', 'blog_slug', 'description'];
}
