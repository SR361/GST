<?php

namespace App\Http\Middleware;

// use App;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
// use App\Http\Controllers\DashboardController;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
    	// App::setLocale($request->segment(1));
        // app()->setLocale($request->segment(1));
        App::setLocale($request->segment(1));
        app()->setLocale($request->segment(1));
        // dd($request);
        return $next($request);
        // return $next($request);
    }
}
