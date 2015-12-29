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
	    var today = new Date();
	    $scope.dateValue = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();
	    $scope.dateFilter = [$scope.dateValue]; 
	    
	    // Filter flag
		$scope.toggleFilter = true;
		
		var report = 'vaninventorycanned';
		
		// Fetch table data from server
	    $scope.records = [];	    
	    
	    var API = $resource('/reports/getdata/'+report);
	    /*var filterDate = defaultDate;
	    if($('#transaction_date').val()){
	    	filterDate = $('#transaction_date').val();
	    }*/	    
	    
	    var params = {
	    		salesman: $('#salesman_code').val(),
	    		transaction_date: $scope.dateValue,
	    		status: $('#status').val(),
	    		inventory_type: $('#inventory_type').val()
	    };
	    $log.info(params);
	    
	    toggleLoading(true);
	    API.get(params,function(data){
	    	$scope.records = data.records;
	    	$scope.total = data.total;
	    	$scope.stocks = data.stocks;
	    	$scope.replenishment = data.replenishment;
	    	$log.info(data);	    	
	    	toggleLoading();
	    	togglePagination(data.total);
	    	$scope.showBody = data.total;
	    	$scope.showReplenishment = data.replenishment.total;
	    	
	    });	    	    
	    
	    params = [
		          'salesman_code',
		          'transaction_date',		          
		          'status',
		          'inventory_type'
		];
	    
	    //Sort table records
	    $scope.sortColumn = '';
		$scope.sortDirection = 'asc';
		sortColumn($scope,API,params,$log);
	    
	    // Filter table records	    		
		filterSubmitVanInventory($scope,API,params,$log);
		
	    // Paginate table records	    
	    pagination($scope,API,params,$log);
	    
	    // Download report
	    downloadReport($scope, $uibModal, $resource, $window, report, params, $log);	    
	    
	 // @Function
	    // Description  : Triggered while displaying expiry date in Customer Details screen.
	    $scope.formatDate = function(date){
	    	  if(!date) return '';
	          var dateOut = new Date(date);
	          return dateOut;
	    };
	    
	}
	
	/**
	 * Van & Inventory (Frozen) controller
	 */

	app.controller('VanInventoryFrozen',['$scope','$resource','$uibModal','$window','$log',VanInventoryFrozen]);
	
	function VanInventoryFrozen($scope, $resource, $uibModal, $window, $log)
	{	        
		var params = [
			          'salesman',
			          'transaction_date',		          
			          'status',
			          'inventory_type'
			];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'vaninventoryfrozen',params,$log); 

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
	    
	    //Edit table records
	    //var selectAPI = '/reports/getdata/conditioncodes';
	    var options = {GOOD:'GOOD',BAD:'BAD'};
	    editTable($scope, $uibModal, $resource, $window, options, $log);
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
	    
	    editTable($scope, $uibModal, $resource, $window, {}, $log);
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
	
	function Calendar($scope, $http, $log)
	{					
		$scope.dateFrom = null;
	    $scope.dateTo = null;
	    $log.info($('#default_value').val());

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
	function filterSubmitVanInventory(scope, API, filter, log)
	{
		var params = {};
		
		scope.filter = function(){
	    	
			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;
			
			var dateFrom = new Date($('#transaction_date_from').val());
			var dateTo = new Date($('#transaction_date_to').val());
			
			var dateRanges = getDates(dateFrom,dateTo);
			scope.dateFilter = dateRanges;
			scope.dateValue = getDates(dateFrom,dateTo).shift();
			log.info(scope.dateValue);
			
			$.each(filter, function(key,val){
				if(val == 'transaction_date')
					params[val] = scope.dateValue;
				else
					params[val] = $('#'+val).val();
			});			
			log.info(params);
			
			
			scope.toggleFilter = true;
			toggleLoading(true);
	    	API.save(params,function(data){
	    		togglePagination(data.total);
		    	scope.records = data.records;
		    	scope.total = data.total;
		    	scope.stocks = data.stocks;
		    	scope.replenishment = data.replenishment;
		    	scope.stock_on_hand = data.stock_on_hand;
		    	toggleLoading();
		    	log.info(data);	    	
		    	
		    	scope.showBody = data.total;
		    	scope.showReplenishment = data.replenishment.total;
		    	
		    });
	    	
	    }
		
		scope.filterDate = function(){
	    	
			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;
			
			scope.dateValue = $('#transaction_date').val();
			log.info(scope.dateValue);
			
			$.each(filter, function(key,val){
				if(val == 'transaction_date')
					params[val] = scope.dateValue;
				else
					params[val] = $('#'+val).val();
			});			
			log.info(params);
			
			
			scope.toggleFilter = true;
			toggleLoading(true);
	    	API.save(params,function(data){
	    		togglePagination(data.total);
		    	scope.records = data.records;
		    	scope.total = data.total;
		    	scope.stocks = data.stocks;
		    	scope.replenishment = data.replenishment;
		    	scope.stock_on_hand = data.stock_on_hand;
		    	toggleLoading();
		    	log.info(data);	    	
		    	scope.showBody = data.total;
		    	scope.showReplenishment = data.replenishment.total;
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
		}
	}
	
	
	/**
	 * Edit table records
	 */
	function editTable(scope, modal, resource, window, options, log)
	{
		
		scope.editColumn = function(type, table, column, id, value, index, name){
			
			var selectOptions = options;
			/*if(selectAPI)
			{
				log.info(selectAPI);
				var API = resource(selectAPI);
				API.get({},function(data){
					log.info(data);
					selectOptions = data.options;
				});
			}*/
			
			log.info(selectOptions);
			var params = {
					table: table,
					column: column,
					id: id,
					value: value,
					selectOptions: selectOptions,
					index: index,
					type: type,
					name: name
			};
			
			var template = '';
			switch(type)
			{
				case 'date':
					template = 'EditColumnDate';
					break;
				case 'select':
					template = 'EditColumnSelect';
					break;
				default:	
					template = 'EditColumnText';
					break;	
			}
			
			var modalInstance = modal.open({
			 	animation: true,
			 	scope: scope,
				templateUrl: template,
				controller: 'EditTableRecord',
				windowClass: 'center-modal',
				size: 'sm',
				resolve: {
					params: function () {
						return params;
				    }
				}
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
	    /*scope.tableHeaders = {};
	    resource('/reports/getheaders/'+report).query({}, function(data){
	    	scope.tableHeaders = data;
	    });*/
	    
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
	    
	 // @Function
	    // Description  : Triggered while displaying expiry date in Customer Details screen.
	    scope.formatDate = function(date){
	    	  if(!date) return '';	
	          var dateOut = new Date(date);
	          return dateOut;
	    };
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
	
	
	/**
	 * Edit Table record controller
	 */
	app.controller('EditTableRecord',['$scope','$uibModalInstance','$window','$resource','params','$log', EditTableRecord]);
	
	function EditTableRecord($scope, $uibModalInstance, $window, $resource, params, $log) {

		$scope.params = params;		
		$log.info($scope.$parent);
		
		$scope.save = function () {
			var API = $resource('controller/reports/save');
			if($scope.params.type == 'date')
			{
				var val = $scope.params.value;
				//$scope.params.value = $('#date_value').val() + " " + val.split(" ")[1];
				$scope.params.value = $('#date_value').val() + " " + val.split(" ")[1];
			}
			$log.info($scope.params);
			API.save($scope.params, function(data){
				$log.info(data);
				$log.info($scope.params.value);
				$scope.$parent.records[$scope.params.index][$scope.params.column] = $scope.params.value;
				$('#'+$scope.params.index).addClass('modified');				
			});
			
			$uibModalInstance.dismiss('cancel');
		};
		
		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
		
		/*$scope.getDate = function(date){
	          var dateOut = new Date(date);
	          return dateOut;
	    };*/
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
})();