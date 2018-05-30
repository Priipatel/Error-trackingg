<?php 

namespace Errorlog\errortrack\Helpers\Common;

use Errorlog\errortrack\Models\LogResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Log;
use DB;
class Common 
{
	public static function responsedata($routeName, $method, $request, $response, $env, $projectName)
	{
		 Log::info($routeName);
		 Log::info($method);
		 Log::info($request);
		 Log::info($response);
		 Log::info($env);
		 Log::info($projectName);

		$checkcondition = config('config.log');

		 if ($checkcondition == 1) 
		 {
		 	$newData = new LogResponse;
		 	$logData['route_name'] = $routeName;
		 	$logData['method'] = $method;
		 	$logData['request'] = json_encode($request);
		 	$logData['response'] = $response;
		 	$logData['environment'] = $env;
		 	$logData['project_name'] = $projectName;

		 	$newData->fill($logData);
	        $newData->save();

	        // DB::table('response')->insert(['route_name' => $routeName, 'method' =>  $method, 'request' => json_encode($request), 'response' => $response,'environment' => $env,'project_name' => $projectName]);

	     } 
	}
}

	