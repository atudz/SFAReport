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
	Route::get('/reversal/summary', ['as'=>'reversal-summary', 'uses'=>'ReversalPresenter@index']);
	Route::get('/cashpayments', ['as'=>'sales-collection', 'uses'=>'SalesCollectionPresenter@cashpayments']);
	Route::get('/checkpayments', ['as'=>'check-payments', 'uses'=>'SalesCollectionPresenter@checkpayments']);
	
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
	
			
	Route::get('/salesman/area/{salesman_code}', function($salesmanCode){
		return response()->json(salesman_area($salesmanCode));
	});
				
	Route::get('/salesman/sheet/{salesman_code}', function($salesmanCode){
		return response()->json(salesman_sheet_refno($salesmanCode));
	});
					
	Route::get('/salesman/sheet/{salesman_code}/{reference}', function($salesmanCode, $ref){
		return response()->json(salesman_sheet_date($salesmanCode,$ref));
	});
						
	Route::get('/salesman/adjustment/{salesman_code}', function($salesmanCode){
		return response()->json(salesman_sheet_refno($salesmanCode,'adjustment'));
	});
							
	Route::get('/salesman/jr/{salesman_code}', function($salesmanCode){
		return response()->json(sfa_jr_salesman($salesmanCode));
	});
								
	Route::get('/customer/area/{customer_code}', function($customerCode){
		return response()->json(customer_area($customerCode));
	});
									
	Route::get('/salesman/replenishment/refs/{salesman_code}/{type?}', function($salesmanCode, $type=''){
		return response()->json(replenishment_refs($salesmanCode,$type));
	});
										
	Route::get('/salesman/replenishment/dates/{salesman_code}/{type?}', function($salesmanCode, $type=''){
		return response()->json(replenishment_dates($salesmanCode,$type));
	});
	
	Route::get('/invoiceseries', ['as'=>'invoice-series', 'uses'=>'InvoicePresenter@index']);
	Route::get('/invoiceseries/add', ['as'=>'invoice-series-add', 'uses'=>'InvoicePresenter@create']);
	Route::get('/invoiceseries/edit/{id}', ['as'=>'invoice-series-edit', 'uses'=>'InvoicePresenter@edit']);
		
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
	
	Route::post('/vaninventory/stocktransfer', ['as'=>'stocktransfer-save', 'uses'=>'VanInventoryController@saveStockTransfer']);
	
	Route::group(['prefix' => 'profit-centers'],function(){
		Route::get('/', ['as'=>'profit-centers-index', 'uses'=>'ProfitCenterController@index']);		
		Route::post('/create', ['as'=>'profit-centers-create', 'uses'=>'ProfitCenterController@store']);		
		Route::group(['prefix' => '{profit_center_id}'],function(){
			Route::get('/', ['as'=>'profit-centers-show', 'uses'=>'ProfitCenterController@show']);			
			Route::post('/update', ['as'=>'profit-centers-update', 'uses'=>'ProfitCenterController@update']);			
			Route::get('/delete', ['as'=>'profit-centers-delete', 'uses'=>'ProfitCenterController@destroy']);
		});
	});
		
	Route::group(['prefix' => 'gl-accounts'],function(){
		Route::get('/', ['as'=>'gl-accounts-index', 'uses'=>'GLAccountsController@index']);
		Route::post('/create', ['as'=>'gl-accounts-create', 'uses'=>'GLAccountsController@store']);
		Route::group(['prefix' => '{gl_account_id}'],function(){
		Route::get('/', ['as'=>'gl-accounts-show', 'uses'=>'GLAccountsController@show']);
			Route::post('/update', ['as'=>'gl-accounts-update', 'uses'=>'GLAccountsController@update']);
			Route::get('/delete', ['as'=>'gl-accounts-delete', 'uses'=>'GLAccountsController@destroy']);
		});
	});
			
	Route::group(['prefix' => 'segment-codes'],function(){
		Route::get('/', ['as'=>'segment-codes-index', 'uses'=>'SegmentCodesController@index']);
		Route::post('/create', ['as'=>'segment-codes-create', 'uses'=>'SegmentCodesController@store']);
		Route::group(['prefix' => '{segment_code_id}'],function(){
			Route::get('/', ['as'=>'segment-codes-show', 'uses'=>'SegmentCodesController@show']);
			Route::post('/update', ['as'=>'segment-codes-update', 'uses'=>'SegmentCodesController@update']);
			Route::get('/delete', ['as'=>'segment-codes-delete', 'uses'=>'SegmentCodesController@destroy']);
		});
	});
				
	Route::group(['prefix' => 'document-types'],function(){
		Route::get('/', ['as'=>'document-types-index', 'uses'=>'DocumentTypesController@index']);					
		Route::post('/create', ['as'=>'document-types-create', 'uses'=>'DocumentTypesController@store']);					
		Route::group(['prefix' => '{document_type_id}'],function(){
			Route::get('/', ['as'=>'document-types-show', 'uses'=>'DocumentTypesController@show']);
			Route::post('/update', ['as'=>'document-types-update', 'uses'=>'DocumentTypesController@update']);
			Route::get('/delete', ['as'=>'document-types-delete', 'uses'=>'DocumentTypesController@destroy']);
		});
	});
	
	Route::post('/invoiceseries/save', ['as'=>'invoiceseries-save', 'uses'=>'InvoiceController@save']);
	Route::post('/invoiceseries/delete/{id}', ['as'=>'adjustment-delete', 'uses'=>'InvoiceController@destroy']);
		
});

Route::get('/sfi-transaction-data', ['as'=>'sfi-transaction-data-presenter', 'uses'=>'SfiTransactionDataPresenter@index']);
Route::get('/profit-centers', ['as'=>'profit-centers-presenter', 'uses'=>'ProfitCentersPresenter@index']);
Route::get('/profit-centers/add', ['as'=>'profit-centers-add', 'uses'=>'ProfitCentersPresenter@add']);
Route::get('/gl-accounts', ['as'=>'gl-accounts-presenter', 'uses'=>'GLAccountsPresenter@index']);
Route::get('/gl-accounts/add', ['as'=>'gl-accounts-add', 'uses'=>'GLAccountsPresenter@add']);
Route::get('/segment-codes', ['as'=>'segment-codes-presenter', 'uses'=>'SegmentCodesPresenter@index']);
Route::get('/segment-codes/add', ['as'=>'segment-codes-add', 'uses'=>'SegmentCodesPresenter@add']);
Route::get('/document-types', ['as'=>'document-types-presenter', 'uses'=>'DocumentTypesPresenter@index']);
Route::get('/document-types/add', ['as'=>'document-types-add', 'uses'=>'DocumentTypesPresenter@add']);


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

