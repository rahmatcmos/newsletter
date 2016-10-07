<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::group(['prefix' => 'admin', 'namespace' => 'Auth'], function(){
	Route::group(['prefix' => 'newsletter', 'namespace' => 'Newsletter'], function(){
		Route::get('subscribers', 'SubscriberController@getIndex')->name('admin.newsletter.subscriber.index');
	});
});

Route::group(['prefix' => 'newsletter'], function(){
	Route::get('/', 'NewsletterController@getIndex')->name('newsletter.index');
	Route::post('subscribe', 'NewsletterController@postSubscribe')->name('newsletter.subscribe');
});