<?php

Route::post('/signup', 'authController@signup');
Route::post('/login', 'authController@login');
Route::get('/logout', 'authController@logout');
Route::get('/user', 'authController@user')->middleware('auth')->name('account');

Route::get('/home', 'homeController@index');
Route::get('/', 'homeController@index')->name('home');
Route::get('/sell', 'homeController@sell')->name('sell');
Route::post('/sell', 'homeController@store')->middleware('auth');
Route::post('/buy/category', 'homeController@category');
Route::get('/about', 'homeController@about');

Route::get('/unsubscribe', 'homeController@unsubscribe');
Route::post('/unsubscribe', 'homeController@destroy_subscribe');

Route::post('/feedback', 'homeController@feedback');

Route::get('/terms', function () {
	return view('terms');
});
Route::get('privacy', function () {
	return view('privacy_policy');
});

Route::get('/buy/college', 'homeController@buy_from_college');
Route::get('/buy/university', 'homeController@buy_from_university');
// Route::get('/buy/state', 'homeController@buy_from_state');
Route::get('/buy', 'homeController@buy');
Route::get('/buy/all', 'homeController@all');

Route::get('/buy/{buy}', 'homeController@show')->middleware('auth');

Route::post('/buy/{id}/contact', 'homeController@contactData')->middleware('auth');
Route::post('/buy/{id}/message', 'homeController@message')->middleware('auth');

Route::post('/sold/{id}', 'homeController@sold')->middleware('auth');

/*******Ajax(not working in controller)******/

Route::post('/ajaxRequest', function () {
	if (Request::ajax()) {
		$college_names = \App\datas::where('university_name', $_POST['key'])->pluck('college_name');
		return $college_names;
		// return Response::json(Request::all());
	}
});

/*************/

Route::get('pagenotfound', ['as' => 'notfound', 'uses' => 'homeController@pagenotfound']);