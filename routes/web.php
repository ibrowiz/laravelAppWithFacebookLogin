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

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
});

Route::get('/', function () {
    return view('welcome');
})->middleware('auth');



Auth::routes();

Route::get('/home', 'CategoryController@index')->name('home')->middleware('auth');
//facebook login
Route::get('login/facebook', 'Auth\LoginController@redirectToProvider')->name('login.facebook');
Route::get('login/facebook/callback', 'Auth\LoginController@handleProviderCallback');
//redirect registration to login page
Route::get('register', 'Auth\LoginController@redirectToProvider')->name('register');




//only admin and moderator access
Route::middleware(['admin','moderator'])->group(function () {
   
		Route::resource('nominationUsers', 'NominationUserController');

		Route::get('users', 'UserController@index');

		Route::delete('users/{id}', 'UserController@destroy');

		Route::put('users/{id}', 'UserController@update');

		Route::patch('users/{id}', 'UserController@update');

		//categories
		Route::match(['put','patch'], 'categories/{id}', 'CategoryController@update');

		Route::delete('categories/{id}', 'CategoryController@destroy');

		Route::post('categories', 'CategoryController@create');

		Route::get('categories/create', 'CategoryController@create');

		//nominations
		Route::match(['put','patch'], 'nominations/{id}', 'NominationController@update');

		Route::delete('nominations/{id}', 'NominationController@destroy');


		//only admin access
		Route::middleware(['admin'])->group(function () {

			Route::resource('roles', 'RoleController');

			Route::resource('settings', 'SettingController');

	});	

});


	//must be logged in
	Route::middleware(['auth'])->group(function () {
		Route::resource('categories', 'CategoryController');

		Route::resource('nominations', 'NominationController');

		Route::resource('votings', 'VotingController');

		Route::resource('users', 'UserController');
	});

		
