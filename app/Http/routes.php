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

/*
 * Add routes to Presenters below. The URL should not contain /controller & /service 
 * at the first url because this is reserved for controllers and webservices
 */

Route::group(['after' => 'no-cache'], function()
{
    Route::get('/login', ['as' => 'login','uses' => 'AuthPresenter@login']);
});


Route::get('/', ['as'=>'dashboard', 'uses'=>'MainPresenter@home']);
Route::get('/dashboard', ['as'=>'dashboard 2', 'uses'=>'MainPresenter@home']);
Route::get('/profile', ['as'=>'profile', 'uses'=>'UserPresenter@profile']);
Route::get('/changepass', ['as'=>'change-pass', 'uses'=>'UserPresenter@changePassword']);
Route::get('/logout', ['as'=>'userlogout', 'uses'=>'AuthController@logout']);

Route::group(['prefix' => 'reports'],function(){
	Route::get('/salescollection/{type?}', ['as'=>'sales-collection', 'uses'=>'ReportsPresenter@salesCollection']);
	Route::get('/vaninventory/{type?}', ['as'=>'van-inventory', 'uses'=>'ReportsPresenter@vanInventory']);
	Route::get('/bir', ['as'=>'bir', 'uses'=>'ReportsPresenter@bir']);
	Route::get('/sync', ['as'=>'sync', 'uses'=>'ReportsPresenter@sync']);
});

/*
 * Add routes to Controller below. The URL should contain /controller 
 * at the first. This serves as an identifier for the controller. The controller
 * should only be set on POST method. Avoid using /service in the first of the url since
 * this is exclusively used by the webservice only.
 */

// This is only for testing purpose. In actual it should be post
Route::group(['prefix' => 'controller'],function(){
	Route::post('/login', ['as'=>'userlogin', 'uses'=>'AuthController@authenticate']);
	Route::get('/reports/getdata/{type}', ['as'=>'report-getdata', 'uses'=>'ReportsController@getRecords']);
});


/*
 * Add routes to WebServices below. The URL should contain /service 
 * at the first. This serves as an identifier for the Web Services. 
 * Avoid using /controller in the first of the url since
 * this is exclusively used by the controllers only.
 */
/* Route::group(['prefix' => 'service'],function(){
	
	Route::get('/', 'TestWebService@index');
	
}); */
/*
* Create custom filter below. 
*/

Route::filter('no-cache',function($route, $request, $response){
    $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
    $response->headers->set('Pragma','no-cache');
    $response->headers->set('Expires','Fri, 01 Jan 1990 00:00:00 GMT');
});

