<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\App;
use Closure;

class Language
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        return $next($request);
    }
}
