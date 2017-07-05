/**
 * Application controller list
 */

(function(){
	'use strict';

	/**
	 * Sales & Collection Report controller
	 */
	var app = angular.module('app');
	var defaultDate = '';
	var fetch = true;
	
	app.controller('SalesCollectionReport',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',SalesCollectionReport]);
	
	function SalesCollectionReport($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'company_code',
				  'customer_name',
				  'invoice_date_from',
				  'invoice_date_to',
				  'collection_date_from',
				  'collection_date_to',
				  'posting_date_from',
				  'posting_date_to',
				  'salesman',
				  'invoice_number',
				  'or_number'

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'salescollectionreport',params,$log, TableFix);

		//editable rows
		editTable($scope, $uibModal, $resource, $window, {}, $log, TableFix);

		$scope.options = [
			{
				value : 'invoice_date',
				name  : 'Invoice Date'
			},
			{
				value : 'or_date',
				name  : 'Collection Date'
			},
			{
				value : 'check_date',
				name  : 'Check Date'
			}
		];
		//mass edit
		massEdit($scope, $uibModal, 'report');
	}
	
	
	/**
	 * Sales & Collection Posting controller
	 */

	app.controller('SalesCollectionPosting',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',SalesCollectionPosting]);
	
	function SalesCollectionPosting($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{		
		deletePreviousCache($route,$templateCache);

		var params = [
				  'company_code',
				  'customer_name',
				  'invoice_date_from',
				  'invoice_date_to',
				  'collection_date_from',
				  'collection_date_to',
				  'posting_date_from',
				  'posting_date_to',
				  'salesman',
				  'invoice_number',
				  'or_number'
		];

		// main controller
		reportController($scope,$resource,$uibModal,$window,'salescollectionposting',params,$log, TableFix);

	}


	/**
	 * Sales & Collection Summary controller
	 */

	app.controller('SalesCollectionSummary',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',SalesCollectionSummary]);

	function SalesCollectionSummary($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'company_code',
				  'invoice_date_from',
				  'salesman',
				  'area'

		];

		// main controller
		reportController($scope,$resource,$uibModal,$window,'salescollectionsummary',params,$log,TableFix);
	}
	
	/**
	 * Cash payments controller
	 */
	app.controller('CashPaymentsReport',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',CashPaymentsReport]);
	
	function CashPaymentsReport($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'company_code',
				  'customer_code',
				  'area_code',
				  'invoice_date_from',
				  'invoice_date_to',		          
				  'or_date_from',
				  'or_date_to',
				  'salesman',

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'cashpayment',params,$log, TableFix);

		//editable rows
		editTable($scope, $uibModal, $resource, $window, {}, $log, TableFix);

	}
	
	/**
	 * Check payments controller
	 */
	app.controller('CheckPaymentsReport',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',CheckPaymentsReport]);
	
	function CheckPaymentsReport($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'company_code',
				  'customer_code',
				  'area_code',
				  'invoice_date_from',
				  'invoice_date_to',		          
				  'or_date_from',
				  'or_date_to',
				  'salesman',

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'checkpayment',params,$log, TableFix);

		//editable rows
		editTable($scope, $uibModal, $resource, $window, {}, $log, TableFix);

	}

	/**
	 * Van & Inventory (Canned) controller
	 */

	app.controller('VanInventoryCanned',['$scope','$resource','$uibModal','$window','$log', 'InventoryFixTable','$route','$templateCache','$http',VanInventoryCanned]);

	function VanInventoryCanned($scope, $resource, $uibModal, $window, $log, InventoryFixTable,$route,$templateCache,$http)
	{
		deletePreviousCache($route,$templateCache);
		$scope.item_code = {};

		vanInventoryController($scope, $resource, $uibModal, $window, 'vaninventorycanned', $log, InventoryFixTable,$http);

		//editable rows
		editTable($scope, $uibModal, $resource, $window, {}, $log);
	}

	/**
	 * Van & Inventory (Frozen) controller
	 */

	app.controller('VanInventoryFrozen',['$scope','$resource','$uibModal','$window','$log', 'InventoryFixTable','$route','$templateCache','$http',VanInventoryFrozen]);

	function VanInventoryFrozen($scope, $resource, $uibModal, $window, $log, InventoryFixTable,$route,$templateCache,$http)
	{
		deletePreviousCache($route,$templateCache);

		vanInventoryController($scope, $resource, $uibModal, $window, 'vaninventoryfrozen', $log, InventoryFixTable,$http);

		//editable rows
		editTable($scope, $uibModal, $resource, $window, {}, $log);
	}

	/**
	 * Van Inventory Stock Transfer Report
	 */
	app.controller('StockTransfer',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',StockTransfer]);
	
	function StockTransfer($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'salesman_code',
				  'company_code',
				  'area',
				  'segment',
				  'item_code',
				  'transfer_date_from',
				  'transfer_date_to',		          		          
				  'stock_transfer_number'		          

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'stocktransfer',params,$log, TableFix);

		//editable rows
		editTable($scope, $uibModal, $resource, $window, {}, $log, TableFix);

		$scope.options = [
			{
				value : 'transfer_date',
				name  : 'Transaction Date'
			}
		];
		//mass edit
		massEdit($scope, $uibModal, 'stock-transfer');
	}
	
	
	/**
	 * Van Inventory Stock Audit Report
	 */
	app.controller('StockAudit',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',StockAudit]);
	
	function StockAudit($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'salesman_code',		          
				  'area',
				  'month_from',
				  'year_from',
				  'period_from',
				  'period_to',		          		          
				  'reference_number'		          

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'stockaudit',params,$log, TableFix);

	}
	
	
	/**
	 * Van Inventory Stock Audit Report
	 */
	app.controller('FlexiDeal',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',FlexiDeal]);
	
	function FlexiDeal($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'salesman_code',		          
				  'area_code',
				  'customer_code',
				  'company_code',
				  'invoice_date_from',
				  'invoice_date_to',		          		          
				  'item_code'		          

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'flexideal',params,$log, TableFix);

	}
	
	
	/**
	 * Van Inventory Stock Audit Report
	 */
	app.controller('ActualCount',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',ActualCount]);
	
	function ActualCount($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		$scope.editHide = 'hidden'
		$scope.url = '#actualcount.edit/';
		$scope.editUrl = '';
		
		var params = [
				  'salesman_code',		          
				  'replenishment_date_from',
				  'reference_number'		          		          

		];

	    reportController($scope,$resource,$uibModal,$window,'actualcount',params,$log, TableFix);

	}
	
	/**
	 * User List controller
	 */
	app.controller('ActualCountAdd',['$scope','$resource','$location','$window','$uibModal','$log','$route','$templateCache', ActualCountAdd]);

	function ActualCountAdd($scope, $resource, $location, $window, $uibModal, $log,$route, $templateCache) {
		
		deletePreviousCache($route,$templateCache);

		
		$scope.preview = function (){		
			var modalInstance = $uibModal.open({
				animation: true,
				templateUrl: 'ActualCountPreview',
				controller: 'ActualCountPreview',
				windowClass: 'center-modal',
				size: 'lg'
			});	
		};
		
		$scope.save = function (){
			var hasError = false;
			
			$('input[name^=quantity]').each(function(){
				if($(this).val()<0){
					$(this).next('span').html('Quantity must not be negative.');
					$(this).parent().parent().addClass('has-error');
				}
			});
			
			if(!hasError){
				
				var API = $resource('controller/vaninventory/actualcount');
				
				var items = $("select[name^='item_code']").map(function (idx, el) {
								return $(el).val();
							}).get();
				var quantities = $("input[name^='quantity']").map(function (idx, el) {
								return $(el).val();
							}).get();
				var params = {
					'salesman_code': $('#salesman_code').val(),
					'replenishment_date_from': $('#replenishment_date_from').val(),
					'reference_number': $('#reference_number').val(),
					'counted': $('#counted').val(),
					'confirmed': $('#confirmed').val(),
					'last_sr': $('#last_sr').val(),
					'last_rprr': $('#last_rprr').val(),
					'last_cs': $('#last_cs').val(),
					'last_dr': $('#last_dr').val(),
					'last_ddr': $('#last_ddr').val(),
					'item_code': items,
					'quantity': quantities,
					'id': $('#id').val()
				};
				
				API.save(params).$promise.then(function(data){
					$location.path('vaninventory.actualcount');
				}, function(error){
					if(error.data){
						$('.help-block').html('');
						$.each(error.data, function(index, val){
							if(-1 !== index.indexOf('_from')){
								$('[id='+index+']').parent().next('.help-block').html(val);
								$('[id='+index+']').parent().parent().parent().addClass('has-error');
							} else {
								$('[id='+index+']').next('.help-block').html(val);
								$('[id='+index+']').parent().parent().addClass('has-error');
							}						
						});
					}
				});
			}			
		}
		
		
		$scope.remove = function () {			
			var params = { id:$('#id').val(), reference_num: $('#reference_number').val() };
			var modalInstance = $uibModal.open({
				animation: true,
				scope: $scope,
				templateUrl: 'DeleteActualcount',
				controller: 'ActualCountDelete',
				windowClass: 'center-modal',
				size: 'lg',
				resolve: {
					params: function () {
						return params;
					}
				}
			});
		}
	};
	
	/**
	 * Actual Count Preview
	 */
	app.controller('ActualCountPreview',['$scope','$http','$uibModalInstance','$log',ActualCountPreview]);
	
	function ActualCountPreview($scope, $http, $uibModalInstance, $log)
	{
		
		var replenishment = '';
		if(angular.element('#replenishment_date_from').val()){
			// @todo: add date format with time
			replenishment = angular.element('#replenishment_date_from').val();
		}
		var salesman = '';
		if(angular.element('#salesman_code').val()){
			salesman = angular.element('#salesman_code option:selected').text();
		}
		var jr_salesman = '';
		if(angular.element('#jr_salesman').val()){
			jr_salesman = angular.element('#jr_salesman option:selected').text();
		}
		var van_code = '';
		if(angular.element('#van_code').val()){
			van_code = angular.element('#van_code option:selected').text();
		}
		
		var details = {
				'salesman_name' : salesman,
				'jr_salesman' : jr_salesman,
				'van_code' : van_code,
				'replenishment_date' : replenishment,
				'reference' : angular.element('#reference_number').val(),
		};
		$scope.details = details;
		
		var items = new Array();
		
		angular.element('#table_items').find('tr[id^=items]').each(function(i,el){
				var tds = $(this).find('td');
				items.push({
						item_code: tds.eq(0).find("option:selected").text(),
						item_desc: tds.eq(1).find("option:selected").text(),
						item_qty: tds.eq(2).find("input").val()
					});
		});
		
		$scope.items = items;
		$log.info(details);
		$log.info(items);
		
		$scope.close = function(){
			$uibModalInstance.dismiss('cancel');
		}
	}
	

	/**
	 * Van Inventory Replenishment Delete
	 */
	app.controller('ActualCountDelete',['$scope','$resource','$uibModalInstance','params','$location','$log','EditableFixTable','$route','$templateCache',ActualCountDelete]);
	
	function ActualCountDelete($scope, $resource, $uibModalInstance, params,$location, $log, EditableFixTable,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.params = params;
		
		$scope.save = function (){			
			var API = $resource('controller/vaninventory/actualcount/delete/'+$scope.params.id);
			var params = {
					'remarks': $('#remarks').val()					
				};
			
			API.save(params).$promise.then(function(data){
				$location.path('vaninventory.actualcount');
			}, function(error){
				if(error.data){
					$log.info(error);
					$('.help-block').html('');
					$.each(error.data, function(index, val){
						$('[id='+index+']').next('.help-block').html(val);
						$('[id='+index+']').parent().parent().addClass('has-error');												
					});
				}
			});
			
		}
		
		$scope.cancel = function (){
			$uibModalInstance.dismiss('cancel');
		}
	}

	
	/**
	 * Van Inventory Adjustment Adjustment
	 */
	app.controller('Adjustment',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',Adjustment]);
	
	function Adjustment($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		$scope.editHide = 'hidden'
		$scope.url = '#adjustment.edit/';
		$scope.editUrl = '';
		
		var params = [
				  'salesman_code',		          
				  'replenishment_date_from',
				  'reference_number',
				  'adjustment_reason'

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'adjustment',params,$log, TableFix);

	}
	
	/**
	 * User List controller
	 */
	app.controller('AdjustmentAdd',['$scope','$resource','$location','$window','$uibModal','$log', '$route', '$templateCache', AdjustmentAdd]);

	function AdjustmentAdd($scope, $resource, $location, $window, $uibModal, $log, $route, $templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.save = function (){
			var hasError = false;			
			
			if(!hasError){
				
				var API = $resource('controller/vaninventory/adjustment');
				
				var items = $("select[name^='item_code']").map(function (idx, el) {
								return $(el).val();
							}).get();
				var quantities = $("input[name^='quantity']").map(function (idx, el) {
								return $(el).val();
							}).get();
				var brands = $("select[name^='brands']").map(function (idx, el) {
									return $(el).val();
							}).get();
				
				var params = {
					'salesman_code': $('#salesman_code').val(),
					'replenishment_date_from': $('#replenishment_date_from').val(),
					'reference_number': $('#reference_number').val(),
					'adjustment_reason': $('#adjustment_reason').val(),					
					'item_code': items,
					'quantity': quantities,
					'brands': brands,
					'id': $('#id').val()
				};
				
				API.save(params).$promise.then(function(data){
					$location.path('vaninventory.adjustment');
				}, function(error){
					if(error.data){
						$('.help-block').html('');
						$.each(error.data, function(index, val){
							if(-1 !== index.indexOf('_from')){
								$('[id='+index+']').parent().next('.help-block').html(val);
								$('[id='+index+']').parent().parent().parent().addClass('has-error');
							} else {
								$('[id='+index+']').next('.help-block').html(val);
								$('[id='+index+']').parent().parent().addClass('has-error');
							}						
						});
					}
				});
			}			
		}
		
		
		$scope.remove = function () {			
			var params = { id:$('#id').val(), reference_num: $('#reference_number').val() };
			var modalInstance = $uibModal.open({
				animation: true,
				scope: $scope,
				templateUrl: 'DeleteAdjustment',
				controller: 'AdjustmentDelete',
				windowClass: 'center-modal',
				size: 'lg',
				resolve: {
					params: function () {
						return params;
					}
				}
			});
		}
	};
	

	/**
	 * Van Inventory Replenishment Delete
	 */
	app.controller('AdjustmentDelete',['$scope','$resource','$uibModalInstance','params','$location','$log','EditableFixTable','$route','$templateCache',AdjustmentDelete]);
	
	function AdjustmentDelete($scope, $resource, $uibModalInstance, params,$location, $log, EditableFixTable,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.params = params;
		
		$scope.save = function (){			
			var API = $resource('controller/vaninventory/adjustment/delete/'+$scope.params.id);
			var params = {
					'remarks': $('#remarks').val()					
				};
			
			API.save(params).$promise.then(function(data){
				$location.path('vaninventory.adjustment');
			}, function(error){
				if(error.data){
					$log.info(error);
					$('.help-block').html('');
					$.each(error.data, function(index, val){
						$('[id='+index+']').next('.help-block').html(val);
						$('[id='+index+']').parent().parent().addClass('has-error');												
					});
				}
			});
			
		}
		
		$scope.cancel = function (){
			$uibModalInstance.dismiss('cancel');
		}
	}
	
	/**
	 * Van Inventory Stock Audit Report
	 */
	app.controller('Replenishment',['$scope','$resource','$uibModal','$window','$log','TableFix','toaster',Replenishment]);
	
	function Replenishment($scope, $resource, $uibModal, $window, $log, TableFix, toaster)
	{	    	
		
		var params = [
	    		  'salesman_code',		          
		          'replenishment_date',
		          'reference_number',
		          'type',
		          'area_code',

		];

	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'replenishment',params,$log, TableFix);
	    
	    executeReplenishment($scope, $resource, $uibModal, params,$log,toaster);

	}
	
	/**
	 * User List controller
	 */
	app.controller('StockTransferAdd',['$scope','$resource','$location','$window','$uibModal','$log','$route','$templateCache', StockTransferAdd]);

	function StockTransferAdd($scope, $resource, $location, $window, $uibModal, $log, $route, $templateCache) {

		deletePreviousCache($route,$templateCache);

		
		$scope.save = function (){
			var API = $resource('controller/vaninventory/stocktransfer');
			
			var params = {
				'stock_transfer_number': $('#stock_transfer_number').val(),
				'stock_transfer_id': $('#stock_transfer_id').val(),
				'transfer_date_from': $('#transfer_date_from').val(),
				'src_van_code': $('#src_van_code').val(),
				'dest_van_code': $('#dest_van_code').val(),
				'type': $('#type').val(),
				'item_code': $('#item_code').val(),
				'salesman_code': $('#salesman_code').val(),
				'uom_code': $('#uom_code').val(),
				'quantity': $('#quantity').val(),
			};
			
			API.save(params).$promise.then(function(data){
				$location.path('vaninventory.stocktransfer');
			}, function(error){
				if(error.data){
					$('.help-block').html('');
					$.each(error.data, function(index, val){
						if(-1 !== index.indexOf('_from')){
							$('[id='+index+']').parent().next('.help-block').html(val);
							$('[id='+index+']').parent().parent().parent().addClass('has-error');
						} else {
							$('[id='+index+']').next('.help-block').html(val);
							$('[id='+index+']').parent().parent().addClass('has-error');
						}						
					});
				}
			});
		}
	};
	
	
	/**
	 * Van Inventory Replenishment Adjustment
	 */
	app.controller('InvoiceSeries',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',InvoiceSeries]);
	
	function InvoiceSeries($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'salesman_code',		          
				  'invoice_start',
				  'invoice_end',
				  'status'

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'invoiceseries',params,$log, TableFix);

	}
	
	/**
	 * User List controller
	 */
	app.controller('InvoiceSeriesAdd',['$scope','$resource','$location','$window','$uibModal','$log','$templateCache','$route', InvoiceSeriesAdd]);

	function InvoiceSeriesAdd($scope, $resource, $location, $window, $uibModal, $log, $templateCache, $route) {
		deletePreviousCache($route,$templateCache);

		var currentPageTemplate = $route.current.loadedTemplateUrl;
		$templateCache.remove(currentPageTemplate);

		$scope.save = function (){
			var hasError = false;						
			if(!hasError){
				
				var API = $resource('controller/invoiceseries/save');				
				var params = {
					'salesman_code': $('#salesman_code').val(),
					'invoice_start': $('#invoice_start').val(),
					'invoice_end': $('#invoice_end').val(),
					'status': $('#status').val(),
					'id' : $('#id').val()
				};
				
				API.save(params).$promise.then(function(data){
					$location.path('invoiceseries.mapping');
				}, function(error){
					if(error.data){
						$('.help-block').html('');
						$.each(error.data, function(index, val){
							if(-1 !== index.indexOf('_from')){
								$('[id='+index+']').parent().next('.help-block').html(val);
								$('[id='+index+']').parent().parent().parent().addClass('has-error');
							} else {
								$('[id='+index+']').next('.help-block').html(val);
								$('[id='+index+']').parent().parent().addClass('has-error');
							}						
						});
					}
				});
			}			
		}
		
		
		$scope.remove = function () {			
			var params = { id:$('#id').val(), id: $('#id').val() };
			var modalInstance = $uibModal.open({
				animation: true,
				scope: $scope,
				templateUrl: 'DeleteInvoiceSeries',
				controller: 'InvoiceSeriesDelete',
				windowClass: 'center-modal',
				size: 'lg',
				resolve: {
					params: function () {
						return params;
					}
				}
			});
		}
	};
	

	/**
	 * Van Inventory Replenishment Delete
	 */
	app.controller('InvoiceSeriesDelete',['$scope','$resource','$uibModalInstance','params','$location','$log','EditableFixTable','$route','$templateCache',InvoiceSeriesDelete]);
	
	function InvoiceSeriesDelete($scope, $resource, $uibModalInstance, params,$location, $log, EditableFixTable,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.params = params;
		
		$scope.save = function (){			
			var API = $resource('controller/invoiceseries/delete/'+$scope.params.id);
			var params = {
					'remarks': $('#remarks').val()					
				};
			
			API.save(params).$promise.then(function(data){
				$location.path('invoiceseries.mapping');
			}, function(error){
				if(error.data){
					$log.info(error);
					$('.help-block').html('');
					$.each(error.data, function(index, val){
						$('[id='+index+']').next('.help-block').html(val);
						$('[id='+index+']').parent().parent().addClass('has-error');												
					});
				}
			});
			
		}
		
		$scope.cancel = function (){
			$uibModalInstance.dismiss('cancel');
		}
	}
	
	
	/**
	 * Bounce Check Controller
	 */
	app.controller('BounceCheck',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',BounceCheck]);
	
	function BounceCheck($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'salesman_code',		          
				  'area_code',
				  'customer_code',
				  'txn_number',
				  'invoice_date_from',
				  'dm_date_from',
				  'reason'

		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'bouncecheck',params,$log, TableFix);

	}
	
	/**
	 * BounceCheck Add Controller
	 */
	app.controller('BounceCheckAdd',['$scope','$resource','$location','$window','$uibModal','$log','$templateCache','$route', BounceCheckAdd]);

	function BounceCheckAdd($scope, $resource, $location, $window, $uibModal, $log, $templateCache, $route) {
		deletePreviousCache($route,$templateCache);

		$scope.save = function (){
			var hasError = false;						
			if(!hasError){
				
				var API = $resource('controller/bouncecheck/save');				
				var params = {
					'salesman_code': $('#salesman_code').val(),
					'customer_code': $('#customer_code').val(),
					'dm_number': $('#dm_number').val(),
					'dm_date_from': $('#dm_date_from').val(),
					'invoice_number': $('#invoice_number').val(),
					'invoice_date_from': $('#invoice_date_from').val(),
					'bank_name': $('#bank_name').val(),
					'cheque_number': $('#cheque_number').val(),
					'cheque_date_from': $('#cheque_date_from').val(),
					'account_number': $('#account_number').val(),
					'reason': $('#reason').val(),
					'original_amount': $('#original_amount').val(),
					'payment_amount': $('#payment_amount').val(),
					'payment_date_from': $('#payment_date_from').val(),
					'remarks': $('#remarks').val(),
					'balance_amount': $('#balance_amount').val(),
					'txn_number': $('#txn_number').val(),
					'id' : $('#id').val()
				};
				
				API.save(params).$promise.then(function(data){
					$location.path('bounce.check');
				}, function(error){
					if(error.data){
						$('.help-block').html('');
						$.each(error.data, function(index, val){
							if(-1 !== index.indexOf('_from')){
								$('[id='+index+']').parent().next('.help-block').html(val);
								$('[id='+index+']').parent().parent().parent().addClass('has-error');
							} else {
								$('[id='+index+']').next('.help-block').html(val);
								$('[id='+index+']').parent().parent().addClass('has-error');
							}						
						});
					}
				});
			}			
		}
		
		
		$scope.remove = function () {			
			var params = { txn_number: $('#txn_number').val() };
			var modalInstance = $uibModal.open({
				animation: true,
				scope: $scope,
				templateUrl: 'DeleteBounceCheck',
				controller: 'BounceCheckDelete',
				windowClass: 'center-modal',
				size: 'lg',
				resolve: {
					params: function () {
						return params;
					}
				}
			});
		}
	};
	

	/**
	 * Bounce Check Delete
	 */
	app.controller('BounceCheckDelete',['$scope','$resource','$uibModalInstance','params','$location','$log','EditableFixTable','$route','$templateCache',BounceCheckDelete]);
	
	function BounceCheckDelete($scope, $resource, $uibModalInstance, params,$location, $log, EditableFixTable,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.params = params;
		
		$scope.save = function (){			
			var API = $resource('controller/bouncecheck/delete/'+$scope.params.txn_number);
			var params = {
					'remarks': $('#remarks').val()					
				};
			
			API.save(params).$promise.then(function(data){
				$location.path('bounce.check');
			}, function(error){
				if(error.data){
					$log.info(error);
					$('.help-block').html('');
					$.each(error.data, function(index, val){
						$('[id='+index+']').next('.help-block').html(val);
						$('[id='+index+']').parent().parent().addClass('has-error');												
					});
				}
			});
			
		}
		
		$scope.cancel = function (){
			$uibModalInstance.dismiss('cancel');
		}
	}
	
	/**
	 * Van Inventory Controller
	 */
	function vanInventoryController(scope, resource, modal, window, reportType, log, InventoryFixTable, http)
	{
		// Filter flag
		scope.toggleFilter = true;

		// items data
		scope.items = [];

		// item_code data
		scope.item_codes = [];

		var report = reportType;

		// Fetch table data from server
		scope.records = [];

		var API = resource('/reports/getdata/'+report);
		var params = [
				  'salesman_code',
				  'transaction_date',
				  'transaction_date_from',
				  'transaction_date_to',
				  'status',
				  'inventory_type',
				  'invoice_number',
				  'stock_transfer_number',
				  'return_slip_num',
				  'reference_number',
				  'audited_by'
		];

		http
			.get('/reports/vaninventory/' + (report == 'vaninventorycanned' ? 'canned' : 'frozen') + '/item-codes')
			.then(function(response){
				var th_ctr = 8;
				angular.element('th').addClass('van-inventory-header');
				angular.forEach(response.data, function(value, key){
					angular.element('th').eq(th_ctr).addClass('code_' + value.item_code).addClass('code-header');
					th_ctr++;
				});
			}, function(){

			});

		scope.checkIfHeaderDisplayed = function (code){
			return angular.element('.code-header.' + code).css('display') != 'none' ? true : false;
		};

		// Filter table records
		filterSubmitVanInventory(scope,API,params,log, InventoryFixTable);

		// Download report
		downloadReport(scope, modal, resource, window, report, params, log);

		// Format date
		formatDate(scope);
	}
	/**
	 * Unpaid Report
	 */
	app.controller('Unpaid',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',Unpaid]);

	function Unpaid($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
					  'company_code',
					  'invoice_date_from',
					  'invoice_date_to',
					  'invoice_number',
					  'salesman',
					  'customer'
			];

		// main controller
		reportController($scope,$resource,$uibModal,$window,'unpaidinvoice',params,$log);
	}

	/**
	 * Sales Report Per Material
	 */
	app.controller('SalesReportPerMaterial',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',SalesReportPerMaterial]);

	function SalesReportPerMaterial($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'posting_date_from',
				  'posting_date_to',
				  'return_date_from',
				  'return_date_to',
				  'salesman_code',
				  'area',
				  'company_code',
				  'customer',
				  'material',
				  'invoice_number',
				  'segment'
		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'salesreportpermaterial',params,$log);

		var API = '';
		$scope.conditionCodes = function(){
			API = $resource('/reports/getdata/conditioncodes');
			API.get({},function(data){
				$scope.codes = data;
				//$log.info(data);
			});
		}

		//Edit table records
		//var selectAPI = '/reports/getdata/conditioncodes';
		var options = {GOOD:'GOOD',BAD:'BAD'};
		editTable($scope, $uibModal, $resource, $window, options, $log);

		$scope.options = [
			{
				value : 'invoice_return_date',
				name  : 'Invoice Date/Return Date'
			},
			{
				value : 'invoice_return_posting_date',
				name  : 'Invoice/Return Posting Date'
			},
		];

		//mass edit
		massEdit($scope, $uibModal, 'per-material');
	}

	/**
	 * Sales Report Per Peso
	 */
	app.controller('SalesReportPerPeso',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',SalesReportPerPeso]);

	function SalesReportPerPeso($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'posting_date_from',
				  'posting_date_to',
				  'return_date_from',
				  'return_date_to',
				  'salesman_code',
				  'area',
				  'company_code',
				  'invoice_number',
				  'customer'
		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'salesreportperpeso',params,$log);

		editTable($scope, $uibModal, $resource, $window, {}, $log);

		$scope.options = [
			{
				value : 'invoice_return_date',
				name  : 'Invoice Date/Return Date'
			},
			{
				value : 'invoice_return_posting_date',
				name  : 'Invoice/Return Posting Date'
			},
		];

		//mass edit
		massEdit($scope, $uibModal, 'peso-value');
	}


	/**
	 * Return Report Per Material
	 */
	app.controller('ReturnReportPerMaterial',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',ReturnReportPerMaterial]);

	function ReturnReportPerMaterial($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'posting_date_from',
				  'posting_date_to',
				  'return_date_from',
				  'return_date_to',
				  'salesman_code',
				  'area',
				  'company_code',
				  'invoice_number',
				  'material',
				  'customer',
				  'segment'
		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'returnpermaterial',params,$log);
	}


	/**
	 * Return Report Per Peso
	 */
	app.controller('ReturnReportPerPeso',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',ReturnReportPerPeso]);

	function ReturnReportPerPeso($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'posting_date_from',
				  'posting_date_to',
				  'return_date_from',
				  'return_date_to',
				  'salesman_code',
				  'area',
				  'customer',
				  'company_code',
				  'invoice_number',
				  'material',
				  'segment'
		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'returnperpeso',params,$log);
	}

	/**
	 * Customer List
	 */
	app.controller('CustomerList',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',CustomerList]);

	function CustomerList($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'salesman_code',
				  'area',
				  'status',
				  'company_code',
				  'customer_name',
				  'customer_price_group',
				  'sfa_modified_date_from',
				  'sfa_modified_date_to',
		];

		// main controller
		reportController($scope,$resource,$uibModal,$window,'customerlist',params,$log);
	}


	/**
	 * Salesman List
	 */
	app.controller('SalesmanList',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',SalesmanList]);

	function SalesmanList($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'salesman_code',
				  'area',
				  'status',
				  'company_code',
				  'sfa_modified_date_from',
				  'sfa_modified_date_to'
		];

		// main controller
		reportController($scope,$resource,$uibModal,$window,'salesmanlist',params,$log);

	}

	/**
	 * Material Price List
	 */
	app.controller('MaterialPriceList',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',MaterialPriceList]);

	function MaterialPriceList($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'company_code',
				  'area',
				  'segment_code',
				  'item_code',
				  'status',
				  'sfa_modified_date_from',
				  'sfa_modified_date_to',
				  'effective_date1_from',
				  'effective_date1_to',
				  'effective_date2_from',
				  'effective_date2_to',
		];

		// main controller
		reportController($scope,$resource,$uibModal,$window,'materialpricelist',params,$log);

	}

	/**
	 * Bir controller
	 */

	app.controller('Bir',['$scope','$resource','$uibModal','$window','$log','$route','$templateCache',Bir]);

	function Bir($scope, $resource, $uibModal, $window, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var params = [
				  'area',
				  'salesman',
				  'reference',
				  'customer_name',
				  'document_date_from',
				  'document_date_to'
		];

		// main controller
		reportController($scope,$resource,$uibModal,$window,'bir',params,$log);
	}


	/**
	 * Date Input Controller
	 */
	app.controller('Calendar',['$scope','$http','$log','$route','$templateCache', Calendar]);

	function Calendar($scope, $http, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		$scope.dateFrom = null;
		$scope.dateTo = null;
		$scope.setFrom = function(from){
			if(from)
				$scope.dateFrom = new Date(from);
		}

		$scope.setTo = function(to){
			if(to)
				$scope.dateTo = new Date(to);
		}

		$scope.maxDate = new Date(2020, 5, 22);

		$scope.open = function($event, elementId) {
			$event.preventDefault();
			$event.stopPropagation();

			$("ul[class*='ng-valid-date']").hide();
			$("input[class*='ng-valid-date']").each(function() {
				var elemScope = angular.element(this).scope();
				var elemId = $(this).attr("id");
				elemScope[elemId] = false;
			});
			$scope[elementId] = true;
		};

		$scope.dateOptions = {
			formatYear: 'yy',
			startingDay: 0
		};

		$scope.format = 'MM/dd/yyyy';		  
	}
	
	/**
	 * Date Input Controller
	 */
	app.controller('CalendarMonth',['$scope','$http','$log','$route','$templateCache', CalendarMonth]);

	function CalendarMonth($scope, $http, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		$scope.dateFrom = null;
		$scope.dateTo = null;
		$scope.setFrom = function(from){
			if(from)
				$scope.dateFrom = new Date(from);
		}

		$scope.setTo = function(to){
			if(to)
				$scope.dateTo = new Date(to);
		}

		$scope.maxDate = new Date(2020, 5, 22);

		$scope.open = function($event, elementId) {
			$event.preventDefault();
			$event.stopPropagation();

			$("ul[class*='ng-valid-date']").hide();
			$("input[id*='ng-valid-date']").each(function() {
				var elemScope = angular.element(this).scope();
				var elemId = $(this).attr("id");
				elemScope[elemId] = false;
			});
			$scope[elementId] = true;
		};

		$scope.dateOptions = {
			formatYear: 'yy',
			startingDay: 0
		};

		$scope.format = 'MMM/yyyy';			  
	}
	
	/**
	 * Date Input Controller
	 */
	app.controller('CalendarYear',['$scope','$http','$log','$route','$templateCache', CalendarYear]);

	function CalendarYear($scope, $http, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		$scope.dateFrom = null;
		$scope.dateTo = null;
		$scope.setFrom = function(from){
			if(from)
				$scope.dateFrom = new Date(from);
		}

		$scope.setTo = function(to){
			if(to)
				$scope.dateTo = new Date(to);
		}

		$scope.maxDate = new Date(2020, 5, 22);

		$scope.open = function($event, elementId) {
			$event.preventDefault();
			$event.stopPropagation();

			$("ul[class*='ng-valid-date']").hide();
			$("input[id*='ng-valid-date']").each(function() {
				var elemScope = angular.element(this).scope();
				var elemId = $(this).attr("id");
				elemScope[elemId] = false;
			});
			$scope[elementId] = true;
		};

		$scope.dateOptions = {
			formatYear: 'yy',
			startingDay: 0
		};

		$scope.format = 'yyyy';			  
	}

	/**
	 * Date Input Controller for editable columns
	 */
	app.controller('EditableColumnsCalendar',['$scope','$http','$log','$route','$templateCache', EditableColumnsCalendar]);

	function EditableColumnsCalendar($scope, $http, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		if(defaultDate)
			$scope.dateFrom = defaultDate;
		else
			$scope.dateFrom = null;
		$scope.dateTo = null;

		$scope.maxDate = new Date(2020, 5, 22);

		$scope.open = function($event, elementId) {
			$event.preventDefault();
			$event.stopPropagation();
			$scope[elementId] = true;
		};

		$scope.dateOptions = {
			formatYear: 'yy',
			startingDay: 0
		};

		//$scope.format = 'yyyy/MM/dd';
		$scope.format = 'MM/dd/yyyy';

	}

	/**
	 * Get more data
	 */
	function fetchMore(scope, API, filter, log, loadMore, InventoryFixTable)
	{
		var params = {};
		$.each(filter, function(key,val){
			params[val] = $('#'+val).val();
		});
		params['transaction_date'] = scope.dateValue;

		$('p[id$="_error"]').addClass('hide');
		scope.toggleFilter = true;
		//toggleLoading(true);
		//log.info(params);
		//log.info(scope.dateValue);

		API.save(params,function(data){

				if(data.total)
				{
					var item = {
						records: data.records,
						total: data.total,
						stocks: data.stocks,
						show_stocks: data.total_stocks,
						replenishment: data.replenishment,
						showBody: data.total,
						showReplenishment: !data.first_upload && data.replenishment.total,
						short_over_stocks: data.short_over_stocks,
						stock_on_hand: data.stock_on_hand,
						first_upload: data.first_upload
					};

					var replenishment_length = Object.keys(item.replenishment).length;
					if(item.first_upload && replenishment_length > 0)
					{
						angular.forEach(item.replenishment, function(value, key){
							if(key.includes('code_') && value != 0 && checkItemCodeExist(key) == -1){
								scope.item_codes.push(key);
							}
						});
					} 

					var stocks_length = item.stocks.length;
					if(item.show_stocks > 0 && stocks_length > 0)
					{
						angular.forEach(item.stocks, function(stock, stock_key){
							angular.forEach(item.stocks[stock_key], function(value, value_key){
								if(value_key.includes('code_') && checkItemCodeExist(value_key) == -1){
									scope.item_codes.push(value_key);
								}
							});
						});
					}

					var records_length = item.records.length;
					if(item.total > 0 && records_length > 0)
					{
						angular.forEach(item.records, function(record, record_key){
							angular.forEach(item.records[record_key], function(value, value_key){
								if(value_key.includes('code_') && checkItemCodeExist(value_key) == -1){
									scope.item_codes.push(value_key);
								}
							});
						});
					}

					var stock_on_hand_length = Object.keys(item.stock_on_hand).length;
					if(item.showBody > 0 && stock_on_hand_length > 0)
					{
						angular.forEach(item.stock_on_hand, function(value, key){
							if(key.includes('code_') && value != 0 && checkItemCodeExist(key) == -1){
								scope.item_codes.push(key);
							}
						});
					}

					if(item.showReplenishment)
					{
						if(replenishment_length > 0)
						{
							angular.forEach(item.replenishment, function(value, key){
								if(key.includes('code_') && value != 0 && checkItemCodeExist(key) == -1){
									scope.item_codes.push(key);
								}
							});
						}

						var short_over_stocks_length = Object.keys(item.short_over_stocks).length;
						if(short_over_stocks_length > 0)
						{
							angular.forEach(item.short_over_stocks, function(value, key){
								if(key.includes('code_') && value != 0 && checkItemCodeExist(key) == -1){
									scope.item_codes.push(key);
								}
							});
						}
					}

					scope.items.push(item);
					$('#no_records_div').hide();
					fetch = false;
				}
				else
				{
					if(!loadMore && !scope.items.length){
						$('#no_records_div').show();
					}

				}
				//toggleLoading();
				//log.info(scope.items);

				if (scope.items.length){
					$('#no_records_div').hide();
					$("table.table").floatThead({
						position: "absolute",
						autoReflow: true,
						zIndex: "2",
						scrollContainer: function($table){
							return $table.closest(".wrapper");
						}
					});
					//console.log('Build table');

					angular.element('.code-header').hide();
					angular.forEach(scope.item_codes, function(value, key){
						angular.element('.' + value).show();
					});
				} else {
					//toggleLoading();
					$('#no_records_div').show();
					$("table.table").floatThead('destroy');
					console.log('Destroy table');
				}
		});

		function checkItemCodeExist(code){
			return scope.item_codes.indexOf(code);
		}
	}

	/**
	 * Centralized filter function
	 */
	function filterSubmitVanInventory(scope, API, filter, log, InventoryFixTable)
	{
		scope.filter = function(){

			var hasError = false;
			$.each(filter, function(key,val){
				if(val.indexOf('_from') != -1)
				{
					var from = $('#'+val).val();
					var to = $('#'+val.replace('_from','_to')).val();

					if(!from && !to)
					{
						hasError = true;
						$('#'+val.replace('_from','_error')).html('This field is required.');
						$('#'+val.replace('_from','_error')).removeClass('hide');

					}
					else if((from && !to) || (!from && to) || (new Date(from) > (new Date(to))))
					{
						hasError = true;
						$('#'+val.replace('_from','_error')).html('Invalid date range.');
						$('#'+val.replace('_from','_error')).removeClass('hide');
					}
				}
			});

			if(!hasError)
			{
				if(typeof InventoryFixTable !== "undefined"){
					InventoryFixTable.ift();
				}

				var dateFrom = new Date($('#transaction_date_from').val());
				var dateTo = new Date($('#transaction_date_to').val());

				scope.items = [];
				scope.dateRanges = getDates(dateFrom,dateTo);
				var maxIndex = scope.dateRanges.length - 1;

				$.each(scope.dateRanges, function(i, range){
					toggleLoading(true);
					setTimeout(function(){

						if(i == maxIndex)
						{
							toggleLoading();
						}
						scope.dateValue = range;
						scope.dateRanges.shift();

						fetchMore(scope, API, filter, log, InventoryFixTable);

					}, i * 2000);
				});
			}
		}

		scope.more = function() {

			while(scope.dateRanges.length)
			{
				if(scope.dateRanges.length > 0)
				{
					scope.dateValue = scope.dateRanges.shift();
					if(!scope.dateRanges.length)
					$('#load_more').addClass('hide');
					//log.info(scope.dateRanges);
					//log.info(scope.dateValue);

					fetchMore(scope, API, filter, log, true, InventoryFixTable);
				}
				else
				{
					$('#load_more').addClass('hide');
				}
			}

		};

		scope.reset = function(){
			$.each(filter, function(key,val){
				if(val.endsWith('_from'))
				{

					angular.element($('#'+val)).scope().setFrom(new Date());
				}
				else if(val.endsWith('_to'))
				{
					angular.element($('#'+val)).scope().setTo(new Date());
				}
			});
			$('p[id$="_error"]').addClass('hide');
			// scope.toggleFilter = true;
			toggleLoading();
			scope.items = []
			$('#no_records_div').removeClass('hide');
			$('#load_more').addClass('hide');

			if(typeof InventoryFixTable !== "undefined"){
				InventoryFixTable.ift();
			}

		}
	}

	/**
	 * Centralized filter function
	 */
	function filterSubmit(scope, API, filter, log, report, TableFix)
	{
		var params = {};
		
		scope.filter = function(){
				
			var exclude = ['salescollectionsummary','stockaudit','actualcount','adjustment','bouncecheck'];
			var formatReport = ['salescollectionsummary','stockaudit'];
			var formatField = ['invoice_date_from','month_from','year_from'];
			scope.page = 1;

			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;

			var hasError = false;
			$.each(filter, function(key,val){
				params[val] = $('#'+val).val();

				if(val.indexOf('_from') != -1)
				{
					//console.log(-1 == $.inArray(report,exclude));
					var from = $('#'+val).val();
					var to = $('#'+val.replace('_from','_to')).val();

					if(((from && !to) || (!from && to) || (new Date(from) > (new Date(to)))) 
						&& -1 == $.inArray(report,exclude))
					{
						hasError = true;
						$('#'+val.replace('_from','_error')).html('Invalid date range.');
						$('#'+val.replace('_from','_error')).removeClass('hide');
					}
				}

				if(report == 'salescollectionreport' && val.indexOf('posting_date') != -1)
				{
					var invoiceFrom = new Date($('#invoice_date_from').val());
					var invoiceTo = new Date($('#invoice_date_to').val());
					var prevFrom = new Date(from);
					var prevTo = new Date(to);

					if(prevFrom >= invoiceFrom || prevFrom >= invoiceTo || prevTo >= invoiceFrom || prevTo >= invoiceTo )
					{
						hasError = true;
						$('#'+val.replace('_from','_error')).html('Date range must be less than Invoice Date.');
						$('#'+val.replace('_from','_error')).removeClass('hide');
					}
				}
				else if(report == 'actualcount' && !$.trim(params[val]))
				{
					if(val.indexOf('_from') != -1){
						$('#'+val).parent().next('span').html('This field is required.');
					} else {
						$('#'+val).next('span').html('This field is required.');
					}					
					hasError = true;
				} else {
					if(val.indexOf('_from') != -1){
						$('#'+val).parent().next('span').html('');
					} else {
						//$('#'+val).next('span').html('');
					}
				}
				
				
				if(-1 !== $.inArray(report,formatReport) && -1 !== $.inArray(val,formatField)){
					var date = new Date($('#'+val).val());
					if(date && $('#'+val).val().trim()){
						params[val] = (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
					} else {
						params[val] = '';
					}
				}

			});
			//log.info(params);


			if(!hasError)
			{
				$('p[id$="_error"]').addClass('hide');
				scope.toggleFilter = true;
				toggleLoading(true);
				API.save(params,function(data){
					//log.info(data);
					scope.records = data.records;
					scope.total = data.total;
					scope.summary = data.summary;
					toggleLoading();
					if(typeof value !== "undefined"){
						TableFix.tableload();
					}
					togglePagination(data.total);
					
					if(-1 !== $.inArray(report,exclude) && data.reference_num){
						scope.editHide = '';
						scope.editUrl = scope.url + data.reference_num;
					}
				});
			}

		}

		scope.reset = function(){

			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;

			$.each(filter, function(key,val){
				if(val.endsWith('_from'))
				{
					angular.element($('#'+val)).scope().setFrom(new Date());
				}
				else if(val.endsWith('_to'))
				{
					angular.element($('#'+val)).scope().setTo(new Date());
				}
				params[val] = '';
				
				if(val.indexOf('_from') != -1){
					$('#'+val).parent().next('span').html('');
				} else {
					$('#'+val).next('span').html('');
				}
			});
			//log.info(filter);
			$('p[id$="_error"]').addClass('hide');

			if(report == 'salescollectionreport')
			{
				params = {salesman:$('#salesman').val(),company_code:$('#company_code').val()};
			}
			else if(report == 'salescollectionposting')
			{
				params = {salesman:$('#salesman').val(),company_code:$('#company_code').val()};
			}
			else if(report == 'salescollectionsummary')
			{
				params = {salesman:$('#salesman').val()};
			}

			// scope.toggleFilter = true;
			toggleLoading(true);
			API.save(params,function(data){
				//log.info(data);
				scope.total = data.total;
				scope.records = data.records;
				scope.summary = data.summary;
				togglePagination(data.total);
				toggleLoading();
			});

		}
	}

	/**
	 * Centralized method for sorting
	 */
	function sortColumn(scope, API, filter, log, TableFix)
	{
		var params = {};

		scope.sort = function(col) {
			scope.sortColumn = col;
			var el = $('th[id="'+col+'"]');

			el.parent().find('th').removeClass('sorted');
			el.parent().find('th>i').removeClass('fa-sort-asc');
			el.parent().find('th>i').removeClass('fa-sort-desc');
			el.parent().find('th>i').addClass('fa-sort');

			if(scope.sortDirection == 'desc')
			{
				el.addClass('sorted');
				el.find('i').addClass('fa-sort-asc');
				scope.sortDirection = 'asc';
			}
			else
			{
				el.addClass('sorted');
				el.find('i').addClass('fa-sort-desc');
				scope.sortDirection = 'desc';
			}

			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;

			$.each(filter, function(key,val){
				params[val] = $('#'+val).val();
			});
			//log.info(params);

			scope.toggleFilter = true;
			toggleLoading(true);
			API.save(params, function(data){
				//log.info(data);
				scope.records = data.records;
				scope.toggleFilter = true;
				toggleLoading();

				var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 20;

				$("table.table").floatThead({
					position: "absolute",
					autoReflow: true,
					zIndex: "2",
					scrollContainer: function($table){
						return $table.closest(".wrapper");
					}
				});

				console.log('Refresh table. Scroll value: '+scrollpos);
				$(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
			});
		}
	}

	/**
	 * Centralized pagination function
	 */
	function pagination(scope, API, filter, log, vaninventory, TableFix)
	{
		var params  = {};

		scope.page = 1;
		if(scope.perpage == 25 || !scope.perpage)
			scope.perpage = 25;
		scope.total = 0;

		// Paginate table records
		scope.paginate = function(page) {
			scope.perpage = page;
			scope.page = 1;
			$('#limit'+page).parent().parent().find('.active').removeClass('active');
			$('#limit'+page).parent().addClass('active');

			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;

			$.each(filter, function(key,val){
				params[val] = $('#'+val).val();
			});
			//log.info(params);

			toggleLoading(true);
			API.save(params, function(data){
				//log.info(data);
				scope.records = data.records;
				scope.toggleFilter = true;
				toggleLoading();

				var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 20;

				if(typeof TableFix !== "undefined"){
					TableFix.tableload();
				}
				console.log('Paginate Factory. Scroll value: '+scrollpos);

				$(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
			});
		}

		// Pager table records
		scope.pager = function(increment,first,last) {
			var request = false;
			if(first)
			{
				scope.page = 1;
				request = true;
			}
			else if(last)
			{
				if(0 == scope.total%scope.perpage)
					scope.page = scope.total/scope.perpage;
				else
					scope.page = Math.ceil(scope.total/scope.perpage);
				request = true;
			}
			else if((scope.page + increment > 0 && scope.page!=(scope.total/scope.perpage))
					|| (increment < 0 && scope.page > 1))
			{
				var maxPage = 0;
				if(0 == scope.total%scope.perpage)
					maxPage = Math.round(scope.total/scope.perpage);
				else
					maxPage = Math.ceil(scope.total/scope.perpage);
				var nextPage = scope.page + increment;

				if(maxPage >= nextPage)
				{
					scope.page = nextPage;
					request = true;
				}
			}

			if(request)
			{
				params['page'] = scope.page;
				params['page_limit'] = scope.perpage;
				params['sort'] = scope.sortColumn;
				params['order'] = scope.sortDirection;

				$.each(filter, function(key,val){
					params[val] = $('#'+val).val();
				});
				//log.info(params);

				toggleLoading(true);
				API.save(params, function(data){
					//log.info(data);
					scope.records = data.records;
					scope.toggleFilter = true;
					toggleLoading();
					var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 20;

					if(typeof TableFix !== "undefined"){
						TableFix.tableload();
					}
					console.log('Pager Factory. Scroll value: '+scrollpos);

					$(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
					});
			}
		}
	}


	/**
	 * Edit table records
	 */
	function editTable(scope, modal, resource, window, options, log, TableFix)
	{
		scope.editColumn = function(type, table, column, id, value, index, name, alias, getTotal, parentIndex, step, toUpdate, slug){
			resource('/reports/synching/'+id+'/'+column + '?slug=' + slug).get().$promise.then(function(data){
				var selectOptions = options;
				var url = window.location.href;
				url = url.split("/");
				var reportType = "";
				var report = "";
				var updated = false;
				
				var commentLists = [];
				if (typeof data.sync_data.com[0] !== "undefined") {
					angular.forEach(data.sync_data.com, function (comment) {
						commentLists.push(comment);
					});
				}

				switch (url[4]) {
					case "salescollection.report":
						reportType = "Sales & Collection - Report";
						report = 'salescollectionreport';
						break;
					case "vaninventory.canned":
						reportType = "Van Inventory - Canned & Mixes";
						report = 'vaninventorycanned';
						break;
					case "vaninventory.frozen":
						reportType = "Van Inventory - Frozen & Kassel";
						report = 'vaninventoryfrozen';
						break;
					case "salesreport.permaterial":
						reportType = "Sales Report - Per Material";
						report = 'salesreportpermaterial';
						break;
					case "salesreport.pesovalue":
						reportType = "Sales Report - Peso Value";
						report = 'salesreportperpeso';
						break;
					case "vaninventory.stocktransfer":
						reportType = "Van Inventory - Stock Transfer";
						report = 'stocktransfer';
						break;			
					case 'cashpayments':
						reportType = "Cash Payments";
						report = 'cashpayments';
						break;
				}

				var stepInterval = 1;
				if(step)
					stepInterval = step;
				var total = column;
				if(alias)
					total = alias;
				
				scope.oldVal = '';
				if(getTotal)
					scope.oldVal = value;
							
				var template = '';
				var inputType = '';
				if(data.sync_data.sync == 1)
				{
					template = 'Synchronizing';
				}
				else
				{
					switch(type)
					{
						case 'date':
							template = 'EditColumnDate';
							inputType = 'datetime';
							defaultDate = new Date(value);
							localStorage.setItem("getDateold",defaultDate);
							break;
						case 'select':
							template = 'EditColumnSelect';
							break;
						case 'number':	
							template = 'EditColumnText';
							inputType = 'number';
							value = Number(value);
							break;
						default:	
							template = 'EditColumnText';
							inputType = 'text';
							break;	
					}
				}
				var params = {
						table: table,
						column: column,
						id: id,
						value: value,
						oldval: value,
						commentLists: commentLists,
						selectOptions: selectOptions,
						index: index,
						name: name,
						alias: alias,
						total: total,
						old: scope.oldVal,
						getTotal: getTotal,
						parentIndex: parentIndex,
						type: inputType,
						step: stepInterval,
						updated: updated,
						report: report,
						report_type: reportType,
						toUpdate: toUpdate,
						slug: slug
				};
				
				
				var modalInstance = modal.open({
					animation: true,
					scope: scope,
					templateUrl: template,
					controller: 'EditTableRecord',
					windowClass: 'center-modal',
					size: 'lg',
					resolve: {
						params: function () {
							return params;
						}
					}
				});
					
			});

		}

	}
	
	/**
	 * Export report
	 */
	function downloadReport(scope, modal, resource, window, report, filter, log)
	{
		scope.download = function(type){

			var url = '/reports/getcount/'+report+'/'+type;
			var delimeter = '?';
			var query = '';

			if('vaninventorycanned' == report || 'vaninventoryfrozen' == report)
			{
				if(!$('#transaction_date_from').val() || !$('#transaction_date_to').val())
				{
					alert('Transaction Date field is required.');
					return false;
				}
			}

			$.each(filter, function(index,val){
				if(index > 0)
					delimeter = '&';
				query += delimeter + val + '=' + $('#'+val).val();
			});
			url += query;
			//log.info(url);

			var API = resource(url);
			API.get({}, function(data){

				//log.info(data);
				if(!data.total)
				{
					var params = {message:'No data to export.'};
					var modalInstance = modal.open({
						animation: true,
						templateUrl: 'Info',
						controller: 'Info',
						windowClass: 'center-modal',
						size: 'sm',
						resolve: {
							params: function () {
								return params;
							}
						}
					});
				}
				else if(data.max_limit)
				{
					scope.params = {
							chunks: data.staggered,
							title: 'Export ' + angular.uppercase(type),
							limit: data.limit,
							exportType: type,
							report: report,
							filter: filter,
							sort: scope.sortColumn,
							order: scope.sortDirection,
					};

					var modalInstance = modal.open({
							animation: true,
							templateUrl: 'exportModal',
							controller: 'ExportReport',
							resolve: {
								params: function () {
									return scope.params;
								}
							}
					});
				 }
				 else
				 {
					 var exportUrl = '/reports/export/'+type+'/'+report+query;
					 if(scope.sortColumn)
						 exportUrl += '&'+'sort='+scope.sortColumn;
					 if(scope.sortDirection)
						 exportUrl += '&'+'order='+scope.sortDirection;
					 window.location.href = exportUrl;
				}
			});
		}
	}

	/**
	 * Centralized controller codes
	 */
	function reportController(scope, resource, modal, window, report, filter, log, TableFix)
	{
		// Filter flag
		scope.toggleFilter = true;

		// Fetch table headers from server
		/*scope.tableHeaders = {};
		resource('/reports/getheaders/'+report).query({}, function(data){
			scope.tableHeaders = data;
		});*/

		// Fetch table data from server
		scope.records = [];

		var API = resource('/reports/getdata/'+report);
		var params = {};

		if(report == 'salescollectionreport' || report == 'salescollectionposting' || report == 'cashpayment' || report == 'checkpayment')
		{
			params = {salesman:$('#salesman').val(),company_code:$('#company_code').val()};
		}else if(report == 'salescollectionsummary')
		{
			params = {salesman:$('#salesman').val(),company_code:$('#company_code').val()};
		}else if(report == 'replenishment') {
			params = {type:$('#type').val()};
		}

		toggleLoading(true);
		API.get(params,function(data){
			scope.records = data.records;
			scope.summary = data.summary;
			scope.total = data.total;
			//log.info(data);
			toggleLoading();

			if(typeof TableFix !== "undefined"){
				TableFix.tableload();
			}

			togglePagination(data.total);
		});

		params = filter;

		//Sort table records
		scope.sortColumn = '';
		scope.sortDirection = 'asc';
		sortColumn(scope,API,params,log, TableFix);

		// Filter table records
		filterSubmit(scope,API,params,log, report, TableFix);

		// Paginate table records
		pagination(scope,API,params,log, TableFix);

		// Download report
		downloadReport(scope, modal, resource, window, report, filter, log);

		// Format date
		formatDate(scope);

		//Format number
		formatNumber(scope,log);
	}

	/**
	 * Toggle pagination div
	 */
	function togglePagination(show)
	{
		if(show)
		{
			$('#pagination_div').removeClass('hidden');
			$('#pagination_div').addClass('show');
			$('#no_records_div').hide();
			$('#total_summary').show();

			var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 10;
			$("table.table").floatThead({
				position: "absolute",
				autoReflow: true,
				zIndex: "2",
				scrollContainer: function($table){
					return $table.closest(".wrapper");
				}
			});
			//console.log('Build table');
			$(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
		}
		else
		{
			$('#pagination_div').removeClass('show');
			$('#pagination_div').addClass('hidden');
			$('#no_records_div').show();
			$('#total_summary').hide();

			var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 10;
			$("table.table").floatThead('destroy');
			//console.log('Destroy table');
			$(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
		}
	}

	/**
	 * Toggle loading div
	 */
	function toggleLoading(show)
	{
		if(show)
		{
			$('#loading_div').removeClass('hidden');
			$('#loading_div').addClass('show');
		}
		else
		{
			$('#loading_div').removeClass('show');
			$('#loading_div').addClass('hidden');
		}
	}


	/**
	 * Export report controller
	 */
	app.controller('ExportReport',['$scope','$uibModalInstance','$window','params','$log','$route','$templateCache', ExportReport]);

	function ExportReport($scope, $uibModalInstance, $window, params, $log,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.params = params;
		$scope.offset = 0;

		$scope.selectItem = function(range){
			$scope.offset = range;
		}

		$scope.download = function () {
			$uibModalInstance.close(true);

			var url = '/reports/export/'+$scope.params.exportType+'/'+$scope.params.report+'/'+$scope.offset;
			var delimeter = '?';
			$.each(params.filter, function(index,val){
				if(index > 0)
					delimeter = '&';
				url += delimeter + val + '=' + $('#'+val).val();
			});

			url += '&sort='+params.sort+'&order='+params.order;
			//$log.info(url);
			$window.location.href = url;
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	};


	/**
	 * Edit Table record controller
	 */
	app.controller('EditTableRecord', ['$scope', '$uibModalInstance', '$resource', 'params', '$log', 'EditableFixTable','$route','$templateCache', EditTableRecord]);

	function EditTableRecord($scope, $uibModalInstance, $resource, params, $log, EditableFixTable,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.change = function () {

			$('#regExpr').on('click keyup', function () {
				if (($('#regExpr').val() != $('#hval').val()) && ($.trim($('#regExpr').val()))) {
					$('#btnsub').attr('disabled', false);
				} else {
					$('#btnsub').attr('disabled', 'disabled');
				}
				return;
			});
			if (typeof $('#newSelected').val() !== "undefined" && ($('#oldSelected').val() != $('#newSelected').val())) {
				$('#btnsub').attr('disabled', false);
			}
			else if (typeof $('#date_value').val() !== "undefined") {
				var date = new Date($('#date_value').val());
				var oldDate = new Date($scope.params.oldval);
				date = date.getDate() + date.getMonth() + date.getFullYear();
				oldDate = oldDate.getDate() + oldDate.getMonth() + oldDate.getFullYear();
				if (date !== oldDate) {
					$('#btnsub').attr('disabled', false);
				} else {
					$('#btnsub').attr('disabled', 'disabled');
				}
			} else {
				$('#btnsub').attr('disabled', 'disabled');
			}
		};

		$scope.params = params;

		$scope.save = function () {
			var API = $resource('controller/reports/save');
			var error = false;
			if ($scope.params.type == 'datetime') {
				if (!$('#date_value').val()) {
					error = true;
				}
				else if ($('#comment').val() == '') {
					document.getElementById("editError").style.display = "block";
					error = true;
				}
				else {
					var val = $scope.params.value;
					$scope.params.value = $('#date_value').val() + " " + val.split(" ")[1];
				}
			} else if ($scope.params.type == 'number' && ($scope.params.value < 0 || $scope.params.value == undefined || ($scope.params.value % 1 != 0))) {
				error = true;
			} else if (typeof $('#regExpr').val() != "undefined" && $scope.params.column == "invoice_number" && $.isNumeric($('#regExpr').val().substring(0, 2))) {
				document.getElementById("editErrorInvoice").style.display = "block";
				error = true;
			} else if ($('#comment').val() == '') {
				console.log($('#comment').val());
				document.getElementById("editError").style.display = "block";
				error = true;
			}
			if (!error) {
				API.save($scope.params, function (data) {

					// Van Inventory customization
					if ($scope.params.table == 'txn_stock_transfer_in_header' && $scope.params.report != 'stocktransfer') {
						var stocks = 'stocks';
						if ($scope.params.alias) {
							$scope.items[$scope.params.parentIndex][stocks][$scope.params.index][$scope.params.alias] = $scope.params.value;
						} else {
							$scope.items[$scope.params.parentIndex][stocks][$scope.params.index][$scope.params.column] = $scope.params.value;
						}
						$('#' + $scope.params.parentIndex + '_' + $scope.params.index + '-' + $scope.params.toUpdate).addClass('modified');
					}
					else {
						if ($scope.params.alias) {
							$scope.records[$scope.params.index][$scope.params.alias] = $scope.params.value;
							if ($scope.params.getTotal)
								$scope.summary[$scope.params.alias] = Number($scope.summary[$scope.params.alias]) - Number($scope.params.old) + Number($scope.params.value);
						} else {
							$scope.records[$scope.params.index][$scope.params.column] = $scope.params.value;
							if ($scope.params.getTotal)
								$scope.summary[$scope.params.column] = Number($scope.summary[$scope.params.column]) - Number($scope.params.old) + Number($scope.params.value);
						}
						$('#' + $scope.params.index + '-' + $scope.params.toUpdate).addClass('modified');

						if (typeof EditableFixTable !== 'undefined') {
							EditableFixTable.eft();
						}
					}
				});

				$('table.table').floatThead('destroy');

				$uibModalInstance.dismiss('cancel');
			}
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};

	};


	/**
	 * Get date ranges base from parameters
	 */
	function getDates(startDate, stopDate) {
		var dateArray = new Array();
		var currentDate = startDate;
		while (currentDate <= stopDate) {
			var formatted = currentDate.getFullYear() + '/' + (currentDate.getMonth() + 1) + '/' + currentDate.getDate();
			dateArray.push( formatted )
			currentDate = currentDate.addDays(1);
		}
		return dateArray;
	}

	/**
	 * Add days
	 */
	Date.prototype.addDays = function(days) {
		var dat = new Date(this.valueOf())
		dat.setDate(dat.getDate() + days);
		return dat;
	}



	/**
	 * User List controller
	 */
	app.controller('UserList',['$scope','$resource','$window','$uibModal','$log','$route','$templateCache', UserList]);

	function UserList($scope, $resource, $window, $uibModal, $log,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		// Filter flag
		$scope.toggleFilter = true;

		// Fetch table data from server
		$scope.records = [];

		var API = $resource('/reports/getdata/userlist');
		var params = {};

		toggleLoading(true);
		API.get(params,function(data){
			$scope.records = data.records;
			$scope.total = data.total;
			//$log.info(data);
			toggleLoading();
			togglePagination(data.total);
		});

		params = {
			fullname: 'fullname',
			user_group_id: 'user_group_id',
			location_assignment_code: 'location_assignment_code',
			location_assignment_type: 'location_assignment_type',
			created_at_from: 'created_at_from',
			created_at_to: 'created_at_to'
		};

		//Sort table records
		$scope.sortColumn = '';
		$scope.sortDirection = 'asc';
		sortColumn($scope,API,params,$log);

		// Filter table records
		filterSubmit($scope,API,params,$log);

		// Paginate table records
		pagination($scope,API,params,$log);

		var params;
		$scope.activate = function(id,row){
			params = {id:id,action:'activate',message:'Are you sure you want to activate this user?',row:row};
			var modalInstance = $uibModal.open({
				scope: $scope,
				animation: true,
				templateUrl: 'Confirm',
				controller: 'UserAction',
				windowClass: 'center-modal',
				size: 'sm',
				resolve: {
					params: function () {
						return params;
					}
				}
			});
		}

		$scope.deactivate = function(id,row){
			params = {id:id,action:'deactivate',message:'Are you sure you want to deactivate this user?',row:row};
			var modalInstance = $uibModal.open({
				scope: $scope,
				animation: true,
				templateUrl: 'Confirm',
				controller: 'UserAction',
				windowClass: 'center-modal',
				size: 'sm',
				resolve: {
					params: function () {
						return params;
					}
				}
			});
		}

		$scope.remove = function(id){
			params = {id:id,action:'delete',message:'Are you sure you want to delete this user?'};
			var modalInstance = $uibModal.open({
				animation: true,
				scope: $scope,
				templateUrl: 'Confirm',
				controller: 'UserAction',
				windowClass: 'center-modal',
				size: 'sm',
				resolve: {
					params: function () {
						return params;
					}
				}
			});
		}

		//this should be a filter
		$scope.parseDate = function(date) {
			 date = date.replace(/-/g, '/');
			return new Date(date);
		}
	};

	/**
	 * User List controller
	 */
	app.controller('UserGroupList',['$scope','$resource','$window','$uibModal','$log','$route','$templateCache', UserGroupList]);

	function UserGroupList($scope, $resource, $window, $uibModal, $log,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		// Filter flag
		$scope.toggleFilter = true;

		// Fetch table data from server
		$scope.records = [];

		var API = $resource('/reports/getdata/usergrouplist');
		var params = {};

		toggleLoading(true);
		API.get(params,function(data){
			$scope.records = data.records;
			$scope.total = data.total;
			//$log.info(data);
			toggleLoading();
			togglePagination(data.total);
		});

		params = {
			id: 'id',
			name: 'name',
		};

		//Sort table records
		$scope.sortColumn = '';
		$scope.sortDirection = 'asc';
		sortColumn($scope,API,params,$log);

		// Filter table records
		filterSubmit($scope,API,params,$log);

		// Paginate table records
		pagination($scope,API,params,$log);

	};

	/**
	 * Format date
	 */
	function formatDate(scope) {

		// @Function
		// Description  : Triggered while displaying expiry date in Customer Details screen.
		scope.formatDate = function(date){
			  if(!date) return '';
			  date = date.replace(/-/g, '/');
			  var dateOut = new Date(date);
			  return dateOut;
		};
	}

	/**
	 * Format money
	 */
	function formatNumber(scope, log) {

		scope.negate = function(number){
			if(!number) return number;

			if(number < 0)
				number = '(' + Math.abs(number) + ')';
			return number.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		};

		scope.formatNumber = function(number, negate, round){

			  if(number == '')
				  return '';

			  if('string' == typeof number)
			  {
				  number = Number(number);
				  if(round)
				  {
					  number = Math.round(number);
					  if(negate || number < 0) number = '('+Math.abs(number)+')';
					  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				  }
				  number = number.toFixed(2);
			  }

			  if('number' == typeof number)
			  {
				  if(round)
				  {
					  number = Math.round(number);
					  if(negate || number < 0) number = '('+Math.abs(number)+')';
					  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				  }
				  number = number.toString();
			  }


			  if(!number || number == undefined || number == '0') return '';

			  var chunks = [];
			  var realNumber;

			  if(number.indexOf('.') != -1)
			  {
				  chunks = number.split('.');
				  realNumber = chunks[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' + chunks[1];
			  }
			  else
			  {
				  realNumber = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			  }
			  if(negate === '1' || negate === true || negate === 1 || realNumber < 0)
				  realNumber = '(' + Math.abs(realNumber) + ')';
			  return realNumber;
		};
	}


	/**
	 * User List controller
	 */
	app.controller('UserAdd',['$scope','$resource','$location','$window','$uibModal','$log','$route','$templateCache', UserAdd]);

	function UserAdd($scope, $resource, $location, $window, $uibModal, $log,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.id = 0;
		$scope.role_id = 1;
		$scope.records = {user_group_id:1};

		//$scope.open = function () {
		//	var params = {action:'validate',message:'this is a test?'};
		//	var modalInstance = $uibModal.open({
		//		scope: $scope,
		//		animation: true,
		//		templateUrl: 'Confirm',
		//		controller: 'UserAction',
		//		windowClass: 'center-modal',
		//		size: 'sm',
		//		resolve: {
		//			params: function () {
		//				return params;
		//			}
		//		}
		//	});
		//};

		// Save user profile
		saveUser($scope,$resource,$location, $uibModal, $window, $log);
	};



	/**
	 * User List controller
	 */
	app.controller('UserEdit',['$scope','$resource','$routeParams','$location', '$uibModal','$window','$log','$route','$templateCache', UserEdit]);

	function UserEdit($scope, $resource, $routeParams, $location ,$uibModal,$window, $log,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.regExemail = function(){
			var email = $('#email').val();
			if(email){
				var str=document.getElementById("email");
				var regex=/[^a-zA-Z0-9._@-]/gi;
				str.value=str.value.replace(regex ,"");
			}
		}
		$scope.age = '';
		$scope.from = null;
		$scope.to = null;
		$scope.id = 0;

		var API = $resource('/user/edit/'+$routeParams.id);
		var params = {};

		API.get(params,function(data){

			//angular acts weird with integer option values
			data.user_group_id = String(data.user_group_id);

			$scope.records = data;
			//$log.info(data);
			$scope.id = data.id;
			$scope.age = Number(data.age);
			$scope.isJr = $scope.records.jr_salesman_code != ''	 ? true : false;


			if(data.location_assignment_from){
				$scope.from = new Date(data.location_assignment_from);
			}
			if(data.location_assignment_to){
				$scope.to = new Date(data.location_assignment_to);
			}


		});

		// Save user profile
		saveUser($scope,$resource,$location,$uibModal,$window, $log);

		$scope.req_salesman = 'hidden';
		$scope.checkRole = function(){
			if($scope.records.user_group_id == 4)
				$scope.req_salesman = '';
			else
				$scope.req_salesman = 'hidden';
		};
	};

	/**
	 * User Contact us controller
	 */
	app.controller('ContactUs', ['$scope', '$resource', '$http','$route','$templateCache', ContactUs]);

	function ContactUs($scope, $resource, $http,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.success = false;
		$scope.error = false;
		$scope.loading = false;
		$scope.contact = {
			name: '',
			mobile: '',
			telephone: '',
			email: '',
			branch: "300",
			callFrom: '',
			callTo: '',
			subject: '',
			message: ''
		};
		$('.timepicker').timepicker({
			timeFormat: 'h:mm p',
			interval: 30,
			minTime: '12:00am',
			maxTime: '11:30pm',
			defaultTime: '7',
			startTime: '07:00am',
			dynamic: false,
			dropdown: true,
			scrollbar: true
		});

		var apiMaxFileSize = $resource('/user/file-size');
		apiMaxFileSize.get({}, function (data) {
			$scope.maxFileSize = (data.value * 1000);
		}, function () {
			var contactErrorList = '<ul><li>Whoops, looks like something went wrong.</li></ul>';
			$('#error_list_contact').html(contactErrorList);
			$scope.error = true;
		});

		$scope.save = function () {
			$scope.contact.callFrom = $('#callFrom').val();
			$scope.contact.callTo = $('#callTo').val();
			$scope.contact.file = $scope.contactFile ? true : false;
			$scope.validate($scope.contact);
			if (!$scope.error) {
				$scope.loading = true;
				$scope.error = false;
				$scope.success = false;
				var API = $resource('controller/user/contact');
				API.save($scope.contact, function (data) {
					$scope.contactFile ? $scope.uploadFile(data) : $scope.toMail(data);
				}, function (data) {
					$scope.loading = false;
					var contactErrorList = '<ul><li>' + JSON.stringify(data.data).replace(/['"]+/g, '') + '</li></ul>';
					$('#error_list_contact').html(contactErrorList);
					$scope.error = true;
				});
			}
		};

		$scope.toMail = function (data) {
			var apiMail = $resource('/controller/user/contact/mail/' + data.id);
			apiMail.get({}, function (data) {
				$scope.success = true;
				$scope.loading = false;
			}, function (data) {
				$scope.loading = false;
				var contactErrorList = '<ul><li>' + JSON.stringify(data.data).replace(/['"]+/g, '') + '</li></ul>';
				$('#error_list_contact').html(contactErrorList);
				$scope.error = true;
			});
		};

		$scope.uploadFile = function (data) {
			$http.post('/controller/user/contact/file/' + data.id, $scope.contactFile, {
				withCredentials: true,
				headers: {'Content-Type': undefined},
				transformRequest: angular.identity
			}).success(function (data) {
				$scope.toMail(data);
			}, function (data) {
				$scope.loading = false;
				var contactErrorList = '<ul><li>Error in uploading file.</li></ul>';
				$('#error_list_contact').html(contactErrorList);
				$scope.error = true;
			});
		};

		$scope.readFile = function (files) {
			$scope.error = false;
			var fd = new FormData();
			//Take the first selected file
			fd.append("file", files[0]);
			var size = (files[0].size / 1000); //convert the bytes to kb by dividing the of bytes by 1000
			if (size > $scope.maxFileSize) { // 10000kb or 10mb
				$scope.error = true;
				var contactErrorList = '<ul><li>Max File size is 10mb.</li></ul>';
				$('#error_list_contact').html(contactErrorList);
				return false;
			}
			$scope.contactFile = fd;
		};

		$scope.resetFile = function () {
			$scope.contactFile = '';
			$('#contactFile').val('');
		};

		$scope.validate = function (contact) {
			var contactErrors = [];
			var contactErrorList = '';
			var rgxEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			$scope.error = false;

			angular.forEach(angular.element(".contact-file-form [data-required=true]"), function (item) {
				var field = $(item).attr("name");
				var value = $.trim($(item).val());
				if (value == "") {
					if (field == "mobile" || field == 'telephone') {
						contactErrors.push(field.charAt(0).toUpperCase() + field.substring(1) + " number is a required field.");
					} else {
						contactErrors.push(field.charAt(0).toUpperCase() + field.substring(1) + " is a required field.");
					}
				}
				if ((field == 'email' && value != "") && !rgxEmail.test(value)) {
					contactErrors.push('Email is not valid.');
				}
				$(item).val(value);
			});

			if (contactErrors.length > 0) {
				contactErrorList = '<ul>';
				for (var i = 0; i < contactErrors.length; i++) {
					contactErrorList += '<li>' + contactErrors[i] + '</li>';
				}
				contactErrorList += '</ul>';
				$('#error_list_contact').html(contactErrorList);
				$scope.error = true;
			}
		};
	}

	/**
	 * User Incident report controller
	 */
	app.controller('SummaryOfIncidentReport', ['$scope', '$resource', '$routeParams','$uibModal', '$window', '$location', '$log','$route','$templateCache', SummaryOfIncidentReport]);

	function SummaryOfIncidentReport($scope, $resource, $routeParams, $uibModal, $window, $location, $log,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		// Filter flag
		$scope.toggleFilter = true;
		$scope.propertyName = 'id';
		$scope.reverse = true;

		// Fetch table data from server
		$scope.records = [];
		$scope.error = false;

		$scope.API = $resource('/reports/getdata/summaryofincidentreport');

		toggleLoading(true);
		$scope.API.get({}, function (data) {
			$scope.records = data.records;
			$scope.total = data.total;

			// this function will convert id string to int.
			// for proper sorting of id.
			angular.forEach($scope.records, function (record) {
				record.id = parseInt(record.id);
			});

			toggleLoading();
			togglePagination(data.total);
		});

		$scope.filter = function () {
			$scope.error = false;
			var params = {
				name: $('#name').val(),
				branch: $('#branch').val(),
				subject: $('#subject').val(),
				action: $('#action').val(),
				status: $('#status').val(),
				incident_no: $('#incident_no').val(),
				date_range_from: $('#date_range_from').val(),
				date_range_to: $('#date_range_to').val()
			};
			$scope.validate();
			if (!$scope.error) {
				toggleLoading(true);
				$scope.API.save(params, function (data) {
					$scope.toggleFilter = true;
					$scope.records = data.records;
					angular.forEach($scope.records, function (record) {
						record.id = parseInt(record.id);
					});
					$scope.total = data.total;
					toggleLoading();
					togglePagination(data.total);
					$('#date_range_error').addClass('hide');
				})
			}
		};
		$scope.validate = function () {
			if ($('#date_range_from').val() > $('#date_range_to').val()) {
				$scope.error = true;
				$('#date_range_error').removeClass('hide');
			}
		};
		$scope.sort = function(propertyName) {
			if(propertyName == 'name'){
				propertyName = 'full_name';
			}
			$scope.reverse = ($scope.propertyName === propertyName) ? !$scope.reverse : false;
			$scope.propertyName = propertyName;
		};
		var params = [
			'name',
			'branch',
			'incident_no',
			'subject',
			'action',
			'status',
			'date_range_from',
			'date_range_to'
		];
		// Download report
		downloadReport($scope, $uibModal, $resource, $window, 'summaryofincidentsreport', params, $log);
	}

	/**
	 * User Guide.
	 */
	app.controller('UserGuide', ['$scope', '$resource', '$window', '$http','$route','$templateCache', UserGuide]);

	function UserGuide($scope, $resource, $window, $http,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.logged = $window.user;
		$scope.alerts = {
			error: false,
			success: false,
			uploading: true,
			errorMessage: ''
		};
		$('.wrapper').removeClass('wrapper').addClass('floated-wrapper');
		$scope.API = $resource('/reports/getdata/userguide');
		toggleLoading(true);
		$scope.API.get({}, function (data) {
			$scope.records = data.records;
			$scope.total = data.total;
			toggleLoading();
		});

		$scope.readFile = function (files, id) {
			$('#divSuccess').addClass('ng-hide');
			var fd = new FormData();
			//Take the first selected file
			fd.append("file", files[0]);
			$scope.file = fd;
			$scope.uploadFile(id, $scope.file);
		};

		$scope.uploadFile = function (type, file) {
			$scope.alerts = {
				error: false,
				success: false,
				uploading: true,
				errorMessage: ''
			};
			$http.post('/controller/user/userguide/file/' + type, file, {
				withCredentials: true,
				headers: {'Content-Type': undefined},
				transformRequest: angular.identity
			}).success(function (data) {
				$scope.alerts = {
					uploading: false,
					success: true
				};
				$scope.records = data;
				setTimeoutUserGuide()
			}).error(function (data) {
				$scope.alerts = {
					uploading: false,
					errorMessage: data,
					error: true
				}
			});
		};
	};

	function setTimeoutUserGuide() {
		setTimeout(function () {
			$('#divSuccess').addClass('fade');
		}, 2000);
		setTimeout(function () {
			$('#divSuccess').addClass('ng-hide');
		}, 2200);
	};

	/**
	 * Save user profile
	 */
	function saveUser(scope, resource, location, modal, window, log)
	{
		scope.regExemail = function(){
			var email = $('#email').val();
		   if(email){
				var str=document.getElementById("email");
				var regex=/[^a-zA-Z0-9._@-]/gi;
				str.value=str.value.replace(regex ,"");
			}
		};
		scope.personalInfoError = false;
		scope.locationInfoError = false;
		scope.success = false;

		scope.roleId = 1;
		scope.change = function(){
			log.info(scope.roleId);
		};

		scope.req_salesman = 'hidden';
		scope.role = 1;
		scope.checkRole = function(){
			if(scope.records.user_group_id == 4)
				scope.req_salesman = '';
			else
				scope.req_salesman = 'hidden';
		};

		$('#age').on('change keyup', function () {
			// Remove invalid characters
			var sanitized = $(this).val().replace(/[^-0-9]/g, '');
			// Remove non-leading minus signs
			sanitized = sanitized.replace(/(.)-+/g, '$1');
			// Update value
			$(this).val(sanitized);
		});

		$('#salesman_code, #role ').bind('keyup change', function () {
			if ($('#role').val() == 4) {
				$('#span_salesman').removeClass('hidden');
				if ($('#salesman_code').val() != '') {
					$('#checkbox_jr_salesman').prop('disabled', false);
				}
			} else {
				if ($('#checkbox_jr_salesman').is(':checked')) {
					$('#checkbox_jr_salesman').trigger('click');
				}
				$('#checkbox_jr_salesman').prop('disabled', true);
				$('#checkbox_jr_salesman').attr('checked', false);
				$('#span_salesman').addClass('hidden');
			}
		});

		$('#checkbox_jr_salesman').on('click', function () {
			if ($(this).is(':checked') && typeof scope.records.jr_salesman_code == 'undefined') {
				$('#salesman_code').prop('disabled', true);
				scope.generateJrSalesmanCode();
			} else if (typeof scope.records.jr_salesman_code != "undefined" && scope.records.jr_salesman_code != '') {
				// this function will trigger in a reverse behavior for variable isJr.
				if (scope.isJr) {
					$('#salesman_code').prop('disabled', false);
					$('#label_jr_salesman_code').html('');
				} else {
					$('#salesman_code').prop('disabled', true);
					$('#label_jr_salesman_code').html(scope.records.jr_salesman_code);
				}
			} else if (scope.records.jr_salesman_code == '' && scope.records.salesman_code != '') {
				$('#salesman_code').prop('disabled', true);
				scope.generateJrSalesmanCode();
				scope.records.jr_salesman_code = scope.jr_salesman_code;
			}
			else {
				$('#salesman_code').prop('disabled', false);
				$('#label_jr_salesman_code').html('');
				scope.jr_salesman_code = '';
			}
		});

		// this function will trigger in edit user for jr salesman code;
		scope.editChangeSalesmanCode = function () {
			if (scope.records.jr_salesman_code) {
				scope.generateJrSalesmanCode(scope.records.id);
			}
		};
		
		scope.generateJrSalesmanCode = function (id) {
			var API = resource('/controller/user/generate/' + $('#salesman_code').val());
			if (id) {
				API = resource('/controller/user/generate/' + $('#salesman_code').val() + '/' + id);
			}
			API.get({}, function (data) {
				id ? scope.records.jr_salesman_code = data.result : scope.jr_salesman_code = data.result;
				$('#label_jr_salesman_code').html(scope.jr_salesman_code);
			});
		};

		scope.save = function(edit,profile){
			var personalInfoErrors = [];
			var personalInfoErrorList = '';
			scope.emailList = [];
			scope.usernameList = [];

			var API;
			/*var API = $resource('user/getemails');
			API.get({}, function(data){
				////$log.info(data);
				var emails = [];
				$.each(data, function(index,val){
					//$log.info(val);
					emails.push(val);
				})
				$scope.emailList = emails;
			});
			//$log.info($scope.emailList);

			API = $resource('user/getusernames');
			API.get({}, function(data){
				////$log.info(data);
				var usernames = [];
				$.each(data, function(index,val){
					usernames.push(val);
				})
				$scope.usernameList = usernames;
			});
			//$log.info($scope.usernameList);*/

			// validate personal info
			if(!$.trim($('#fname').val()))
			{
				personalInfoErrors.push('First Name is a required field.');
			}
			if(!$.trim($('#lname').val()))
			{
				personalInfoErrors.push('Last Name is a required field.');
			}
			if(!$.trim($('#username').val()))
			{
				personalInfoErrors.push('Username is a required field.');
			}
			if(!$.trim($('#email').val()))
			{
				personalInfoErrors.push('Email is a required field.');
			}
			if(!$.trim($('#salesman_code').val()) && $('#role').val() == 4)
			{
				personalInfoErrors.push('Salesman code is a required field.');
			}
			var rgxEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if($('#email').val() && !rgxEmail.test($('#email').val().trim()))
			{
				personalInfoErrors.push('Invalid email address.');
			}

		/*	if($('#email').val() && $.inArray($('#email').val(),$scope.emailList))
			{
				personalInfoErrors.push('Email must be unique.');
			}
			
			if($('#username').val() && $.inArray($('#username').val(),$scope.usernameList))
			{
				personalInfoErrors.push('Username must be unique.');
			}*/
			
			/*var numeric = new RegExp('/^\d+$/');
			if($('#telephone').val() && !numeric.test($('#telephone')))
			{
				personalInfoErrors.push('Telephone must be numeric.');
			}
			if($('#mobile').val() && !numeric.test($('#mobile')))
			{
				personalInfoErrors.push('Mobile must be numeric.');
			}*/

			if(!edit)
			{
				if(!$.trim($('#password').val()))
				{
					personalInfoErrors.push('Password is a required field.');
				}
				if(!$.trim($('#confirm_pass').val()))
				{
					personalInfoErrors.push('Confirm password is a required field.');
				}

				if($('#password').val() && $('#confirm_pass').val() && $('#password').val() != $('#confirm_pass').val())
				{
					personalInfoErrors.push('Password don\'t match.')
				}
			}

			if(!$.trim($('#age').val()))
			{
				personalInfoErrors.push('Age is a required field.');
			}

			if(personalInfoErrors.length > 0)
			{
				var i = 0;
				personalInfoErrorList = '<ul>';
				for(i = 0; i < personalInfoErrors.length; i++)
				{
					personalInfoErrorList += '<li>'+personalInfoErrors[i]+'</li>';
				}
				personalInfoErrorList += '</ul>';
				$('#error_list_personal').html(personalInfoErrorList);
				scope.personalInfoError = true;
				scope.success = false;
			}
			else
			{
				scope.personalInfoError = false;
			}


			var locationErrors = [];
			var locationErrorList = '';

			// validate personal info
			if(!$('#role').val())
			{
				locationErrors.push('Role is a required field.')
			}
			if(!$('#area').val())
			{
				locationErrors.push('Area is a required field.')
			}
			if(!$('#assignment_type').val())
			{
				locationErrors.push('Assignment is a required field.')
			}
			if ($('#assignment_date_from').val() > $('#assignment_date_to').val())
			{
				locationErrors.push('Invalid date range.');
			}

			if(locationErrors.length > 0)
			{
				var i = 0;
				locationErrorList = '<ul>';
				for(i = 0; i < locationErrors.length; i++)
				{
					locationErrorList += '<li>'+locationErrors[i]+'</li>';
				}
				locationErrorList += '</ul>';
				$('#error_list_location').html(locationErrorList);
				scope.locationInfoError = true;
				scope.success = false;
			}
			else
			{
				scope.locationInfoError = false;
			}

			if(!scope.locationInfoError && !scope.personalInfoError)
			{
				var editMode = (edit) ? true:false;
				var items = {
					edit_mode: editMode,
					id: scope.id,
					fname: $.trim($('#fname').val()),
					lname: $.trim($('#lname').val()),
					mname: $.trim($('#mname').val()),
					email: $.trim($('#email').val()),
					username: $.trim($('#username').val()),
					password: $.trim($('#password').val()),
					address: $.trim($('#address').val()),
					gender: $('#gender').val(),
					age: $.trim($('#age').val()),
					telephone: $.trim($('#telephone').val()),
					mobile: $.trim($('#mobile').val()),
					role: $('#role').val(),
					area: $('#area').val(),
					salesman_code: $.trim($('#salesman_code').val()),
					jr_salesman_code: typeof scope.records.jr_salesman_code == 'undefined' || typeof scope.isJr == 'undefined' || !scope.isJr ? scope.jr_salesman_code : scope.records.jr_salesman_code,
					assignment_type: $('#assignment_type').val(),
					assignment_date_from: $('#assignment_date_from').val(),
					assignment_date_to: $('#assignment_date_to').val()
				};

				API = resource('controller/user/save');
				API.save(items, function(data){
					if(data.error)
					{
						locationErrorList = '<ul>'+data.error+'</ul>';
						scope.personalInfoError = false;
						scope.locationInfoError = false;
						if(data.exists)
						{
							var errorId = '#error_list_personal'
							scope.personalInfoError = true;
						}
						else
						{
							var errorId = '#error_list_location';
							scope.locationInfoError = true;
						}

						$(errorId).html(locationErrorList);

						scope.success = false;
					}
					else
					{
						scope.success = true;
						if(!profile)
							location.path('user.list');
					}
				});
			}
		}
	}

	/**
	 * Sync controller
	 */

	app.controller('Sync',['$scope','$resource','$log','$route','$templateCache',Sync]);

	function Sync($scope, $resource, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		$scope.showError = false;
		$scope.showSuccess = false;
		$scope.showLoading = false;
		$scope.syncLogs = '';

		$scope.sync = function(){

			$scope.showError = false;
			$scope.showSuccess = false;
			$scope.showLoading = true;
			var API = $resource('controller/reports/sync');
			API.get({}, function(data){
				if(data.logs)
				{
					$scope.syncLogs = data.logs;
					$scope.showSuccess = true;
					$scope.showLoading = false;
					$scope.showError = false;
				}
				else
				{
					$scope.showLoading = false;
					$scope.showError = true;
					$scope.showSuccess = false;
				}
			});
		}
	}


	/**
	 * User Action Controller
	 */
	app.controller('UserAction',['$scope','$uibModalInstance','$window','$resource','params','$log','$route','$templateCache', UserAction]);

	function UserAction($scope, $uibModalInstance, $window, $resource, params, $log,$route,$templateCache) {
		deletePreviousCache($route,$templateCache);

		$scope.params = params;
		//$log.info(params);
		//$log.info($scope);
		$scope.ok = function () {
			switch($scope.params.action)
			{
				case 'activate':
					var API = $resource('/controller/user/activate/'+$scope.params.id);
					API.get({}, function () {
						$("#table_success").fadeTo(2000, 500).slideUp(500, function () {
							$("#table_success").slideUp(500);
						});
					});
					$scope.$parent.records[$scope.params.row].active = true;
					break;
				case 'deactivate':
					var API = $resource('/controller/user/deactivate/'+$scope.params.id);
					API.get({}, function () {
						$("#table_success").fadeTo(2000, 500).slideUp(500, function () {
							$("#table_success").slideUp(500);
						});
					});
					$scope.$parent.records[$scope.params.row].active = false;
					break;
				case 'delete':
					var API = $resource('/controller/user/delete/'+$scope.params.id);
					API.get({},function(data){
						$('#'+$scope.params.id).remove();
						//$log.info(data);
						$("#table_success").fadeTo(2000, 500).slideUp(500, function () {
							$("#table_success").slideUp(500);
						});
					});
					break;
				case 'guide':
					console.log('test');
					break;
			}

			$('#table_success').removeClass('hide').html('User successfully '+$scope.params.action+'d.');

			$uibModalInstance.dismiss('cancel');
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};

	};


	/**
	 * Change password Controller
	 */

	app.controller('ChangePassword',['$scope','$resource','$log','$route','$templateCache',ChangePassword]);

	function ChangePassword($scope, $resource, $log,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		$scope.error = false;
		$scope.success = false;
		$scope.submit = function(){

			var errorList = [];
			if(!$.trim($('#old_password').val()))
			{
				errorList.push('Old password is a required field.');
			}
			if(!$.trim($('#new_password').val()))
			{
				errorList.push('New password is a required field.');
			}
			if(!$.trim($('#confirm_password').val()))
			{
				errorList.push('Confirm password is a required field.');
			}

			if($.trim($('#confirm_password').val()) && $.trim($('#new_password').val()) && $.trim($('#new_password').val()) != $.trim($('#confirm_password').val()))
			{
				errorList.push('Password don\'t match.');
			}

			//$log.info(errorList);
			if(errorList.length > 0)
			{
				var i = 0;
				var errorHtml = '<ul>';
				for(i = 0; i < errorList.length; i++)
				{
					errorHtml += '<li>'+errorList[i]+'</li>';
				}
				errorHtml += '</ul>';
				$('#error_list').html(errorHtml);
				$scope.error = true;
				$scope.success = false;

				return false;
			}
			else
			{
				$('#error_list').html('');
				$scope.error = false;
			}


			var params = {old_pass:$('#old_password').val(),new_pass:$('#new_password').val()};
			//$log.info(params);
			var API = $resource('controller/user/changepass');
			API.save(params, function(data){
				//$log.info(data);
				if(data.success)
				{
					$scope.success = true;
				}
				if(data.failure)
				{
					$('#error_list').html('Incorrect password.');
					$scope.error = true;
					$scope.success = false;
				}
			});
		}
	}


	/**
	 * Profile Controller
	 */

	app.controller('Profile',['$scope','$resource','$location','$uibModal','$window','$log','$route','$templateCache','$http','$routeParams',Profile]);

	function Profile($scope, $resource, $location,$uibModal,$window, $log,$route,$templateCache,$http,$routeParams)
	{
		deletePreviousCache($route,$templateCache);

		$scope.age = '';
		$scope.from = null;
		$scope.to = null;
		$scope.id = 0;

		var url = '/user/myprofile';
		if($routeParams.hasOwnProperty('id')){
			url += '?user_id=' + $routeParams.id
		}
		var API = $resource(url);
		var params = {};

		API.get(params,function(data){
			//angular acts weird with integer option values
			data.user_group_id = String(data.user_group_id);
			$scope.records = data;
			//$log.info(data);
			$scope.id = data.id;
			$scope.age = Number(data.age);
			if(data.location_assignment_from != '0000-00-00 00:00:00' && data.location_assignment_from != null)
				$scope.from = new Date(data.location_assignment_from)
			if(data.location_assignment_to != '0000-00-00 00:00:00' && data.location_assignment_to != null)
				$scope.to = new Date(data.location_assignment_to)
		});

		// Save user profile
		saveUser($scope,$resource,$location ,$uibModal,$window,$log);

		$scope.downloadUserStatistics = function(){
			var image_src = angular.element("#chart-image-div").attr('src');
		    var base64_string = image_src.replace("data:image/png;base64,", "");

			return $http.post(
						'/user/statistics/download/' + ($routeParams.hasOwnProperty('id') ? $routeParams.id : $scope.id),
						{
							'image_string' : base64_string
						},
						{responseType:'arraybuffer'}
			        ).success(function (data, status, headers) {
				        headers = headers();

				        var contentType = headers['content-type'];

				        var linkElement = document.createElement('a');
				        try {
				            var blob = new Blob([data], { type: contentType });
				            var url = window.URL.createObjectURL(blob);

				            linkElement.setAttribute('href', url);
				            linkElement.setAttribute("download", 'user-statistics.pdf');

				            var clickEvent = new MouseEvent("click", {
				                "view": window,
				                "bubbles": true,
				                "cancelable": false
				            });
				            linkElement.dispatchEvent(clickEvent);
				        } catch (ex) {
				            console.log(ex);
				        }
				    }).error(function (data) {
				        console.log(data);
				    });
		}
	}

	/**
	 * User Action Controller
	 */
	app.controller('Info',['$scope','$uibModalInstance','params','$log','$route','$templateCache', Info]);

	function Info($scope, $uibModalInstance, params, $log,$route,$templateCache) {

		$scope.params = params;
		//$log.info(params);

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};

	};

	app.controller('MainCtrl', function($scope) {
		  $scope.var1 = '07-2013';
		});
	
	app.controller('ReversalSummary',['$scope','$resource','$uibModal','$window','$log','TableFix','$route','$templateCache',ReversalSummary]);
	
	function ReversalSummary($scope, $resource, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{	    	
		deletePreviousCache($route,$templateCache);

		var params = [
				  'report',
				  'branch',
				  'updated_by',		          
				  'created_at_from',
				  'created_ate_to',
				  'revision'		          
		];

		// main controller codes
		reportController($scope,$resource,$uibModal,$window,'reversalsummary',params,$log, TableFix);

		//editable rows
		editTable($scope, $uibModal, $resource, $window, {}, $log, TableFix);

	}

	/**
	 * Open and Closing Period controller
	 */
	app.controller('OpenClosingPeriod',['$scope','$http','$uibModal','$window','$log','TableFix','$route','$templateCache',OpenClosingPeriod]);
	
	function OpenClosingPeriod($scope, $http, $uibModal, $window, $log, TableFix,$route,$templateCache)
	{
		deletePreviousCache($route,$templateCache);

		var months = ['January','February','March','April','May','June','July','August','September','October','November','December'];

		$scope.toggleFilter = true;

		$scope.navigation_reports = [];

		$scope.filter = {
			limit_day : 31,
			current_parent_name : '-'
		};

		function updatePeriodStatus(index){
			var data = {
				period_id : $scope.navigation_reports[index].period_id,
				period_status : $scope.navigation_reports[index].period_status
			};

			$http
				.post('/controller/period/update-status', data)
				.then(function(response){
					var result = response.data;
					if(result.success == true){
						$scope.navigation_reports[index].period_status = result.data.period_status;
					} else {
						$scope.navigation_reports[index].period_status = status_value == 1 ? 0 : 1;
					}
				}, function(){

				});
		}

		function updatePeriodDateStatus(navigation_id,index,update_all,day){
			var data = {
				period_id : $scope.navigation_reports[index].period_id,
				company_code : $scope.navigation_reports[index].company_code == null ? $scope.filter.company_code : $scope.navigation_reports[index].company_code,
				period_month : $scope.navigation_reports[index].period_month == null ? $scope.filter.month : $scope.navigation_reports[index].period_month,
				period_year : $scope.navigation_reports[index].period_year == null ? $scope.filter.year : $scope.navigation_reports[index].period_year,
				navigation_id : navigation_id,
				dates : $scope.navigation_reports[index].dates
			};

			$http
				.post('/controller/period/update-date', data)
				.then(function(response){
					var result = response.data;
					if(result.success == true){
						if($scope.navigation_reports[index].period_id == null){
							$scope.navigation_reports[index].period_id = result.data.period_id;
							$scope.navigation_reports[index].company_code = result.data.company_code;
							$scope.navigation_reports[index].period_month = result.data.period_month;
							$scope.navigation_reports[index].period_year = result.data.period_year;
							$scope.navigation_reports[index].navigation_id = result.data.navigation_id;
						}
					} else {
						if(update_all){
							for(var day = 1; day <= $scope.filter.limit_day; day++){
								$scope.navigation_reports[index].dates[day] = 'close';
							}
						} else {
							if($scope.navigation_reports[index].dates[day] == 1){
								$scope.navigation_reports[index].dates[day] = 'close';
							} else {
								$scope.navigation_reports[index].dates[day] = 'open';
							}
						}
					}
				}, function(){

				});
		}

		// creates 1 to 28,29,30 and 31 
		$scope.rangeLimit =  function(limit){
			var day = [];
			for (var i = 1; i <= limit; i++) {
				day.push(i);
			}
			return day;
		}

		// filter on showing reports to open and close
		$scope.filter = function(){
			$scope.navigation_reports = [];
			$scope.filter.current_parent_name = '-';
			$scope.filter.limit_day = 0;

			var year = $('#year').val();
			var month = $('#month').val();
			var company_code = $('#company_code').val();

			var data = {
				navigations_ids : $('#navigation_ids').val(),
				year: year,
				month: month,
				company_code: company_code,
			};

			$http
				.post('/open-closing-period/request-reports', data)
				.then(function(response){
					var navigation_reports = angular.copy(response.data.navigation_reports);
					$scope.navigation_reports = angular.copy(response.data.navigation_reports);

					$scope.navigation_reports = response.data.navigation_reports;

					$scope.filter.year = year;
					$scope.filter.month = month;
					$scope.filter.company_code = company_code;
					$scope.filter.limit_day = response.data.day_limit;
					$scope.filter.period_label = months[month-1] + ' ' + year;
				}, function(){

				});
		}

		// check all checkboxes of a report
		$scope.checkAll = function(parent_id,child_id){
			var id = (child_id == null ? parent_id : child_id);
			var navigation_reports_length = $scope.navigation_reports.length;
			for(var x = 0; x < navigation_reports_length; x++){
				if($scope.navigation_reports[x].parent_id == id || $scope.navigation_reports[x].child_id == id){

					for(var day = 1; day <= $scope.filter.limit_day; day++){
						$scope.navigation_reports[x].dates[day] = 'close';
					}

					updatePeriodDateStatus(id,x,true,0);
					break;
				}
			};
		}

		// show "Check All" button
		$scope.showCheckAllButton = function(parent_id,child_id){
			var id = (child_id == null ? parent_id : child_id);

			var navigation_reports_length = $scope.navigation_reports.length;
			for(var x = 0; x < navigation_reports_length; x++){
				if($scope.navigation_reports[x].parent_id == id || $scope.navigation_reports[x].child_id == id){
					var check_count = 0;
					for(var day = 1; day <= $scope.filter.limit_day; day++){
						if($scope.navigation_reports[x].dates[day] == 'close'){
							check_count++;
						}
					}
					if($scope.filter.limit_day == check_count){
						return false;
					}
				}
			};
			return true;
		}

		// close the said report period
		$scope.closeReportPeriod = function(parent_id,child_id){
			var id = (child_id == null ? parent_id : child_id);
			var navigation_reports_length = $scope.navigation_reports.length;
			for(var x = 0; x < navigation_reports_length; x++){
				if($scope.navigation_reports[x].parent_id == id || $scope.navigation_reports[x].child_id == id){
					$scope.navigation_reports[x].period_status = 'close';

					updatePeriodStatus(x);
					break;
				}
			};
		}

		// open the said report period
		$scope.openReportPeriod = function(parent_id,child_id){
			var id = (child_id == null ? parent_id : child_id);
			var navigation_reports_length = $scope.navigation_reports.length;
			for(var x = 0; x < navigation_reports_length; x++){
				if($scope.navigation_reports[x].parent_id == id || $scope.navigation_reports[x].child_id == id){
					$scope.navigation_reports[x].period_status = 'open';

					updatePeriodStatus(x);
					break;
				}
			};
		}

		// change status of a period date
		$scope.changePeriodDateStatus = function(parent_id,child_id,day){
			var id = (child_id == null ? parent_id : child_id);
			var navigation_reports_length = $scope.navigation_reports.length;
			for(var x = 0; x < navigation_reports_length; x++){
				if($scope.navigation_reports[x].parent_id == id || $scope.navigation_reports[x].child_id == id){
					if($scope.navigation_reports[x].dates[day] == 'close'){
						$scope.navigation_reports[x].dates[day] = 'open';
					} else {
						$scope.navigation_reports[x].dates[day] = 'close';
					}

					updatePeriodDateStatus(id,x,false,day);
					break;
				}
			};
		}

		// reset the filter
		$scope.reset =  function(){
			$scope.navigation_reports = [];
			$scope.filter.limit_day = 0;
		}

		// download
        $scope.download = function(download_extension){
			window.open('/period/print-report?limit_day=' + $scope.filter.limit_day + '&period_label=' + $scope.filter.period_label + '&navigations_ids=' + $('#navigation_ids').val() + '&year=' + $scope.filter.year + '&month=' + $scope.filter.month + '&company_code=' + $scope.filter.company_code, '_blank');
        }
	}
	
	
	/**
	 * Execute Replenishment
	 */
	function executeReplenishment(scope, resource, modal, filter, log, toaster)
	{
		var url = '/reports/replenishment/export';
		var delimeter = '?';
		var query = '';

		$.each(filter, function(index,val){
			if(index > 0)
				delimeter = '&';
			query += delimeter + val + '=' + $('#'+val).val();
		});
		url += query;
		
		scope.params = filter;	
		scope.urlQuery = query;
		
		scope.exportXls = function() {			
			window.location.href = url;						
		}
				
		scope.postData = function(){		
			var modalInstance = modal.open({
				scope: scope,
				animation: true,
				templateUrl: 'ConfirmPost',
				controller: 'ReplenishmentConfirm',
				windowClass: 'center-modal',						
			});		
		}
		
		scope.seedHeader = function(){		
			var API = resource('controller/vaninventory/replenishment/seed/header');
			
			var params = {
				'salesman_code': $('#salesman_code').val(),
				'type': $('#type').val(),
				'area_code': $('#area_code').val(),
				'reference_number': $('#reference_number').val(),
				'replenishment_date': $('#replenishment_date').val()				
			};
			
			API.save(params).$promise.then(function(data){
				if(data.success){
					toaster.pop('success', 'Success', 'Successfuly Seeded Header', 5000);
				} else {
					toaster.pop('error', 'Error', data.msg, 5000);
				}
			}, function(error){
				toaster.pop('error', 'Error', 'Server Error, Please contact System Administrator', 3000);
			});
		}
		
		scope.seedData = function(){		
			var API = resource('controller/vaninventory/replenishment/seed/detail');
			
			var params = {
				'salesman_code': $('#salesman_code').val(),
				'type': $('#type').val(),
				'area_code': $('#area_code').val(),
				'reference_number': $('#reference_number').val(),
				'replenishment_date': $('#replenishment_date').val()				
			};
			
			API.save(params).$promise.then(function(data){
				if(data.success){
					toaster.pop('success', 'Success', 'Successfuly Seeded Data', 5000);
				} else {
					toaster.pop('error', 'Error', data.msg, 5000);
				}
			}, function(error){
				toaster.pop('error', 'Error', 'Server Error, Please contact System Administrator', 3000);
			});
		}
		
		scope.clearData = function(){		
			var API = resource('controller/vaninventory/replenishment/seed/clear');
			
			var params = {
				'salesman_code': $('#salesman_code').val(),
				'type': $('#type').val(),
				'area_code': $('#area_code').val(),
				'reference_number': $('#reference_number').val(),
				'replenishment_date': $('#replenishment_date').val()				
			};
			
			API.save(params).$promise.then(function(data){
				if(data.success){
					toaster.pop('success', 'Success', 'Successfuly Cleared', 5000);
				} else {
					toaster.pop('error', 'Error', data.msg, 5000);
				}
			}, function(error){
				toaster.pop('error', 'Error', 'Server Error, Please contact System Administrator', 3000);
			});
		}
	}
	
	/**
	 * Open and Closing Period controller
	 */
	app.controller('ReplenishmentConfirm',['$scope','$http','$uibModalInstance','$window','$log','toaster',ReplenishmentConfirm]);
	
	function ReplenishmentConfirm($scope, $http, $uibModalInstance, $window, $log, toaster)
	{
		
		$scope.ok = function () {
			
			var url = 'controller/vaninventory/replenishment/post';
			var postData = {
					salesman_code: $('#salesman_code').val(),
					salesman_code: $('#replenishment_date').val(),
					salesman_code: $('#reference_number').val(),
					salesman_code: $('#type').val(),
					salesman_code: $('#area_code').val()
			};

			$http.post(url,postData)
			.success(function (data) {
				if(data.success){
					toaster.pop('success', 'Success', 'Successfuly Posted Data', 5000);
				} else {
					toaster.pop('error', 'Error', data.msg, 5000);
				}
			}).error(function (data) {
				toaster.pop('error', 'Error', 'Server Error, Please contact System Administrator', 3000);
			});
			
			$uibModalInstance.dismiss('cancel');
		};

		$scope.cancel = function () {		
			$uibModalInstance.dismiss('cancel');
		};
	}	

	/**
	 * User Access Matrix controller
	 */
	app.controller('UserAccessMatrix',['$scope','$http','$uibModal','$window','$log','TableFix','toaster', '$route','$templateCache',UserAccessMatrix]);
	
	function UserAccessMatrix($scope, $http, $uibModal, $window, $log, TableFix, toaster, $route, $templateCache)
	{
		deletePreviousCache($route,$templateCache);

		$scope.toggleFilter = true;
		$scope.success = false;
		$scope.savePermissionData = {};
		$scope.navigations = [];
		$scope.navs = [];
		$scope.nav_actions = [];
		$scope.nav_overrides = [];
		$scope.nav_action_overrides = [];
		$scope.choosen_navigations = [];

		function navigationStatus(navigation_id){
			if($scope.savePermissionData.type == 'user'){
				var nav_overrides_length = $scope.nav_overrides.length;

				if(nav_overrides_length > 0){
					for (var nav_overrides_ctr = 0; nav_overrides_ctr < nav_overrides_length; nav_overrides_ctr++) {
						if(navigation_id == $scope.nav_overrides[nav_overrides_ctr]['navigation_id']){
							return $scope.nav_overrides[nav_overrides_ctr]['status'];
						}
					}
				}

				return 'inherit';
			}

			var nav_length = $scope.navs.length;

			if(nav_length > 0){
				for (var navs_ctr = 0; navs_ctr < nav_length; navs_ctr++) {
					if(navigation_id == $scope.navs[navs_ctr]){
						return true;
					}
				}
			}

			return false;
		}

		function navigationActionStatus(permission_id){
			if($scope.savePermissionData.type == 'user'){
				var nav_action_overrides_length = $scope.nav_action_overrides.length;

				if(nav_action_overrides_length > 0){
					for (var nav_action_overrides_ctr = 0; nav_action_overrides_ctr < nav_action_overrides_length; nav_action_overrides_ctr++) {
						if(permission_id == $scope.nav_action_overrides[nav_action_overrides_ctr]['permission_id']){
							return $scope.nav_action_overrides[nav_action_overrides_ctr]['status'];
						}
					}
				}

				return 'inherit';
			}

			var nav_actions_length = $scope.nav_actions.length;

			if(nav_actions_length > 0){
				for (var nav_actions_ctr = 0; nav_actions_ctr < nav_actions_length; nav_actions_ctr++) {
					if(permission_id == $scope.nav_actions[nav_actions_ctr]){
						return true;
					}
				}
			}

			return false;
		}

		function processPermissionStatus(){
			var navigations_length = $scope.navigations.length;
			if(navigations_length > 0){
				for (var navigations_ctr = 0; navigations_ctr < navigations_length; navigations_ctr++) {
					$scope.navigations[navigations_ctr].status = navigationStatus($scope.navigations[navigations_ctr].id);

					var children_length = $scope.navigations[navigations_ctr].children.length;
					if(children_length > 0){
						for(var children_ctr = 0; children_ctr < children_length; children_ctr++){
							$scope.navigations[navigations_ctr].children[children_ctr].status = navigationStatus($scope.navigations[navigations_ctr].children[children_ctr].id);

							var children_action_length = $scope.navigations[navigations_ctr].children[children_ctr].action.length;
							if(children_action_length > 0){
								for(var children_action_ctr = 0; children_action_ctr < children_action_length; children_action_ctr++){
									$scope.navigations[navigations_ctr].children[children_ctr].action[children_action_ctr].status = navigationActionStatus($scope.navigations[navigations_ctr].children[children_ctr].action[children_action_ctr].id);
								}
							}
						}
					}

					var action_length = $scope.navigations[navigations_ctr].action.length;
					if(action_length > 0){
						for(var action_ctr = 0; action_ctr < action_length; action_ctr++){
							$scope.navigations[navigations_ctr].action[action_ctr].status = navigationActionStatus($scope.navigations[navigations_ctr].action[action_ctr].id);
						}
					}
				}
			}
		}

		// reset the filter
		$scope.reset =  function(){
			$scope.navigations = [];
		}

		// filter on showing reports to open and close
		$scope.filter = function(){
			$scope.navigations = [];

			var data = {
				user_group_id : angular.element("#user_group_id").val(),
				user_id: angular.element("#user_id").val()
			};

			if(angular.element('#user_group_id').length) {
			    $scope.savePermissionData.type = 'role';
			}

			if(angular.element('#user_id').length) {
			    $scope.savePermissionData.type = 'user';
			}

			$http
				.post('/controller/user-access-matrix/load-permissions', data)
				.then(function(response){
					$scope.navigations = response.data.navigations;
					$scope.navs = response.data.user_navs;
					$scope.nav_actions = response.data.user_nav_actions;
					$scope.nav_overrides = response.data.user_nav_overrides;
					$scope.nav_action_overrides = response.data.user_nav_action_overrides;
					processPermissionStatus();
				}, function(){

				});
		}

		$scope.hideSubMenu = function(navigation_id){
			angular.element(".navigation-" + navigation_id).slideToggle();
		}

		$scope.hideAction = function(navigation_id){
			angular.element(".navigation-" + navigation_id + "-action").slideToggle();
		}

		$scope.parentChange = function(parent_index,value){
			$scope.navigations[parent_index].status = value;

			var children_length = $scope.navigations[parent_index].children.length;
			if(children_length > 0){
				for (var child_ctr = 0; child_ctr < children_length; child_ctr++) {
					$scope.navigations[parent_index].children[child_ctr].status = value;

					var child_action_length = $scope.navigations[parent_index].children[child_ctr].action.length;
					if(child_action_length > 0){
						for (var child_action_ctr = 0; child_action_ctr < child_action_length; child_action_ctr++) {
							$scope.navigations[parent_index].children[child_ctr].action[child_action_ctr].status = value;
						}
					}
				}
			}

			var action_length = $scope.navigations[parent_index].action.length;
			if(action_length > 0){
				for (var action_ctr = 0; action_ctr < action_length; action_ctr++) {
					$scope.navigations[parent_index].action[action_ctr].status = value;
				}
			}
		}

		$scope.parentActionChange = function(parent_index,parent_action_index,value){
			$scope.navigations[parent_index].action[parent_action_index].status = value;
		}

		$scope.childChange = function(parent_index,child_index,value){
			$scope.navigations[parent_index].children[child_index].status = value;

			var child_action_length = $scope.navigations[parent_index].children[child_index].action.length;
			if(child_action_length > 0){
				for (var child_action_ctr = 0; child_action_ctr < child_action_length; child_action_ctr++) {
					$scope.navigations[parent_index].children[child_index].action[child_action_ctr].status = value;
				}
			}
		}

		$scope.childActionChange = function(parent_index,child_index,child_action_index,value){
			$scope.navigations[parent_index].children[child_index].action[child_action_index].status = value;
		}

		$scope.savePermission = function(){
			var allowed_navs = [];
			var allowed_nav_actions = [];
			var user_navs = [];
			var user_nav_actions = [];

			var navigations_length = $scope.navigations.length;
			for (var navigations_ctr = 0; navigations_ctr < navigations_length; navigations_ctr++) {
				if($scope.savePermissionData.type == 'role'){
					if($scope.navigations[navigations_ctr].status){
						allowed_navs.push($scope.navigations[navigations_ctr].id);
					}
				}
				if($scope.savePermissionData.type == 'user'){
					user_navs.push({
						id : $scope.navigations[navigations_ctr].id,
						status: $scope.navigations[navigations_ctr].status
					});
				}

				var children_length = $scope.navigations[navigations_ctr].children.length;
				if(children_length > 0){
					for(var children_ctr = 0; children_ctr < children_length; children_ctr++){
						if($scope.savePermissionData.type == 'role' && $scope.navigations[navigations_ctr].children[children_ctr].status){
							allowed_navs.push($scope.navigations[navigations_ctr].children[children_ctr].id);
						}
						if($scope.savePermissionData.type == 'user'){
							user_navs.push({
								id : $scope.navigations[navigations_ctr].children[children_ctr].id,
								status: $scope.navigations[navigations_ctr].children[children_ctr].status
							});
						}

						var children_action_length = $scope.navigations[navigations_ctr].children[children_ctr].action.length;
						if(children_action_length > 0){
							for(var children_action_ctr = 0; children_action_ctr < children_action_length; children_action_ctr++){
								if($scope.savePermissionData.type == 'role' && $scope.navigations[navigations_ctr].children[children_ctr].action[children_action_ctr].status){
									allowed_nav_actions.push($scope.navigations[navigations_ctr].children[children_ctr].action[children_action_ctr].id);
								}
								if($scope.savePermissionData.type == 'user'){
									user_nav_actions.push({
										id : $scope.navigations[navigations_ctr].children[children_ctr].action[children_action_ctr].id,
										status: $scope.navigations[navigations_ctr].children[children_ctr].action[children_action_ctr].status
									});
								}
							}
						}
					}
				}

				var action_length = $scope.navigations[navigations_ctr].action.length;
				if(action_length > 0){
					for(var action_ctr = 0; action_ctr < action_length; action_ctr++){
						if($scope.savePermissionData.type == 'role' && $scope.navigations[navigations_ctr].action[action_ctr].status){
							allowed_nav_actions.push($scope.navigations[navigations_ctr].action[action_ctr].id);
						}
						if($scope.savePermissionData.type == 'user'){
							user_nav_actions.push({
								id : $scope.navigations[navigations_ctr].action[action_ctr].id,
								status: $scope.navigations[navigations_ctr].action[action_ctr].status
							});
						}
					}
				}
			}

			var data = {
				allowed_navs: allowed_navs,
				allowed_nav_actions: allowed_nav_actions,
				user_navs: user_navs,
				user_nav_actions: user_nav_actions
			};

			if($scope.savePermissionData.type == 'role'){
				data.id = angular.element("#user_group_id").val();
				data.type = 'role';
			}

			if($scope.savePermissionData.type == 'user'){
				data.id = angular.element("#user_id").val();
				data.type = 'user';
			}

			$http
				.post('/controller/user-access-matrix/save-permissions', data)
				.then(function(response){
					if(response.data.success){
						toaster.pop('success', 'Success', 'Permission Saved',3000);
						window.location.reload();
					}
				}, function(){

				});
		}
	}

	/**
	 * Delete the Previous Cache of a page
	 * @param  {Object} route
	 * @param  {Object} templateCache
	 * @return NONE
	 */
	function deletePreviousCache(route,templateCache){
		var currentPageTemplate = route.current.loadedTemplateUrl;
		templateCache.remove(currentPageTemplate);
	}

	/**
	 * User Activity Log controller
	 */
	app.controller('UserActivityLog',['$scope','$http','$uibModal','$window','$log','TableFix','toaster', '$route','$templateCache',UserActivityLog]);
	
	function UserActivityLog($scope, $http, $uibModal, $window, $log, TableFix, toaster, $route, $templateCache)
	{
		deletePreviousCache($route,$templateCache);

		$scope.toggleFilter = true;
		$scope.records = [];

		// filter on showing reports to open and close
		$scope.filter = function(){
			$scope.records = [];

			var data = {
				user_id: angular.element("#user_id").val(),
				navigation_id: angular.element("#navigation_id").val(),
				log_date_from: angular.element("#log_date_from").val(),
				log_date_to: angular.element("#log_date_to").val(),
			};

			$http
				.post('/controller/user-activity-log/load', data)
				.then(function(response){
					$scope.records = response.data.records;
				}, function(){

				});
		}

		$scope.reset =  function(){
			$scope.records = [];
		}

		$scope.download = function(format){
			var uri = '';

			if(angular.element("#user_id").val()){
				uri += (uri == '' ? '?' : '&') + 'user_id=' + angular.element("#user_id").val();
			}

			if(angular.element("#navigation_id").val()){
				uri += (uri == '' ? '?' : '&') + 'navigation_id=' + angular.element("#navigation_id").val();
			}

			if(angular.element("#log_date_from").val()){
				uri += (uri == '' ? '?' : '&') + 'log_date_from=' + angular.element("#log_date_from").val();
			}

			if(angular.element("#log_date_to").val()){
				uri += (uri == '' ? '?' : '&') + 'log_date_to=' + angular.element("#log_date_from").val();;
			}

			window.open('/controller/user-activity-log/load' + uri + '&download=pdf', '_blank');
		}
	}

	// Mass Edit
	function massEdit(scope,modal,slug){
		scope.showMassEdit = false;
		scope.hasChecked = false;
		scope.checkedRecords = [];

		function updateCheckedRecords(){
			scope.checkedRecords = scope.records.filter(function(value,index){
				if(value.selected_checkbox){
					value.scope_index = index;
					return value;
				}
			});

			scope.hasChecked = scope.checkedRecords.length > 0 ? true : false;
		}

		scope.checkAll = function(){
			if(scope.records.length > 0){
				angular.forEach(scope.records, function(value, key){
					scope.records[key].selected_checkbox = !scope.hasChecked ? 1 : 0;
				});
				scope.hasChecked = !scope.hasChecked ? true : false;
				updateCheckedRecords();
			}
		}

		scope.checkRecord = function(key,status){
			scope.records[key].selected_checkbox = scope.records[key].selected_checkbox ? true : false;
			updateCheckedRecords();
		}

		scope.showMassEditPage = function(){
			if(!angular.element('#mass-edit-btn').attr('disabled')){
				var modalInstance = modal.open({
					animation: true,
					scope: scope,
					templateUrl: 'MassEdit',
					controller: 'MassEditRecord',
					windowClass: 'center-modal',
					size: 'lg',
					resolve: {
						params: function () {
							return {
								slug: slug
							};
						}
					}
				});
			}
		}
	}

	/**
	 * Mass Edit Record controller
	 */
	app.controller('MassEditRecord', ['$scope', '$uibModalInstance', '$resource', 'params', '$log', 'EditableFixTable','$route','$templateCache','$uibModal', MassEditRecord]);

	function MassEditRecord($scope, $uibModalInstance, $resource, params, $log, EditableFixTable,$route,$templateCache,$uibModal) {
		deletePreviousCache($route,$templateCache);

		var url = window.location.href;
		url = url.split("/");

		var reportType = '';
		var report = '';

		switch (url[4]) {
			case "salescollection.report":
				reportType = "Sales & Collection - Report";
				report = 'salescollectionreport';
				break;
			case "vaninventory.canned":
				reportType = "Van Inventory - Canned & Mixes";
				report = 'vaninventorycanned';
				break;
			case "vaninventory.frozen":
				reportType = "Van Inventory - Frozen & Kassel";
				report = 'vaninventoryfrozen';
				break;
			case "salesreport.permaterial":
				reportType = "Sales Report - Per Material";
				report = 'salesreportpermaterial';
				break;
			case "salesreport.pesovalue":
				reportType = "Sales Report - Peso Value";
				report = 'salesreportperpeso';
				break;
			case "vaninventory.stocktransfer":
				reportType = "Van Inventory - Stock Transfer";
				report = 'stocktransfer';
				break;			
			case 'cashpayments':
				reportType = "Cash Payments";
				report = 'cashpayments';
				break;
		}

		$scope.$watchCollection("checkedRecords",function(newValue, oldValue) {
			if(newValue.length == 0){
				$uibModalInstance.dismiss('cancel');
			}
        });

		$scope.mass_edit = {};

		$scope.format = 'MM/dd/yyyy';

		function dateFormattedValue(dateValue){
			return addTrailingZero(dateValue.getMonth() + 1) + '/' + addTrailingZero(dateValue.getDate()) + '/' + addTrailingZero(dateValue.getFullYear())
		}

		function timeFormattedValue(dateValue){
			return addTrailingZero(dateValue.getHours()) + ':' + addTrailingZero(dateValue.getMinutes()) + ':' + addTrailingZero(dateValue.getSeconds());
		}

		function updateCheckedRecordMessage(index,dateValue){
			var message = '';

			if($scope.mass_edit.edit_field.value == 'invoice_date' || $scope.mass_edit.edit_field.value == 'invoice_return_date'){
				message = 'Invoice Date: ' + dateFormattedValue(dateValue) + '<br/><br/> Please confirm if the Invoice Date ' + dateFormattedValue(dateValue) + ' is correct?';
			}

			if($scope.mass_edit.edit_field.value == 'or_date'){
				message = 'Collection Date: ' + dateFormattedValue(dateValue) + '<br/><br/> Please confirm if the Collection Date ' + dateFormattedValue(dateValue) + ' is correct?';
			}

			if($scope.mass_edit.edit_field.value == 'check_date'){
				message = 'Check Date: ' + dateFormattedValue(dateValue) + '<br/><br/> Please confirm if the Check Date ' + dateFormattedValue(dateValue) + ' is correct?';
			}

			if($scope.mass_edit.edit_field.value == 'invoice_return_posting_date'){
				message = 'Posting Date: ' + dateFormattedValue(dateValue) + '<br/><br/> Please confirm if the Posting Date ' + dateFormattedValue(dateValue) + ' is correct?';
			}

			if($scope.mass_edit.edit_field.value == 'transfer_date'){
				message = 'Transfer Date: ' + dateFormattedValue(dateValue) + '<br/><br/> Please confirm if the Transfer Date ' + dateFormattedValue(dateValue) + ' is correct?';
			}

			$scope.checkedRecords[index].message = message;
		}

		function updateCheckedRecordValueToUse(index,newDateValue){
			var oldDateValue = '';

			if($scope.mass_edit.edit_field.value == 'invoice_date' || $scope.mass_edit.edit_field.value == 'invoice_return_date'){
				oldDateValue = $scope.checkedRecords[index].invoice_date;
			}

			if($scope.mass_edit.edit_field.value == 'or_date'){
				oldDateValue = $scope.checkedRecords[index].or_date;
			}

			if($scope.mass_edit.edit_field.value == 'check_date'){
				oldDateValue = $scope.checkedRecords[index].check_date;
			}

			if($scope.mass_edit.edit_field.value == 'invoice_return_posting_date'){
				oldDateValue = $scope.checkedRecords[index].invoice_posting_date;
			}

			if($scope.mass_edit.edit_field.value == 'transfer_date'){
				oldDateValue = $scope.checkedRecords[index].transfer_date;
			}

			$scope.checkedRecords[index].value_to_use = dateFormattedValue(newDateValue) + ' ' + (oldDateValue != '' ? oldDateValue.split(" ")[1] : timeFormattedValue(newDateValue));
		}

		$scope.open = function($event, index) {
			$event.preventDefault();
			$event.stopPropagation();
			$scope.checkedRecords[index].opened = true;
		};

		$scope.setDataToChange =  function(){
			angular.forEach($scope.checkedRecords,function(value,index){
				var value_to_use = '';

				if($scope.mass_edit.edit_field.value == 'invoice_date' || $scope.mass_edit.edit_field.value == 'invoice_return_date'){
					value_to_use = value.invoice_date;
					$scope.checkedRecords[index].id_to_use = ($scope.mass_edit.edit_field.value == 'invoice_return_date' ? $scope.checkedRecords[index].invoice_pk_id : $scope.checkedRecords[index].invoice_date_id);
					$scope.checkedRecords[index].table_to_use = ($scope.mass_edit.edit_field.value == 'invoice_return_date' ? $scope.checkedRecords[index].invoice_table : $scope.checkedRecords[index].invoice_date_table);
					$scope.checkedRecords[index].column_to_use = ($scope.mass_edit.edit_field.value == 'invoice_return_date' ? $scope.checkedRecords[index].invoice_date_column : $scope.checkedRecords[index].invoice_date_col);
					$scope.checkedRecords[index].column_to_update = 'invoice_date_updated';
				}

				if($scope.mass_edit.edit_field.value == 'or_date'){
					value_to_use = value.or_date;
					$scope.checkedRecords[index].id_to_use = $scope.checkedRecords[index].collection_header_id;
					$scope.checkedRecords[index].table_to_use = 'txn_collection_header';
					$scope.checkedRecords[index].column_to_use = 'or_date';
					$scope.checkedRecords[index].column_to_update = 'or_date_updated';
				}

				if($scope.mass_edit.edit_field.value == 'check_date'){
					value_to_use = value.check_date;
					$scope.checkedRecords[index].id_to_use = $scope.checkedRecords[index].collection_detail_id;
					$scope.checkedRecords[index].table_to_use = 'txn_collection_detail';
					$scope.checkedRecords[index].column_to_use = 'check_date';
					$scope.checkedRecords[index].column_to_update = 'check_date_updated';
				}

				if($scope.mass_edit.edit_field.value == 'invoice_return_posting_date'){
					value_to_use = value.invoice_posting_date;
					$scope.checkedRecords[index].id_to_use = $scope.checkedRecords[index].invoice_pk_id;
					$scope.checkedRecords[index].table_to_use = $scope.checkedRecords[index].invoice_table;
					$scope.checkedRecords[index].column_to_use = $scope.checkedRecords[index].invoice_posting_date_column;
					$scope.checkedRecords[index].column_to_update = 'invoice_posting_date_updated';
				}

				if($scope.mass_edit.edit_field.value == 'transfer_date'){
					value_to_use = value.transfer_date;
					$scope.checkedRecords[index].id_to_use = $scope.checkedRecords[index].stock_transfer_in_header_id;
					$scope.checkedRecords[index].table_to_use = 'txn_stock_transfer_in_header';
					$scope.checkedRecords[index].column_to_use = 'transfer_date';
					$scope.checkedRecords[index].column_to_update = 'transfer_date_updated';
				}

				$scope.checkedRecords[index].dateFrom = (value_to_use == null || value_to_use == '' ? new Date() : new Date(value_to_use));
				updateCheckedRecordMessage(index,$scope.checkedRecords[index].dateFrom);
				updateCheckedRecordValueToUse(index,$scope.checkedRecords[index].dateFrom);
			});
		};

		$scope.change = function (index,dateFrom){
			$scope.checkedRecords[index].dateFrom = dateFrom;

			updateCheckedRecordMessage(index,dateFrom);
			updateCheckedRecordValueToUse(index,dateFrom);
		}

		$scope.disabledButton =  function(){
			var mass_edit_field_length = Object.keys($scope.mass_edit).length;

			if(mass_edit_field_length > 0){
				var checked_records_length = $scope.checkedRecords.length;

				var not_changed_count = 0;

				var date_to_use = '';

				for (var i = 0; i < checked_records_length; i++) {
					if($scope.mass_edit.edit_field != 'undefined' && ($scope.mass_edit.edit_field.value == 'invoice_date' || $scope.mass_edit.edit_field.value == 'invoice_return_date')){
						date_to_use = new Date($scope.checkedRecords[i].invoice_date);
					}

					if($scope.mass_edit.edit_field != 'undefined' && $scope.mass_edit.edit_field.value == 'or_date'){
						date_to_use = new Date($scope.checkedRecords[i].or_date);
					}

					if($scope.mass_edit.edit_field != 'undefined' && $scope.mass_edit.edit_field.value == 'check_date'){
						date_to_use = new Date($scope.checkedRecords[i].check_date);
					}

					if($scope.mass_edit.edit_field != 'undefined' && $scope.mass_edit.edit_field.value == 'invoice_return_posting_date'){
						date_to_use = new Date($scope.checkedRecords[i].invoice_posting_date);
					}

					if($scope.mass_edit.edit_field != 'undefined' && $scope.mass_edit.edit_field.value == 'transfer_date'){
						date_to_use = new Date($scope.checkedRecords[i].transfer_date);
					}

					if($scope.checkedRecords[i].dateFrom.valueOf() !== date_to_use.valueOf()){
						not_changed_count += 1;
					}
				}

				return not_changed_count == checked_records_length ? false : true;
			}

			return true;
		}

		$scope.save = function(){
			if(!angular.element('#btnsub').attr('disabled')){
				angular.forEach($scope.checkedRecords,function(value){
					$uibModal.open({
						animation: true,
						scope: $scope,
						templateUrl: 'ConfirmationTemplate',
						controller: 'ConfirmMassEdit',
						windowClass: 'center-modal',
						size: 'lg',
						resolve: {
							params: function () {
								return {
									id 				   : value.id_to_use,
									column 			   : value.column_to_use,
									table 			   : value.table_to_use,
									value 			   : value.value_to_use,
									comment 		   : $scope.mass_edit.comment,
									report_type 	   : reportType,
									report 			   : report,
									slug			   : params.slug,
									scope_index 	   : value.scope_index,
									column_to_update   : value.column_to_update,
									message            : value.message
								};
							}
						}
					});
				});
			}
		}

		$scope.cancelMassEdit = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}

	/**
	 * ConfirmMassEdit controller
	 */
	app.controller('ConfirmMassEdit', ['$scope', '$sce', '$uibModalInstance', 'params', '$resource', '$log', 'EditableFixTable','$route','$templateCache','toaster', 'TableFix', ConfirmMassEdit]);

	function ConfirmMassEdit($scope, $sce, $uibModalInstance, params, $resource, $log, EditableFixTable,$route,$templateCache,toaster, TableFix) {
		$scope.params = params;
		$scope.params.message = $sce.trustAsHtml($scope.params.message);

		$scope.ok = function (){
			var API = $resource('controller/reports/save');

			API.save($scope.params, function (data) {
				var checked_records_length = $scope.checkedRecords.length;

				for (var i = 0; i < checked_records_length; i++) {
					if($scope.params.scope_index == $scope.checkedRecords[i].scope_index){
						$scope.checkedRecords.splice(i,1);
						break;
					}
				}

				$scope.records[$scope.params.scope_index][$scope.params.column_to_update] = 'modified';
				$scope.records[$scope.params.scope_index].selected_checkbox = false;
				$scope.hasChecked = false;

				if($scope.params.column_to_update == 'invoice_date_updated'){
					$scope.records[$scope.params.scope_index].invoice_date = $scope.params.value;
				}

				if($scope.params.column_to_update == 'or_date_updated'){
					$scope.records[$scope.params.scope_index].or_date = $scope.params.value;
				}

				if($scope.params.column_to_update == 'check_date_updated'){
					$scope.records[$scope.params.scope_index].check_date = $scope.params.value;
				}

				if($scope.params.column_to_update == 'invoice_posting_date_updated'){
					$scope.records[$scope.params.scope_index].invoice_posting_date = $scope.params.value;
				}

				if($scope.params.column_to_update == 'transfer_date_updated'){
					$scope.records[$scope.params.scope_index].transfer_date = $scope.params.value;
				}

				$('table.table').floatThead('destroy');

				toaster.pop('success', 'Success', 'Successfuly Updated Date');

				$uibModalInstance.dismiss('cancel');
			});
		};

		$scope.cancelConfirmation = function () {
			$uibModalInstance.dismiss('cancel');
		};
	}

	// Add Zero if below 10 used for Date or Time Format
	function addTrailingZero(value){
		return value.length == 1 ? ('0' + value) : value;
	}

	app.controller('AuditorsList',['$scope','$http','$uibModal','$window','$log','TableFix','$route','$templateCache','toaster',AuditorsList]);

	function AuditorsList($scope, $http, $uibModal, $window, $log, TableFix,$route,$templateCache,toaster)
	{
		deletePreviousCache($route,$templateCache);

		$scope.toggleFilter = true;
		$scope.records = [];
		var sortColumn = '';
		var sortOrder = '';

		var uri = '';

		function loadAuditorList(){
			toggleLoading(true);

			$http
				.get('/controller/auditors-list' + uri)
				.then(function(response){
					$scope.records = response.data;

					toggleLoading(false);

					$("table.table").floatThead({
						position: "absolute",
						autoReflow: true,
						zIndex: "2",
						scrollContainer: function($table){
							return $table.closest(".wrapper");
						}
					});

					if(sortColumn != ''){
						angular.element('.sortable i').removeClass('fa-sort-asc').removeClass('fa-sort-desc');

						angular.element('#'+sortColumn + ' i')
							.removeClass(sortOrder == 'asc' ? 'fa-sort-asc' : 'fa-sort-desc')
							.addClass(sortOrder == 'asc' ? 'fa-sort-desc' : 'fa-sort-asc');
					}
				}, function(){

				});
		}

		function processSearchFilter(){
			uri = '';

			if(angular.element('#auditor_id').val()){
				uri += (uri == '' ? '?' : '&') + 'auditor_id=' + angular.element('#auditor_id').val();
			}

	        if(angular.element('#salesman_code').val()){
	        	uri += (uri == '' ? '?' : '&') + 'salesman_code=' + angular.element('#salesman_code').val();
	        }

	        if(angular.element('#area_code').val()){
	        	uri += (uri == '' ? '?' : '&') + 'area_code=' + angular.element('#area_code').val();
	        }

	        if(angular.element('#type').val()){
	        	uri += (uri == '' ? '?' : '&') + 'type=' + angular.element('#type').val();
	        }

	        if(angular.element('#period_from').val()){
	        	uri += (uri == '' ? '?' : '&') + 'period_from=' + angular.element('#period_from').val();
	        }

	        if(angular.element('#period_to').val()){
	        	uri += (uri == '' ? '?' : '&') + 'period_to=' + angular.element('#period_to').val();
	        }
		}

		$scope.remove = function(id,index){
			$http
			.get('/controller/auditors-list/' + id + '/delete')
			.then(function(response){
				$scope.records.splice(index,1);
				toaster.pop('success', 'Success', 'Successfuly Deleted Record', 5000);
			}, function(){

			});
		}

		$scope.filter = function(){
			processSearchFilter();

	        loadAuditorList();
		}

		$scope.reset = function(){
			uri = '';

			loadAuditorList();
		}

		$scope.sort = function(column_name){
			processSearchFilter();

			sortColumn = column_name;
			uri += (uri == '' ? '?' : '&') + 'order_by=' + sortColumn;

			if(angular.element('#'+sortColumn + ' i').hasClass('fa-sort-desc')){
				sortOrder = 'desc';
			} else {
				sortOrder = 'asc';
			}
			uri += (uri == '' ? '?' : '&') + 'order=' + sortOrder;

			loadAuditorList();
		}

		$scope.download = function(download_type){
			processSearchFilter();
			uri += (uri == '' ? '?' : '&') + 'download_type=' + download_type;
			window.location = '/controller/auditors-list' + uri;
		}

		loadAuditorList();
	}

	app.controller('AuditorsListAdd',['$scope','$resource','$uibModal','$window','$log','TableFix', '$route', '$templateCache', '$location', '$http', 'toaster', AuditorsListAdd]);

	function AuditorsListAdd($scope, $resource, $uibModal, $window, $log, TableFix, $route, $templateCache, $location, $http, toaster)
	{
		deletePreviousCache($route,$templateCache);

		$scope.save = function(){
			var data = {
				auditor_id    : angular.element('#auditor_id').val(),
		        salesman_code : angular.element('#salesman_code').val(),
		        area_code     : angular.element('#area_code').val(),
		        type          : angular.element('#type').val(),
		        period_from   : angular.element('#period_from').val(),
		        period_to     : angular.element('#period_to').val(),
			};

			$http
				.post('/controller/auditors-list/add',data)
				.then(function(response){
					if(response.data.success){
						toaster.pop('success', 'Success', 'Successfuly Created Auditor\'s List', 5000);
						$location.path('auditors.list');
					}
				}, function(response){
					erroCallback(toaster,response);
				});
		}
	}

	app.controller('AuditorsListEdit',['$scope','$resource', '$uibModal','$window','$log','TableFix', '$route', '$templateCache', '$location', '$http', 'toaster', '$routeParams', AuditorsListEdit]);

	function AuditorsListEdit($scope, $resource, $uibModal, $window, $log, TableFix, $route, $templateCache, $location, $http, toaster, $routeParams)
	{
		deletePreviousCache($route,$templateCache);

		$scope.save = function(){
			var data = {
				auditor_id    : angular.element('#auditor_id').val(),
		        salesman_code : angular.element('#salesman_code').val(),
		        area_code     : angular.element('#area_code').val(),
		        type          : angular.element('#type').val(),
		        period_from   : angular.element('#period_from').val(),
		        period_to     : angular.element('#period_to').val(),
			};

			$http
				.post('/controller/auditors-list/' + $routeParams.id + '/update',data)
				.then(function(response){
					if(response.data.success){
						toaster.pop('success', 'Success', 'Successfuly Updated Auditor\'s List', 5000);
						$location.path('auditors.list');
					}
				}, function(response){
					erroCallback(toaster,response);
				});
		}

		$http
			.get('/controller/auditors-list/' + $routeParams.id)
			.then(function(response){
				var data = response.data;
				angular.element('#auditor_id').val(data.auditor_id);
		        angular.element('#salesman_code').val(data.salesman_code);
		        angular.element('#area_code').val(data.area_code);
		        angular.element('#type').val(data.type);
		        angular.element('#period_from').val(data.period_from);
		        angular.element('#period_to').val(data.period_to);
			}, function(){

			});
	}

	app.controller('RemittanceExpenses',['$scope','$http','$uibModal','$window','$log','TableFix','$route','$templateCache','toaster',RemittanceExpenses]);

	function RemittanceExpenses($scope, $http, $uibModal, $window, $log, TableFix,$route,$templateCache,toaster)
	{
		deletePreviousCache($route,$templateCache);

		var uri = '';

		$scope.toggleFilter = true;

		$scope.records = [];

		function loadRemittance(){
			toggleLoading(true);

			$http
				.get('/controller/remittance-expenses-report' + uri)
				.then(function(response){
					$scope.records = response.data;
					toggleLoading(false);
					if($scope.records.length){
						$('#no_records_div').hide();
					} else {
						$('#no_records_div').show();
					}
				});
		}

		function processSearchFilter(){
			uri = '';

			if(angular.element('#salesman_code').val()){
				uri += (uri == '' ? '?' : '&') + 'sr_salesman_code=' + angular.element('#salesman_code').val();
			}

	        if(angular.element('#jr_salesman').val()){
	        	uri += (uri == '' ? '?' : '&') + 'jr_salesman_code=' + angular.element('#jr_salesman').val();
	        }

	        if(angular.element('#date_from').val()){
	        	uri += (uri == '' ? '?' : '&') + 'date_from=' + angular.element('#date_from').val();
	        }

	        if(angular.element('#date_to').val()){
	        	uri += (uri == '' ? '?' : '&') + 'date_to=' + angular.element('#date_to').val();
	        }
		}

		$scope.filter = function(){
			processSearchFilter();

	        loadRemittance();
		}

		$scope.remove = function(index,id){
			$http
				.get('/controller/remittance-expenses-report/' + id + '/delete')
				.then(function(response){
					toaster.pop('success', 'Success', 'Successfuly Deleted Remittance');
					$scope.records.splice(index,1);
				});
		}

		loadRemittance();
	}

	app.controller('RemittanceExpensesAdd',['$scope','$http','$uibModal','$window','$log','TableFix','$route','$templateCache','toaster','$location',RemittanceExpensesAdd]);

	function RemittanceExpensesAdd($scope, $http, $uibModal, $window, $log, TableFix,$route,$templateCache,toaster,$location)
	{
		deletePreviousCache($route,$templateCache);
		console.log($location.path());
		$scope.remittance = {};

		$scope.form = {
			remittance: true,
			expenses: false,
			cash_breakdown: false
		};

		function sum(){
			var cash_amount = (typeof $scope.remittance.cash_amount == 'undefined') || $scope.remittance.cash_amount == '' ? 0 : parseFloat($scope.remittance.cash_amount);
			var check_amount = (typeof $scope.remittance.check_amount == 'undefined') || $scope.remittance.check_amount == '' ? 0 : parseFloat($scope.remittance.check_amount);
			return (cash_amount + check_amount);
		}

		$scope.totalAmount = function(){
			angular.element('#total_amount').val(sum());
		}

		$scope.next_expenses = function(){
			var data = {
		        sr_salesman_code : angular.element('#form_salesman_code').val(),
		        jr_salesman_code : angular.element('#form_jr_salesman').val(),
		        cash_amount : angular.element('#form_cash_amount').val(),
		        check_amount : angular.element('#form_check_amount').val(),
		        date_from   : angular.element('#form_date_from').val(),
		        date_to     : angular.element('#form_date_to').val(),
			};

			$http
				.post('/controller/remittance-expenses-report/create',data)
				.then(function(response){
					if(response.data.success){
						toaster.pop('success', 'Success', 'Successfuly Created Remittance');
						$location.path('/remittance.expenses.report.edit/' + response.data.data.id);
					}
				}, function(response){
					erroCallback(toaster,response);
				});
		}
	}

	app.controller('RemittanceExpensesEdit',['$scope','$http','$uibModal','$window','$log','TableFix','$route','$templateCache','toaster','$routeParams',RemittanceExpensesEdit]);

	function RemittanceExpensesEdit($scope, $http, $uibModal, $window, $log, TableFix,$route,$templateCache,toaster,$routeParams)
	{
		deletePreviousCache($route,$templateCache);

		$scope.form = {
			remittance: true,
			expenses: false,
			cash_breakdown: false
		};

		$scope.remittance = {};

		$scope.createExpense = [{
			expenses: '',
			amount: '',
		}];

		$scope.createCashBreakdown = [{
			denomination: '',
			pieces: '',
		}];

		function sum(){
			var cash_amount = (typeof $scope.remittance.cash_amount == 'undefined') || $scope.remittance.cash_amount == '' ? 0 : parseFloat($scope.remittance.cash_amount);
			var check_amount = (typeof $scope.remittance.check_amount == 'undefined') || $scope.remittance.check_amount == '' ? 0 : parseFloat($scope.remittance.check_amount);
			return (cash_amount + check_amount);
		}

		$scope.totalAmount = function(){
			angular.element('#total_amount').val(sum());
		}

		$scope.next_expenses = function(){
			var data = {
		        sr_salesman_code : angular.element('#form_salesman_code').val(),
		        jr_salesman_code : angular.element('#form_jr_salesman').val(),
		        cash_amount : angular.element('#form_cash_amount').val(),
		        check_amount : angular.element('#form_check_amount').val(),
		        date_from   : angular.element('#form_date_from').val(),
		        date_to     : angular.element('#form_date_to').val(),
			};

			var uri = 'create';
			if($scope.remittance.hasOwnProperty('id'))
			{
				uri = $scope.remittance.id + '/update';
			}

			$http
				.post('/controller/remittance-expenses-report/' + $routeParams.id + '/update',data)
				.then(function(response){
					if(response.data.success){
						$scope.form.remittance = false;
						$scope.form.expenses = true;
						$scope.form.cash_breakdown = false;

						angular.forEach(data, function(value, key) {
							$scope.remittance[key] = value;
						});
						toaster.pop('success', 'Success', 'Successfuly Updated Remittance');
					}
				}, function(response){
					erroCallback(toaster,response);
				});
		}

		//Expenses Page
		$scope.back_remittance = function(){
			angular.element('#form_salesman_code').val($scope.remittance.sr_salesman_code);
	        angular.element('#form_jr_salesman').val($scope.remittance.jr_salesman_code);
	        angular.element('#form_cash_amount').val($scope.remittance.cash_amount);
	        angular.element('#form_check_amount').val($scope.remittance.check_amount);
	        angular.element('#form_date_from').val($scope.remittance.date_from);
	        angular.element('#form_date_to').val($scope.remittance.date_to);
	        angular.element('#total_amount').val(sum());
			$scope.form.remittance = true;
			$scope.form.expenses = false;
			$scope.form.cash_breakdown = false;
		}

		$scope.addExpense = function(){
			$scope.createExpense.push({
				expense: '',
				amount: '',
			});
		}

		$scope.removeExpense = function(index){
			$scope.createExpense.splice(index,1);
			if($scope.createExpense.length == 0){
				$scope.createExpense.push({
					expense: '',
					amount: ''
				});
			}
		}

		$scope.saveExpense = function(index,create_expense,remittance_id){
			create_expense.remittance_id = remittance_id;

			$http
				.post('/controller/remittance-expenses-report/' + remittance_id + '/expenses/create' ,create_expense)
				.then(function(response){
					if(response.data.success){
						if(index == 0){
							$scope.createExpense[0].expense = '';
							$scope.createExpense[0].amount = '';
						} else {
							$scope.createExpense.splice(index,1);
						}

						var expenses = [];
						if($scope.remittance.hasOwnProperty('expenses')){
							expenses = angular.copy($scope.remittance.expenses);
						}
						expenses.push(response.data.data);

						$scope.remittance.expenses = expenses;
						toaster.pop('success', 'Success', 'Successfuly Created Remittance-Expense');
					}
				}, function(response){
					erroCallback(toaster,response);
				});
		}

		$scope.updateExpense = function(index,update_expense){
			$http
				.post('/controller/remittance-expenses-report/' + update_expense.remittance_id + '/expenses/' + update_expense.id + '/update' ,update_expense)
				.then(function(response){
					if(response.data.success){
						$scope.remittance.expenses[index].expense = update_expense.expense;
						$scope.remittance.expenses[index].amount = update_expense.amount;
						toaster.pop('success', 'Success', 'Successfuly Updated Remittance-Expense');
					}
				}, function(response){
					erroCallback(toaster,response);
				});
		}

		$scope.deleteExpense = function(index,update_expense){
			$http
				.get('/controller/remittance-expenses-report/' + update_expense.remittance_id + '/expenses/' + update_expense.id + '/delete')
				.then(function(response){
					if(response.data.success){
						$scope.remittance.expenses.splice(index,1);
						toaster.pop('success', 'Success', 'Successfuly Deleted Remittance-Expense');
					}
				});
		}

		$scope.next_cash_breakdown = function(){
			$scope.form.remittance = false;
			$scope.form.expenses = false;
			$scope.form.cash_breakdown = true;
		}

		//Cash Breakdown
		$scope.back_expenses =  function(){
			$scope.form.remittance = false;
			$scope.form.expenses = true;
			$scope.form.cash_breakdown = false;
		}

		$scope.breakDownTotalAmount = function(index,status,cash_breakdown){
			var denomination = (cash_breakdown.denomination == '' ? 0 : parseFloat(cash_breakdown.denomination));
			var pieces = (cash_breakdown.pieces == '' ? 0 : parseFloat(cash_breakdown.pieces));
			if(status == 'update'){
				$scope.remittance.cash_breakdown[index].amount = denomination * pieces;
			}

			if(status == 'create'){
				$scope.createCashBreakdown[index].amount = denomination * pieces;
			}
		}

		$scope.addCashBreakdown = function(){
			$scope.createCashBreakdown.push({
				denomination: '',
				pieces: '',
			});
		}

		$scope.removeCashBreakdown = function(index){
			$scope.createCashBreakdown.splice(index,1);
			if($scope.createCashBreakdown.length == 0){
				$scope.createCashBreakdown.push({
					denomination: '',
					pieces: '',
				});
			}
		}

		$scope.saveCashBreakdown = function(index,create_cash_breakdown,remittance_id){
			create_cash_breakdown.remittance_id = remittance_id;

			$http
				.post('/controller/remittance-expenses-report/' + remittance_id + '/cash-breakdown/create' ,create_cash_breakdown)
				.then(function(response){
					if(response.data.success){
						var cash_breakdown = [];
						if($scope.remittance.hasOwnProperty('cash_breakdown')){
							cash_breakdown = angular.copy($scope.remittance.cash_breakdown);
						}
						response.data.data.amount = parseFloat(create_cash_breakdown.denomination) * parseFloat(create_cash_breakdown.pieces);
						cash_breakdown.push(response.data.data);

						$scope.remittance.cash_breakdown = cash_breakdown;

						if(index == 0){
							$scope.createCashBreakdown[0].denomination = '';
							$scope.createCashBreakdown[0].pieces = '';
						} else {
							$scope.createCashBreakdown.splice(index,1);
						}
						angular.element('#create-amount-' + index).val('');
						toaster.pop('success', 'Success', 'Successfuly Created Remittance-Cash Breakdown');
					}
				}, function(response){
					erroCallback(toaster,response);
				});
		}

		$scope.updateCashBreakdown = function(index,update_cash_breakdown){
			$http
				.post('/controller/remittance-expenses-report/' + update_cash_breakdown.remittance_id + '/cash-breakdown/' + update_cash_breakdown.id + '/update' ,update_cash_breakdown)
				.then(function(response){
					if(response.data.success){
						$scope.remittance.cash_breakdown[index].denomination = update_cash_breakdown.denomination;
						$scope.remittance.cash_breakdown[index].pieces = update_cash_breakdown.pieces;
						toaster.pop('success', 'Success', 'Successfuly Updated Remittance-Cash Breakdown');
					}
				}, function(response){
					erroCallback(toaster,response);
				});
		}

		$scope.deleteCashBreakdown = function(index,update_cash_breakdown){
			$http
				.get('/controller/remittance-expenses-report/' + update_cash_breakdown.remittance_id + '/cash-breakdown/' + update_cash_breakdown.id + '/delete')
				.then(function(response){
					if(response.data.success){
						$scope.remittance.cash_breakdown.splice(index,1);
						toaster.pop('success', 'Success', 'Successfuly Deleted Remittance-Cash Breakdown');
					}
				});
		}

		$http
			.get('/controller/remittance-expenses-report/' + $routeParams.id)
			.then(function(response){
				$scope.remittance = response.data;

				angular.element('#form_salesman_code').val($scope.remittance.sr_salesman_code);
		        angular.element('#form_jr_salesman').val($scope.remittance.jr_salesman_code);
		        angular.element('#form_cash_amount').val($scope.remittance.cash_amount);
		        angular.element('#form_check_amount').val($scope.remittance.check_amount);
		        angular.element('#form_date_from').val($scope.remittance.date_from);
		        angular.element('#form_date_to').val($scope.remittance.date_to);
		        angular.element('#total_amount').val(sum());

				angular.forEach($scope.remittance.cash_breakdown, function(value, key) {
					$scope.remittance.cash_breakdown[key].amount = parseFloat($scope.remittance.cash_breakdown[key].denomination) * parseFloat($scope.remittance.cash_breakdown[key].pieces);
				});
			});
	}

	/**
	 * Error Callback
	 * @param  toaster
	 * @param  response
	 * @return show toaster message
	 */
	function erroCallback(toaster,response){
		if(response.status == 422){
			var error_list = '<ul>';
			angular.forEach(response.data, function(value, key) {
				error_list += '<li>' + value + '</li>';
			});
			error_list += '</ul>';
			toaster.pop({
		        type: 'error',
		        title: 'Error',
		        body: error_list,
		        bodyOutputType: 'trustedHtml'
			});
		}
	}
})();