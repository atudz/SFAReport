/**
 * Application controller list
 */

(function(){
	'use strict';

	/**
	 * Sales & Collection Report controller
	 */
	var app = angular.module('app');
	
	app.controller('SalesCollectionReport',['$scope','$resource','$log',SalesCollectionReport]);
	
	function SalesCollectionReport($scope, $resource, $log)
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
	    reportController($scope,$resource,'salescollectionreport',params,$log);
	    
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

	app.controller('SalesCollectionPosting',['$scope','$resource','$log',SalesCollectionPosting]);
	
	function SalesCollectionPosting($scope, $resource, $log)
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
	    reportController($scope,$resource,'salescollectionposting',params,$log);	   
	}
	
	
	/**
	 * Sales & Collection Summary controller
	 */

	app.controller('SalesCollectionSummary',['$scope','$resource','$log',SalesCollectionSummary]);
	
	function SalesCollectionSummary($scope, $resource, $log)
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
	    reportController($scope,$resource,'salescollectionsummary',params,$log);
	}
	
	/**
	 * Van & Inventory (Canned) controller
	 */

	app.controller('VanInventoryCanned',['$scope','$resource','$log',VanInventoryCanned]);
	
	function VanInventoryCanned($scope, $resource, $log)
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
	    reportController($scope,$resource,'vaninventory',params,$log);
	    
	}
	
	/**
	 * Van & Inventory (Frozen) controller
	 */

	app.controller('VanInventoryFrozen',['$scope','$resource','$log',VanInventoryFrozen]);
	
	function VanInventoryFrozen($scope, $resource, $log)
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
	    reportController($scope,$resource,'vaninventory',params,$log); 

	}
	
	
	/**
	 * Sales Report Per Material
	 */
	app.controller('SalesReportPerMaterial',['$scope','$resource','$log',SalesReportPerMaterial]);
	
	function SalesReportPerMaterial($scope, $resource, $log)
	{
		var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'customer_code',
		          'customer',
		          'material',
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,'salesreportpermaterial',params,$log);
	    
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
	app.controller('SalesReportPerPeso',['$scope','$resource','$log',SalesReportPerPeso]);
	
	function SalesReportPerPeso($scope, $resource, $log)
	{
		var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'customer_code',
		          'customer'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,'salesreportperpeso',params,$log);
	    
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
	app.controller('ReturnReportPerMaterial',['$scope','$resource','$log',ReturnReportPerMaterial]);
	
	function ReturnReportPerMaterial($scope, $resource, $log)
	{
	    var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'customer_code',
		          'material',
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,'returnreportpermaterial',params,$log);
	}
	
	
	/**
	 * Return Report Per Peso
	 */
	app.controller('ReturnReportPerPeso',['$scope','$resource','$log',ReturnReportPerPeso]);
	
	function ReturnReportPerPeso($scope, $resource, $log)
	{
	    var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'customer_code',
		          'material',
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,'returnreportperpeso',params,$log);
	}
	
	/**
	 * Customer List
	 */
	app.controller('CustomerList',['$scope','$resource','$log',CustomerList]);
	
	function CustomerList($scope, $resource, $log)
	{	    	    
	    var params = [
		          'salesman_code',
		          'area',
		          'status',
		          'sfa_modified_date'
		];
	    
	    // main controller
	    reportController($scope,$resource,'customerlist',params,$log);
	}
	
	
	/**
	 * Salesman List
	 */
	app.controller('SalesmanList',['$scope','$resource','$log',SalesmanList]);
	
	function SalesmanList($scope, $resource, $log)
	{
		var params = [
		          'salesman_code',
		          'area',
		          'status',
		          'sfa_modified_date'
		];
	    
	    // main controller
	    reportController($scope,$resource,'salesmanlist',params,$log);
	    
	}
	
	/**
	 * Material Price List
	 */
	app.controller('MaterialPriceList',['$scope','$resource','$log',MaterialPriceList]);
	
	function MaterialPriceList($scope, $resource, $log)
	{	
	    var params = [
		          'customer_code',
		          'area',
		          'segment_code',
		          'item_code',
		          'status',
		          'sfa_modified_date'
		];
	    
	    // main controller
	    reportController($scope,$resource,'materialpricelist',params,$log);
	 
	}
	
	/**
	 * Bir controller
	 */

	app.controller('Bir',['$scope','$resource','$log',Bir]);
	
	function Bir($scope, $resource, $log)
	{
			    
	    var params = [
		          'customer_code',
		          'area',
		          'segment_code',
		          'item_code',
		          'status',
		          'sfa_modified_date'
		];
	    
	    // main controller
	    reportController($scope,$resource,'bir',params,$log);
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
	 * Centralized controller codes
	 */
	function reportController(scope, resource, report, filter, log)
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
		}
		else
		{
			$('#pagination_div').removeClass('show');
		    $('#pagination_div').addClass('hidden');
		    
		}
		$('#no_records_div').toggle();
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
	
})();