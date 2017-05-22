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
	
	Route::get('/stocktransfer', ['as'=>'stock-transfer', 'uses'=>'VanInventoryPresenter@stockTransfer']);	
	Route::get('/stocktransfer/add', ['as'=>'stock-transfer-add', 'uses'=>'VanInventoryPresenter@createStockTransfer']);
	
	Route::get('/stockaudit', ['as'=>'stock-audit', 'uses'=>'VanInventoryPresenter@stockAudit']);
	
	Route::get('/flexideal', ['as'=>'flexi-deal', 'uses'=>'VanInventoryPresenter@flexiDeal']);
	
	Route::get('/cashpayments', ['as'=>'cash-payments', 'uses'=>'SalesCollectionPresenter@cashpayments']);
	Route::get('/checkpayments', ['as'=>'check-payments', 'uses'=>'SalesCollectionPresenter@checkpayments']);	
	Route::get('/reversal/summary', ['as'=>'reversal-summary', 'uses'=>'ReversalPresenter@index']);
	
	Route::get('/actualcount', ['as'=>'actualcount', 'uses'=>'VanInventoryPresenter@actualCount']);
	Route::get('/actualcount/add', ['as'=>'actualcount-add', 'uses'=>'VanInventoryPresenter@createActualCount']);
	Route::get('/actualcount/edit/{id}', ['as'=>'actualcount-edit', 'uses'=>'VanInventoryPresenter@editActualCount']);
	
	Route::get('/adjustment', ['as'=>'adjustment', 'uses'=>'VanInventoryPresenter@adjustment']);
	Route::get('/adjustment/add', ['as'=>'adjustment-add', 'uses'=>'VanInventoryPresenter@createAdjustment']);
	Route::get('/adjustment/edit/{id}', ['as'=>'adjustment-edit', 'uses'=>'VanInventoryPresenter@editAdjustment']);
	
	Route::get('/invoiceseries', ['as'=>'invoice-series', 'uses'=>'InvoicePresenter@index']);
	Route::get('/invoiceseries/add', ['as'=>'invoice-series-add', 'uses'=>'InvoicePresenter@create']);
	Route::get('/invoiceseries/edit/{id}', ['as'=>'invoice-series-edit', 'uses'=>'InvoicePresenter@edit']);
	
	Route::get('/bouncecheck', ['as'=>'bounce-check', 'uses'=>'BounceCheckPresenter@index']);
	Route::get('/bouncecheck/add', ['as'=>'bounce-check-add', 'uses'=>'BounceCheckPresenter@create']);
	Route::get('/bouncecheck/edit/{id}', ['as'=>'bounce-check-edit', 'uses'=>'BounceCheckPresenter@edit']);
	
	Route::get('/salesreport/{type?}', ['as'=>'sales-report', 'uses'=>'ReportsPresenter@salesReport']);
	Route::get('/unpaidinvoice', ['as'=>'unpaid', 'uses'=>'ReportsPresenter@unpaidInvoice']);
	Route::get('/bir', ['as'=>'bir', 'uses'=>'ReportsPresenter@bir']);
	Route::get('/sync', ['as'=>'sync', 'uses'=>'ReportsPresenter@sync']);
	Route::post('/getdata/{type}', ['as'=>'report-getdata', 'uses'=>'ReportsPresenter@getRecords']);
	Route::get('/getdata/{type}', ['as'=>'report-getdata', 'uses'=>'ReportsPresenter@getRecords']);
	Route::get('/getheaders/{type?}', ['as'=>'report-getheaders', 'uses'=>'ReportsPresenter@getTableColumns']);
	Route::get('/export/{type}/{report}/{page?}', ['as'=>'report-export', 'uses'=>'ReportsPresenter@exportReport']);
	Route::get('/getcount/{report}/{type?}', ['as'=>'report-count', 'uses'=>'ReportsPresenter@getDataCount']);
	
	Route::get('/synching/{id}/{column}', ['as'=>'synch', 'uses'=>'ReportsPresenter@isSynching']);
	
	Route::get('/salesman/customer/{salesman_code}', function($salesmanCode){
		return response()->json(salesman_customer($salesmanCode));
	});
	
	Route::get('/salesman/sheet/{salesman_code}', function($salesmanCode){
		return response()->json(salesman_sheet_refno($salesmanCode));
	});
	
		Route::get('/salesman/adjustment/{salesman_code}', function($salesmanCode){
			return response()->json(salesman_sheet_refno($salesmanCode,'replenishment'));
		});
	
	Route::get('/salesman/jr/{salesman_code}', function($salesmanCode){
		return response()->json(sfa_jr_salesman($salesmanCode));
	});
	
	Route::get('/customer/area/{customer_code}', function($customerCode){
		return response()->json(customer_area($customerCode));
	});
});


Route::group(['prefix' => 'user'],function(){
	Route::get('/file-size', ['as'=>'user-get', 'uses'=>'UserPresenter@getFileSize']);
	Route::get('/edit/{id}', ['as'=>'user-get', 'uses'=>'UserPresenter@getUser']);
	Route::get('/getemails/{id?}', ['as'=>'user-get-emails', 'uses'=>'UserPresenter@getUserEmails']);
	Route::get('/getusernames/{id?}', ['as'=>'user-get-usernames', 'uses'=>'UserPresenter@getUsernames']);
	Route::get('/list', ['as'=>'user-list', 'uses'=>'UserPresenter@userList']);
	Route::get('/contactus', ['as'=>'user-contact-us', 'uses'=>'UserPresenter@contactUs']);
	Route::get('/summaryofincidentreport', ['as'=>'user-summary-of-incident-report', 'uses'=>'UserPresenter@summaryOfIncidentReport']);
	Route::get('/addEdit', ['as'=>'user-add-edit', 'uses'=>'UserPresenter@addEdit']);
	Route::get('/edit', ['as'=>'user-edit', 'uses'=>'UserPresenter@edit']);
	Route::get('/group/rights', ['as'=>'user-group-rights', 'uses'=>'UserPresenter@userGroupRights']);
	Route::get('/myprofile', ['as'=>'user-profile', 'uses'=>'UserPresenter@myProfile']);
	Route::get('/userGuide', ['as'=>'user-guide', 'uses'=>'UserGuidePresenter@userGuide']);
});

	Route::get('contact-us', ['as' => 'contact-us-status', 'uses' => 'UserController@userContactUsActionOrStatus']);

Route::get('/open-closing-period', ['as'=>'open-closing-period', 'uses'=>'OpenClosingPeriodPresenter@index']);
Route::post('/open-closing-period/request-reports', ['as'=>'open-closing-period-reports', 'uses'=>'OpenClosingPeriodPresenter@reports']);
Route::get('/period/print-report', ['as'=>'period-print-report', 'uses'=>'OpenClosingPeriodPresenter@printReport']);

Route::get('/user-access-matrix', ['as'=>'user-access-matrix', 'uses'=>'UserAccessMatrixPresenter@user']);

Route::get('/role-access-matrix', ['as'=>'role-access-matrix', 'uses'=>'UserAccessMatrixPresenter@role']);

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
	Route::get('/user/generate/{code}/{user_id?}', ['as'=>'user-generate-jr-salesman-code', 'uses'=>'UserController@getJrSalesmanCode']);
	Route::get('/user/activate/{id}', ['as'=>'user-activate', 'uses'=>'UserController@activate']);
	Route::get('/user/deactivate/{id}', ['as'=>'user-deactivate', 'uses'=>'UserController@deactivate']);
	Route::get('/user/delete/{id}', ['as'=>'user-delete', 'uses'=>'UserController@delete']);
	//Route::get('/user/save', ['as'=>'user-save', 'uses'=>'UserController@save']);	
	Route::post('/user/save', ['as'=>'user-save', 'uses'=>'UserController@save']);
	Route::post('/user/changepass', ['as'=>'report-save', 'uses'=>'UserController@changePassword']);
	//Route::get('/user/changepass', ['as'=>'report-save', 'uses'=>'UserController@changePassword']);
	Route::post('/resetpass', ['as'=>'password-reset', 'uses'=>'AuthController@resetPassword']);
	Route::post('/user/contact', ['as'=>'user-contact-us', 'uses'=>'UserController@userContactUs']);
	Route::post('/user/contact/file/{support_id}', ['as'=>'user-contact-us', 'uses'=>'UserController@userContactUsFileUpload']);
	Route::post('/user/userguide/file/{user_type}', ['as' => 'user-guide', 'uses' => 'UserGuideController@userGuideFileUpload']);
	Route::get('/user/userguide/download/{id}', ['as' => 'user-guide-download', 'uses' => 'UserGuideController@download']);
	Route::get('/user/contact/mail/{support_id}', ['as'=>'user-contact-us', 'uses'=>'UserController@mail']);
	Route::post('/vaninventory/stocktransfer', ['as'=>'stocktransfer-save', 'uses'=>'VanInventoryController@saveStockTransfer']);
	Route::post('/vaninventory/actualcount', ['as'=>'actualcount-save', 'uses'=>'VanInventoryController@saveActualCount']);
	Route::post('/vaninventory/actualcount/delete/{id}', ['as'=>'actualcount-delete', 'uses'=>'VanInventoryController@deleteActualCount']);
	Route::post('/vaninventory/adjustment', ['as'=>'adjustment-save', 'uses'=>'VanInventoryController@saveAdjustment']);
	Route::post('/vaninventory/adjustment/delete/{id}', ['as'=>'adjustment-delete', 'uses'=>'VanInventoryController@deleteAdjustment']);
	
	Route::post('/invoiceseries/save', ['as'=>'invoiceseries-save', 'uses'=>'InvoiceController@save']);
	Route::post('/invoiceseries/delete/{id}', ['as'=>'adjustment-delete', 'uses'=>'InvoiceController@destroy']);
	
	Route::post('/bouncecheck/save', ['as'=>'bouncecheck-save', 'uses'=>'BounceCheckController@save']);
	Route::post('/bouncecheck/delete/{id}', ['as'=>'bouncecheck-delete', 'uses'=>'BounceCheckController@destroy']);

	Route::post('/period/update-status', ['as'=>'period-close', 'uses'=>'OpenClosingPeriodController@updateStatus']);
	Route::post('/period/update-date', ['as'=>'period-update-date', 'uses'=>'OpenClosingPeriodController@updateDate']);

	Route::post('/user-access-matrix/load-permissions', ['as'=>'user-access-matrix-load-permission', 'uses'=>'UserAccessMatrixController@loadPermissions']);

	Route::post('/user-access-matrix/save-permissions', ['as'=>'user-access-matrix-save-permission', 'uses'=>'UserAccessMatrixController@savePermissions']);
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
