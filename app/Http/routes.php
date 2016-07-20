<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('welcome');
});

// Admin area
Route::get('admin', function () {
    return redirect('/admin/dashboard');
});

$router->group([
    'namespace' => 'Admin',
    'middleware' => 'auth',
        ], function () {
    Route::get('admin/dashboard', 'DashboardController@index');
    
    Route::get('admin/profile', 'DashboardController@getProfile');
    Route::post('admin/profile', 'DashboardController@postProfile');
    
    Route::get('admin/changepassword', 'DashboardController@getChangepassword');
    Route::post('admin/changepassword', 'DashboardController@postChangepassword');
    
    //User
    Route::resource('admin/users', 'UserController');
    Route::get('admin/users/destroy/{key}', 'UserController@destroy');
    //Item 
    Route::resource('admin/items', 'ItemController');
    Route::get('admin/items/destroy/{key}', 'ItemController@destroy');
    //Meal 
    Route::resource('admin/meals', 'MealController');
    Route::get('admin/meals/destroy/{key}', 'MealController@destroy');
    //Meals Items 
    Route::resource('admin/mealsitems', 'MealsItemController');
    Route::get('admin/mealsitems/destroy/{key}', 'MealsItemController@destroy');
    //Offer
    Route::resource('admin/offers', 'OfferController');
    Route::post('admin/offers/store', 'OfferController@store'); 
    Route::get('admin/offers/destroy/{key}', 'OfferController@destroy');    
     //Orders
    Route::resource('admin/orders', 'OrderController');
    Route::get('admin/orders/destroy/{key}', 'OrderController@destroy');
    Route::get('admin/orders/price/{id}', 'OrderController@price');

});

// Logging in and out
Route::get('/auth/login', 'Auth\AuthController@getLogin');
Route::post('/auth/login', 'Auth\AuthController@authenticate');
Route::get('/auth/logout', 'Auth\AuthController@getLogout');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');


