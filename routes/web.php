<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::get('index', 'TestController@index');
Route::match(['post','get'],'index','TestController@index');

// Route::post('test', 'TestController@test');

Route::get('in12/{name}/{dd}',function($name,$dd){

	return '123'.$name.'-'.$dd;
});


//中间件
//
Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){


	Route::get('index','LoginController@index');
});


Route::get('login','LoginController@test')->name('login');

Route::get('model/{Test}',function(App\Model\Test $Test){

	dd($Test);
});


Route::any('test/{moble}/{class}/{action}',function($moble,$class,$action){

	$class = 'App\\Http\\Controllers\\'.ucfirst(strtolower($moble)).'\\'.ucfirst(strtolower($class)).'Controller';

	if(class_exists($class)){
        // dd($class);
        $objectClass = new $class();

        if(method_exists($objectClass,$action)){
            return call_user_func(array($objectClass,$action));
        }
    }else{
	    return $class.'not exists';
    }




	dd($objectClass);
});


