<?php

namespace Errorlog\errortrack\Middleware;

use Errorlog\errortrack\Helpers\Common\Common;
use Illuminate\Support\Facades\Route;
use Log;
use Closure;
// use Illuminate\Support\Facades\Route;

class ErrortrackSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd('okay');
        return $next($request);
    }

     public function terminate($request, $response)
    {
        // dd('in terminate');
        // $test = config('common','log');
        $requests = $request->all();
        $routename = Route::getFacadeRoot()->current()->uri();
        $actionName = Route::getCurrentRoute()->getActionName();
        $environment = config('config.env');
        $appName = config('config.app');
        $method = $_SERVER['REQUEST_METHOD'];
                
               
        Common::responsedata($routename, $method, $requests, $response, $environment, $appName);

        Log::debug($response);
    }

}
