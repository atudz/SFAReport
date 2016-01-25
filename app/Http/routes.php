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
    Route::get('/forgotpass', ['as'=>'forgot', 'uses'=>'AuthPresenter@forgotPassword']);
});

Route::get('/', ['as'=>'dashboard', 'uses'=>'MainPresenter@home']);
Route::get('/home', ['as'=>'home', 'uses'=>'ReportsPresenter@index']);
Route::get('/profile', ['as'=>'profile', 'uses'=>'UserPresenter@profile']);
Route::get('/changepass', ['as'=>'change-pass', 'uses'=>'UserPresenter@changePassword']);
Route::get('/logout', ['as'=>'userlogout', 'uses'=>'AuthController@logout']);

Route::group(['prefix' => 'reports'],function(){
	Route::get('/salescollection/{type?}', ['as'=>'sales-collection', 'uses'=>'ReportsPresenter@salesCollection']);
	Route::get('/vaninventory/{type?}', ['as'=>'van-inventory', 'uses'=>'ReportsPresenter@vanInventory']);
	Route::get('/salesreport/{type?}', ['as'=>'sales-report', 'uses'=>'ReportsPresenter@salesReport']);
	Route::get('/unpaidinvoice', ['as'=>'unpaid', 'uses'=>'ReportsPresenter@unpaidInvoice']);
	Route::get('/bir', ['as'=>'bir', 'uses'=>'ReportsPresenter@bir']);
	Route::get('/sync', ['as'=>'sync', 'uses'=>'ReportsPresenter@sync']);
	Route::post('/getdata/{type}', ['as'=>'report-getdata', 'uses'=>'ReportsPresenter@getRecords']);
	Route::get('/getdata/{type}', ['as'=>'report-getdata', 'uses'=>'ReportsPresenter@getRecords']);
	Route::get('/getheaders/{type?}', ['as'=>'report-getheaders', 'uses'=>'ReportsPresenter@getTableColumns']);
	Route::get('/export/{type}/{report}/{page?}', ['as'=>'report-export', 'uses'=>'ReportsPresenter@exportReport']);
	Route::get('/getcount/{report}/{type?}', ['as'=>'report-count', 'uses'=>'ReportsPresenter@getDataCount']);
});


Route::group(['prefix' => 'user'],function(){
	Route::get('/edit/{id}', ['as'=>'user-get', 'uses'=>'UserPresenter@getUser']);
	Route::get('/getemails/{id?}', ['as'=>'user-get-emails', 'uses'=>'UserPresenter@getUserEmails']);
	Route::get('/getusernames/{id?}', ['as'=>'user-get-usernames', 'uses'=>'UserPresenter@getUsernames']);
	Route::get('/list', ['as'=>'user-list', 'uses'=>'UserPresenter@userList']);
	Route::get('/addEdit', ['as'=>'user-add-edit', 'uses'=>'UserPresenter@addEdit']);
	Route::get('/edit', ['as'=>'user-edit', 'uses'=>'UserPresenter@edit']);
	Route::get('/group/rights', ['as'=>'user-group-rights', 'uses'=>'UserPresenter@userGroupRights']);
	Route::get('/myprofile', ['as'=>'user-profile', 'uses'=>'UserPresenter@myProfile']);
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
	Route::post('/reports/save', ['as'=>'report-save', 'uses'=>'ReportsController@save']);
	Route::get('/reports/sync', ['as'=>'report-sync', 'uses'=>'ReportsController@sync']);

	Route::get('/user/activate/{id}', ['as'=>'user-activate', 'uses'=>'UserController@activate']);
	Route::get('/user/deactivate/{id}', ['as'=>'user-deactivate', 'uses'=>'UserController@deactivate']);
	Route::get('/user/delete/{id}', ['as'=>'user-delete', 'uses'=>'UserController@delete']);
	//Route::get('/user/save', ['as'=>'user-save', 'uses'=>'UserController@save']);	
	Route::post('/user/save', ['as'=>'user-save', 'uses'=>'UserController@save']);
	Route::post('/user/changepass', ['as'=>'report-save', 'uses'=>'UserController@changePassword']);
	//Route::get('/user/changepass', ['as'=>'report-save', 'uses'=>'UserController@changePassword']);
	Route::post('/resetpass', ['as'=>'password-reset', 'uses'=>'AuthController@resetPassword']);
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

