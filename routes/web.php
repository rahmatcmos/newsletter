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

Route::get('about', function () {
    // view file from README.md
    $about = \Markdown::convertToHtml(\File::get('../README.md'));

    return view('about', compact('about'));
})->name('about');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'namespace' => 'Auth', 'middleware' => 'auth'], function () {
    Route::group(['prefix' => 'newsletter', 'namespace' => 'Newsletter'], function () {
        // subscriber
        Route::get('subscribers/{list?}', 'SubscriberController@getIndex')->name('admin.subscriber');
        Route::get('subscriber/create', 'SubscriberController@getCreate')->name('admin.subscriber.create');
        Route::post('subscriber/create', 'SubscriberController@postCreate')->name('admin.subscriber.create.post');
        Route::get('subscriber/edit/{id}', 'SubscriberController@getEdit')->name('admin.subscriber.edit');
        Route::post('subscriber/edit', 'SubscriberController@postEdit')->name('admin.subscriber.edit.post');
        Route::get('subscriber/delete/{id}', 'SubscriberController@getDelete')->name('admin.subscriber.delete');
        Route::delete('subscriber/truncate', 'SubscriberController@deleteTruncate')->name('admin.subscriber.truncate');

        // lists
        Route::get('lists', 'ListController@getIndex')->name('admin.list');
        Route::post('lists', 'ListController@postCreate')->name('admin.list.create.post');
        Route::get('list/edit/{id}', 'ListController@getEdit')->name('admin.list.edit');
        Route::post('list/edit', 'ListController@postEdit')->name('admin.list.edit.post');
        Route::get('list/delete/{id}', 'ListController@getDelete')->name('admin.list.delete');

        // newsletter
        Route::get('/', 'NewsletterController@getIndex')->name('admin.newsletter');
        Route::get('detail/{id}', 'NewsletterController@getDetail')->name('admin.newsletter.detail');

        // unsubscribe reasons
        Route::get('reasons', 'ReasonController@getIndex')->name('admin.reason');
        Route::get('reason/detail/{id}', 'ReasonController@getDetail')->name('admin.reason.detail');
        Route::post('reason/create', 'ReasonController@postCreate')->name('admin.reason.create.post');
        Route::post('reason/edit', 'ReasonController@postEdit')->name('admin.reason.edit.post');
        Route::get('reason/delete/{id}', 'ReasonController@getDelete')->name('admin.reason.delete');
    });

    Route::group(['namespace' => 'User', 'prefix' => 'user'], function () {
        Route::get('/', 'UserController@getIndex')->name('admin.user');
        Route::get('profile/{id?}', 'UserController@getProfile')->name('admin.user.profile');
        Route::get('create', 'UserController@getCreate')->name('admin.user.create');
        Route::post('create', 'UserController@postCreate')->name('admin.user.create.post');
        Route::get('edit/{id}', 'UserController@getEdit')->name('admin.user.edit');
        Route::put('edit', 'UserController@putEdit')->name('admin.user.edit.put');
        Route::delete('delete', 'UserController@deleteDelete')->name('admin.user.delete');
    });

    Route::group(['namespace' => 'Setting', 'prefix' => 'setting'], function () {
        Route::get('/', 'SettingController@getIndex')->name('admin.setting');
        Route::post('/', 'SettingController@postCreate')->name('admin.setting.post');
        Route::post('email', 'SettingController@postEmail')->name('admin.setting.email');
    });
});

Route::group(['prefix' => 'newsletter'], function () {
    Route::get('/', 'NewsletterController@getIndex')->name('newsletter.index');
    Route::post('subscribe', 'NewsletterController@postSubscribe')->name('newsletter.subscribe');
    Route::get('confirm', 'NewsletterController@getConfirm')->name('newsletter.confirm');
    Route::get('unsubscribe', 'NewsletterController@getUnsubscribe')->name('newsletter.unsubscribe');
    Route::post('unsubscribe', 'NewsletterController@postReason')->name('newsletter.reason.post');
});

Route::group(['prefix' => 'contact'], function () {
    Route::get('/', 'ContactController@getIndex')->name('contact');
    Route::post('/', 'ContactController@postSend')->name('contact.post');
});
