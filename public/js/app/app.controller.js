/**
 * Application controller list
 */

(function(){
	'use strict';

	/**
	 * Sales & Collection Report controller
	 */
	var app = angular.module('app');
	
	app.controller('SalesCollectionReport',['$scope','$resource','$uibModal','$window','$log',SalesCollectionReport]);
	
	function SalesCollectionReport($scope, $resource, $uibModal, $window, $log)
	{	    	
	    var params = [
		          'customer_code',
		          'invoice_date_from',
		          'invoice_date_to',
		          'collection_date_from',
		          'collection_date_to',
		          'posting_date_from',
		          'posting_date_to'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'salescollectionreport',params,$log);
	    
	    // Update table records
		$scope.update = function(data) {
			if(confirm('Is this correct?'))
			{
				//var status = false;
				/*$http.post('/controller/reports/save',
							{table:'user', id:'1', column:'firstname', value:'Test123'}
				).success(function(response){
					$log.info(response);
					//status = true;
				});*/
				//alert(status);
				return true;
			}
			else
			{
				return false;
			}
		};
		
	}
	
	
	/**
	 * Sales & Collection Posting controller
	 */

	app.controller('SalesCollectionPosting',['$scope','$resource','$uibModal','$window','$log',SalesCollectionPosting]);
	
	function SalesCollectionPosting($scope, $resource, $uibModal, $window, $log)
	{		
	    var params = [
		          'customer_code',
		          'invoice_date_from',
		          'invoice_date_to',
		          'collection_date_from',
		          'collection_date_to',
		          'posting_date_from',
		          'posting_date_to'
		];
	    
	    // main controller 
	    reportController($scope,$resource,$uibModal,$window,'salescollectionposting',params,$log);	   
	}
	
	
	/**
	 * Sales & Collection Summary controller
	 */

	app.controller('SalesCollectionSummary',['$scope','$resource','$uibModal','$window','$log',SalesCollectionSummary]);
	
	function SalesCollectionSummary($scope, $resource, $uibModal, $window, $log)
	{
	    var params = [
		          'customer_code',
		          'invoice_date_from',
		          'invoice_date_to',
		          'collection_date_from',
		          'collection_date_to',
		          'posting_date_from',
		          'posting_date_to'
		];
	    
	    // main controller 
	    reportController($scope,$resource,$uibModal,$window,'salescollectionsummary',params,$log);
	}
	
	/**
	 * Van & Inventory (Canned) controller
	 */

	app.controller('VanInventoryCanned',['$scope','$resource','$uibModal','$window','$log',VanInventoryCanned]);
	
	function VanInventoryCanned($scope, $resource, $uibModal, $window, $log)
	{	
	    var params = [
		          'customer_code',
		          'invoice_date_from',
		          'invoice_date_to',
		          'collection_date_from',
		          'collection_date_to',
		          'posting_date_from',
		          'posting_date_to',
		          'inventory_type'
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'vaninventory',params,$log);
	    
	}
	
	/**
	 * Van & Inventory (Frozen) controller
	 */

	app.controller('VanInventoryFrozen',['$scope','$resource','$uibModal','$window','$log',VanInventoryFrozen]);
	
	function VanInventoryFrozen($scope, $resource, $uibModal, $window, $log)
	{	        
	    var params = [
		          'customer_code',
		          'invoice_date_from',
		          'invoice_date_to',
		          'collection_date_from',
		          'collection_date_to',
		          'posting_date_from',
		          'posting_date_to'
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'vaninventory',params,$log); 

	}
	
	
	/**
	 * Unpaid Report
	 */
	app.controller('Unpaid',['$scope','$resource','$uibModal','$window','$log',Unpaid]);
	
	function Unpaid($scope, $resource, $uibModal, $window, $log)
	{
		var params = [
			          'company_code',
			          'invoice_date_from',
			          'invoice_date_to',
			          'salesman',
			          'customer'
			];
		    
		    // main controller
		    reportController($scope,$resource,$uibModal,$window,'unpaid',params,$log);
	}
	
	/**
	 * Sales Report Per Material
	 */
	app.controller('SalesReportPerMaterial',['$scope','$resource','$uibModal','$window','$log',SalesReportPerMaterial]);
	
	function SalesReportPerMaterial($scope, $resource, $uibModal, $window, $log)
	{
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
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'salesreportpermaterial',params,$log);
	    
	    var API = '';
	    $scope.conditionCodes = function(){
	    	API = $resource('/reports/getdata/conditioncodes');
	    	API.get({},function(data){
		    	$scope.codes = data;
		    	$log.info(data);
		    });
	    }
	    
	    // Update table records
		$scope.update = function(data,object) {
			if(confirm('Is this correct?'))
			{
				$log.info(object);
				//var status = false;
				/*$http.post('/controller/reports/save',
							{table:'user', id:'1', column:'firstname', value:'Test123'}
				).success(function(response){
					$log.info(response);
					//status = true;
				});*/
				//alert(status);
				return true;
			}
			else
			{
				return false;
			}
		};	
		
	}

	/**
	 * Sales Report Per Peso
	 */
	app.controller('SalesReportPerPeso',['$scope','$resource','$uibModal','$window','$log',SalesReportPerPeso]);
	
	function SalesReportPerPeso($scope, $resource, $uibModal, $window, $log)
	{
		var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'company_code',
		          'customer'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'salesreportperpeso',params,$log);
	    
		 // Update table records
		$scope.update = function(data) {
			if(confirm('Is this correct?'))
			{
				$log.info(data);
				//var status = false;
				/*$http.post('/controller/reports/save',
							{table:'user', id:'1', column:'firstname', value:'Test123'}
				).success(function(response){
					$log.info(response);
					//status = true;
				});*/
				//alert(status);
				return true;
			}
			else
			{
				return false;
			}
		};
	}
	
	
	/**
	 * Return Report Per Material
	 */
	app.controller('ReturnReportPerMaterial',['$scope','$resource','$uibModal','$window','$log',ReturnReportPerMaterial]);
	
	function ReturnReportPerMaterial($scope, $resource, $uibModal, $window, $log)
	{
	    var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'company_code',
		          'material',
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'returnpermaterial',params,$log);
	}
	
	
	/**
	 * Return Report Per Peso
	 */
	app.controller('ReturnReportPerPeso',['$scope','$resource','$uibModal','$window','$log',ReturnReportPerPeso]);
	
	function ReturnReportPerPeso($scope, $resource, $uibModal, $window, $log)
	{
	    var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'company_code',
		          'material',
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'returnperpeso',params,$log);
	}
	
	/**
	 * Customer List
	 */
	app.controller('CustomerList',['$scope','$resource','$uibModal','$window','$log',CustomerList]);
	
	function CustomerList($scope, $resource, $uibModal, $window, $log)
	{	    	    
	    var params = [
		          'salesman_code',
		          'area',
		          'status',
		          'company_code',
		          'sfa_modified_date_from',
		          'sfa_modified_date_to',
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'customerlist',params,$log);
	}
	
	
	/**
	 * Salesman List
	 */
	app.controller('SalesmanList',['$scope','$resource','$uibModal','$window','$log',SalesmanList]);
	
	function SalesmanList($scope, $resource, $uibModal, $window, $log)
	{
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
	app.controller('MaterialPriceList',['$scope','$resource','$uibModal','$window','$log',MaterialPriceList]);
	
	function MaterialPriceList($scope, $resource, $uibModal, $window, $log)
	{	
	    var params = [
		          'company_code',
		          'area',
		          'segment_code',
		          'item_code',
		          'status',
		          'sfa_modified_date_from',
		          'sfa_modified_date_to'
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'materialpricelist',params,$log);
	 
	}
	
	/**
	 * Bir controller
	 */

	app.controller('Bir',['$scope','$resource','$uibModal','$window','$log',Bir]);
	
	function Bir($scope, $resource, $uibModal, $window, $log)
	{
			    
	    var params = [
		          'customer_code',
		          'area',
		          'segment_code',
		          'item_code',
		          'status',
		          'sfa_modified_date_from',
		          'sfa_modified_date_to'
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'bir',params,$log);
	}

	
	/**
	 * Date Input Controller
	 */
	app.controller('Calendar',['$scope','$http','$log', Calendar]);
	
	function Calendar($scope, $http)
	{
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

		$scope.format = 'yyyy/MM/dd';
			  
	}

	
	/**
	 * Centralized filter function
	 */
	function filterSubmit(scope, API, filter, log)
	{
		var params = {};
		
		scope.filter = function(){
	    	
			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;
			
			$.each(filter, function(key,val){
				params[val] = $('#'+val).val();
			});
			log.info(filter);
			
			scope.toggleFilter = true;
			toggleLoading(true);
	    	API.save(params,function(data){
	    		log.info(data);
	    		togglePagination(data.total);
		    	scope.records = data.records;
		    	scope.total = data.total;
		    	toggleLoading();
		    });
	    	
	    }
		
		scope.reset = function(){
	    	
			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;
			
			$.each(filter, function(key,val){
				params[val] = '';
			});
			log.info(filter);
			
			scope.toggleFilter = true;
			toggleLoading(true);
	    	API.save(params,function(data){
	    		log.info(data);
	    		togglePagination(data.total);
		    	scope.records = data.records;		    			    	
		    	toggleLoading();
		    });
	    	
	    }
	}
	
	/**
	 * Centralized method for sorting
	 */
	function sortColumn(scope, API, filter, log)
	{
		var params = {};
		
		scope.sort = function(col) {
			scope.sortColumn = col;
			var el = $('#'+col);
			
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
			log.info(params);

			scope.toggleFilter = true;
			toggleLoading(true);
			API.save(params, function(data){
				log.info(data);
				scope.records = data.records;		    	
		    	scope.toggleFilter = true;
		    	toggleLoading();
			});
		}
	}
	
	/**
	 * Centralized pagination function
	 */
	function pagination(scope, API, filter, log)
	{
		var params  = {};
		
		scope.page = 1;
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
			log.info(params);
			
			toggleLoading(true);
			API.save(params, function(data){
				log.info(data);
				scope.records = data.records;		    	
		    	scope.toggleFilter = true;
		    	toggleLoading();
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
	    		scope.page = scope.total/scope.perpage;
	    		request = true;
	    	}
	    	else if((scope.page + increment > 0 && scope.page!=(scope.total/scope.perpage))
	    			|| (increment < 0 && scope.page > 1))
	    	{
	    		scope.page = scope.page + increment;
	    		request = true;
	    	}	
	    	if(request)
	    	{
	    		toggleLoading(true);
	    		params = {page:scope.page,page_limit:scope.perpage};
				API.save(params, function(data){
					log.info(data);
					scope.records = data.records;					
			    	scope.toggleFilter = true;
			    	toggleLoading();
				});
	    	}
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
			$.each(filter, function(index,val){
				if(index > 0)
					delimeter = '&';
				query += delimeter + val + '=' + $('#'+val).val();				
			});
			url += query;
			log.info(url);
			
			var API = resource(url);
			API.get({}, function(data){
			
				log.info(data);
				if(!data.total)
				{
					window.alert('No records to export.');
				}
				else if(data.max_limit)
				{
					scope.params = {
							chunks: data.staggered,
							title: 'Export ' + angular.uppercase(type),
							limit: data.limit,
							exportType: type,
							report: report,
							filter: filter
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
					 window.location.href = '/reports/export/'+type+'/'+report+query;
				}
			});
		}	
	}
	
	/**
	 * Centralized controller codes
	 */
	function reportController(scope, resource, modal, window, report, filter, log)
	{
		// Filter flag
		scope.toggleFilter = true;
		
		// Fetch table headers from server
	    scope.tableHeaders = {};
	    resource('/reports/getheaders/'+report).query({}, function(data){
	    	scope.tableHeaders = data;
	    });
	    
	    // Fetch table data from server
	    scope.records = [];	    
	    
	    var API = resource('/reports/getdata/'+report);
	    var params = {};
	    
	    toggleLoading(true);
	    API.get(params,function(data){
	    	scope.records = data.records;
	    	scope.total = data.total;
	    	log.info(data);
	    	toggleLoading();
	    	togglePagination(data.total);
	    });	    	    
	    
	    params = filter;
	    
	    //Sort table records
	    scope.sortColumn = '';
		scope.sortDirection = 'asc';
		sortColumn(scope,API,params,log);
	    
	    // Filter table records	    
	    filterSubmit(scope,API,params,log);
		
	    // Paginate table records	    
	    pagination(scope,API,params,log);
	    
	    // Download report
	    downloadReport(scope, modal, resource, window, report, filter, log);
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
		}
		else
		{
			$('#pagination_div').removeClass('show');
		    $('#pagination_div').addClass('hidden');
		    $('#no_records_div').show();
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
	app.controller('ExportReport',['$scope','$uibModalInstance','$window','params','$log', ExportReport]);
	
	function ExportReport($scope, $uibModalInstance, $window, params, $log) {

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
			$log.info(url);
			$window.location.href = url;
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	};
	
})();