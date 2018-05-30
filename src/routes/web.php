<?php


   Route::get('error', function()
   {
	echo 'Hello from the Error-track package!';
})->middleware('ErrortrackSession');


 Route::get('hello', function()
   {
	echo 'Hello from the Error-track package!';
});

 Route::get('/test/{name}')
    ->uses('laravel\errortrack\Controllers\TestController@index');

 