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

Route::group(['prefix' => 'api/v1'], function() {
	Route::resource('clients',	 'ClientController');
	Route::resource('providers', 'ProviderController');
	Route::resource('products',  'ProductController');
	Route::resource('materials',  'MaterialController');

	Route::resource('products.materials',	 'MaterialController');
	Route::resource('commands', 'CommandController');
	Route::resource('fabrications',  'FabricationController');
	Route::resource('deliveries',  'DeliveryController');
});
