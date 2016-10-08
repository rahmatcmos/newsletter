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
    return view('index');
})->name('index');

Route::get('about', function(){
	// view file from README.md
	$about = \Markdown::convertToHtml(\File::get('../README.md'));

	return view('about', compact('about'));
})->name('about');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'namespace' => 'Auth'], function(){
	Route::group(['prefix' => 'newsletter', 'namespace' => 'Newsletter'], function(){
		Route::get('subscribers', 'SubscriberController@getIndex')->name('admin.subscriber');
		Route::get('subscriber/create', 'SubscriberController@getCreate')->name('admin.subscriber.create');
		Route::post('subscriber/create', 'SubscriberController@postCreate')->name('admin.subscriber.create.post');
		Route::get('subscriber/delete/{id}', 'SubscriberController@getDelete')->name('admin.subscriber.delete');
	});
});

Route::group(['prefix' => 'newsletter'], function(){
	Route::get('/', 'NewsletterController@getIndex')->name('newsletter.index');
	Route::post('subscribe', 'NewsletterController@postSubscribe')->name('newsletter.subscribe');
	Route::get('confirm', 'NewsletterController@getConfirm')->name('newsletter.confirm');
});