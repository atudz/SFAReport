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
	    // Filter flag
		$scope.toggleFilter = true;
		
		// Fetch table headers from server
	    $scope.tableHeaders = {};
	    $resource('/reports/getheaders/salescollectionreport').query({}, function(data){
	    	$scope.tableHeaders = data;
	    });
	    
	    // Fetch table data from server
	    $scope.records = {};	    
	    
	    var API = $resource('/reports/getdata/salescollectionreport');
	    var params = {page:'1',page_limit:'10'};
	    
	    API.save(params,function(data){
	    	$scope.records = data.records;
	    	$log.info($scope.records);
	    });	    
	    
	    
	    // Filter table records
	    $scope.filter = function(){
	    	
	    	params = {
	    		customer_code: $('#customer_code').val(),
	    		invoice_date_from: $('#invoice_date_from').val(),
	    		invoice_date_to: $('#invoice_date_to').val(),
	    		collection_date_from: $('#collection_date_from').val(),
	    		collection_date_to: $('#collection_date_to').val(),
	    		posting_date_from: $('#posting_date_from').val(),
	    		posting_date_to: $('#posting_date_to').val(),
	    		page:$scope.page,
	    		page_limit:$scope.perpage,
    			sort:$scope.sortColumn,
    			order:$scope.sortDirection
	    	};
	    	API.save(params,function(data){
	    		$log.info(data);
		    	$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
		    });
	    	
	    }
	    
	    // Paginate table records
	    $scope.page = 1;
	    $scope.perpage = 10;
	    $scope.total = 100;
	    $scope.paginate = function(page) {
			$scope.perpage = page;
			$scope.page = 1;
			$('#limit'+page).parent().parent().find('.active').removeClass('active');
			$('#limit'+page).parent().addClass('active');
			
			params = {
		    		customer_code: $('#customer_code').val(),
		    		invoice_date_from: $('#invoice_date_from').val(),
		    		invoice_date_to: $('#invoice_date_to').val(),
		    		collection_date_from: $('#collection_date_from').val(),
		    		collection_date_to: $('#collection_date_to').val(),
		    		posting_date_from: $('#posting_date_from').val(),
		    		posting_date_to: $('#posting_date_to').val(),
		    		page:$scope.page,
		    		page_limit:$scope.perpage,
	    			sort:$scope.sortColumn,
	    			order:$scope.sortDirection
		    };
			API.save(params, function(data){
				$log.info(data);
				$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
			});
		}
	    
	    // Pager table records
	    $scope.pager = function(increment,first,last) {
	    	var request = false;
	    	if(first)
	    	{
	    		$scope.page = 1;
	    		request = true;
	    	}
	    	else if(last)
	    	{
	    		$scope.page = $scope.total/$scope.perpage;
	    		request = true;
	    	}
	    	else if(($scope.page + increment > 0 && $scope.page!=($scope.total/$scope.perpage))
	    			|| (increment < 0 && $scope.page > 1))
	    	{
	    		$scope.page = $scope.page + increment;
	    		request = true;
	    	}	
	    	if(request)
	    	{
	    		params = {
	    	    		customer_code: $('#customer_code').val(),
	    	    		invoice_date_from: $('#invoice_date_from').val(),
	    	    		invoice_date_to: $('#invoice_date_to').val(),
	    	    		collection_date_from: $('#collection_date_from').val(),
	    	    		collection_date_to: $('#collection_date_to').val(),
	    	    		posting_date_from: $('#posting_date_from').val(),
	    	    		posting_date_to: $('#posting_date_to').val(),
	    	    		page:$scope.page,
	    	    		page_limit:$scope.perpage,
	        			sort:$scope.sortColumn,
	        			order:$scope.sortDirection
	    	    };
				API.save(params, function(data){
					$log.info(data);
					$scope.records = data.records;		    	
			    	$scope.toggleFilter = true;
				});
	    	}
		}
	    
	    // Update table records
		$scope.update = function(data) {
			if(confirm('Are you sure you want to delete this record?'))
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
		
		
		// Sort table records
		$scope.sortColumn = '';
		$scope.sortDirection = 'asc';
		$scope.sort = function(col) {
			$scope.sortColumn = col;
			var el = $('#'+col);
			
			el.parent().find('th').removeClass('sorted');
			el.parent().find('th>i').removeClass('fa-sort-asc');
			el.parent().find('th>i').removeClass('fa-sort-desc');
			el.parent().find('th>i').addClass('fa-sort');
			
			if($scope.sortDirection == 'desc')
			{					
				el.addClass('sorted');
				el.find('i').addClass('fa-sort-asc');				
				$scope.sortDirection = 'asc';
			}
			else
			{				
				el.addClass('sorted');
				el.find('i').addClass('fa-sort-desc');
				$scope.sortDirection = 'desc';
			}			
			
			params = {
		    		customer_code: $('#customer_code').val(),
		    		invoice_date_from: $('#invoice_date_from').val(),
		    		invoice_date_to: $('#invoice_date_to').val(),
		    		collection_date_from: $('#collection_date_from').val(),
		    		collection_date_to: $('#collection_date_to').val(),
		    		posting_date_from: $('#posting_date_from').val(),
		    		posting_date_to: $('#posting_date_to').val(),
		    		page:$scope.page,
		    		page_limit:$scope.perpage,
	    			sort:$scope.sortColumn,
	    			order:$scope.sortDirection
		    };
			API.save(params, function(data){
				$log.info(data);
				$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
			});
		}
	}
	
	
	/**
	 * Sales & Collection Posting controller
	 */

	app.controller('SalesCollectionPosting',['$scope','$resource','$log',SalesCollectionPosting]);
	
	function SalesCollectionPosting($scope, $resource, $log)
	{
		// Filter flag
		$scope.toggleFilter = true;
		
		// Fetch table headers from server
	    $scope.tableHeaders = {};
	    $resource('/reports/getheaders/salescollectionreport').query({}, function(data){
	    	$scope.tableHeaders = data;
	    });
	    
	    // Fetch table data from server
	    $scope.records = {};	    
	    
	    var API = $resource('/reports/getdata/salescollectionreport');
	    var params = {page:'1',page_limit:'10'};
	    
	    API.save(params,function(data){
	    	$scope.records = data.records;
	    	$log.info($scope.records);
	    });	    
	    
	    
	    // Filter table records
	    $scope.filter = function(){
	    	
	    	params = {
	    		customer_code: $('#customer_code').val(),
	    		invoice_date_from: $('#invoice_date_from').val(),
	    		invoice_date_to: $('#invoice_date_to').val(),
	    		collection_date_from: $('#collection_date_from').val(),
	    		collection_date_to: $('#collection_date_to').val(),
	    		posting_date_from: $('#posting_date_from').val(),
	    		posting_date_to: $('#posting_date_to').val(),
	    		page:$scope.page,
	    		page_limit:$scope.perpage
	    	};
	    	API.save(params,function(data){
	    		$log.info(data);
		    	$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
		    });
	    	
	    }
	    
	    // Paginate table records
	    $scope.page = 1;
	    $scope.perpage = 10;
	    $scope.total = 100;
	    $scope.paginate = function(page) {
			$scope.perpage = page;
			$scope.page = 1;
			$('#limit'+page).parent().parent().find('.active').removeClass('active');
			$('#limit'+page).parent().addClass('active');
			
			params = {page:$scope.page,page_limit:$scope.perpage};
			API.save(params, function(data){
				$log.info(data);
				$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
			});
		}
	    
	    // Pager table records
	    $scope.pager = function(increment,first,last) {
	    	var request = false;
	    	if(first)
	    	{
	    		$scope.page = 1;
	    		request = true;
	    	}
	    	else if(last)
	    	{
	    		$scope.page = $scope.total/$scope.perpage;
	    		request = true;
	    	}
	    	else if(($scope.page + increment > 0 && $scope.page!=($scope.total/$scope.perpage))
	    			|| (increment < 0 && $scope.page > 1))
	    	{
	    		$scope.page = $scope.page + increment;
	    		request = true;
	    	}	
	    	if(request)
	    	{
	    		params = {page:$scope.page,page_limit:$scope.perpage};
				API.save(params, function(data){
					$log.info(data);
					$scope.records = data.records;		    	
			    	$scope.toggleFilter = true;
				});
	    	}
		}
	}
	
	
	/**
	 * Sales & Collection Summary controller
	 */

	app.controller('SalesCollectionSummary',['$scope','$resource','$log',SalesCollectionSummary]);
	
	function SalesCollectionSummary($scope, $resource, $log)
	{
		// Filter flag
		$scope.toggleFilter = true;
		
		// Fetch table headers from server
	    $scope.tableHeaders = {};
	    $resource('/reports/getheaders/salescollectionreport').query({}, function(data){
	    	$scope.tableHeaders = data;
	    });
	    
	    // Fetch table data from server
	    $scope.records = {};	    
	    
	    var API = $resource('/reports/getdata/salescollectionreport');
	    var params = {page:'1',page_limit:'10'};
	    
	    API.save(params,function(data){
	    	$scope.records = data.records;
	    	$log.info($scope.records);
	    });	    
	    
	    
	    // Filter table records
	    $scope.filter = function(){
	    	
	    	params = {
	    		customer_code: $('#customer_code').val(),
	    		invoice_date_from: $('#invoice_date_from').val(),
	    		invoice_date_to: $('#invoice_date_to').val(),
	    		collection_date_from: $('#collection_date_from').val(),
	    		collection_date_to: $('#collection_date_to').val(),
	    		posting_date_from: $('#posting_date_from').val(),
	    		posting_date_to: $('#posting_date_to').val(),
	    		page:$scope.page,
	    		page_limit:$scope.perpage
	    	};
	    	API.save(params,function(data){
	    		$log.info(data);
		    	$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
		    });
	    	
	    }
	    
	    // Paginate table records
	    $scope.page = 1;
	    $scope.perpage = 10;
	    $scope.total = 100;
	    $scope.paginate = function(page) {
			$scope.perpage = page;
			$scope.page = 1;
			$('#limit'+page).parent().parent().find('.active').removeClass('active');
			$('#limit'+page).parent().addClass('active');
			
			params = {page:$scope.page,page_limit:$scope.perpage};
			API.save(params, function(data){
				$log.info(data);
				$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
			});
		}
	    
	    // Pager table records
	    $scope.pager = function(increment,first,last) {
	    	var request = false;
	    	if(first)
	    	{
	    		$scope.page = 1;
	    		request = true;
	    	}
	    	else if(last)
	    	{
	    		$scope.page = $scope.total/$scope.perpage;
	    		request = true;
	    	}
	    	else if(($scope.page + increment > 0 && $scope.page!=($scope.total/$scope.perpage))
	    			|| (increment < 0 && $scope.page > 1))
	    	{
	    		$scope.page = $scope.page + increment;
	    		request = true;
	    	}	
	    	if(request)
	    	{
	    		params = {page:$scope.page,page_limit:$scope.perpage};
				API.save(params, function(data){
					$log.info(data);
					$scope.records = data.records;		    	
			    	$scope.toggleFilter = true;
				});
	    	}
		}
	}
	
	/**
	 * Van & Inventory (Canned) controller
	 */

	app.controller('VanInventoryCanned',['$scope','$resource','$log',VanInventoryCanned]);
	
	function VanInventoryCanned($scope, $resource, $log)
	{
		// Filter flag
		$scope.toggleFilter = true;
		
		// Fetch table headers from server
	    $scope.tableHeaders = {};
	    $resource('/reports/getheaders/salescollectionreport').query({}, function(data){
	    	$scope.tableHeaders = data;
	    });
	    
	    // Fetch table data from server
	    $scope.records = {};	    
	    
	    var API = $resource('/reports/getdata/salescollectionreport');
	    var params = {page:'1',page_limit:'10'};
	    
	    API.save(params,function(data){
	    	$scope.records = data.records;
	    	$log.info($scope.records);
	    });	    
	    
	    
	    // Filter table records
	    $scope.filter = function(){
	    	
	    	params = {
	    		customer_code: $('#customer_code').val(),
	    		invoice_date_from: $('#invoice_date_from').val(),
	    		invoice_date_to: $('#invoice_date_to').val(),
	    		collection_date_from: $('#collection_date_from').val(),
	    		collection_date_to: $('#collection_date_to').val(),
	    		posting_date_from: $('#posting_date_from').val(),
	    		posting_date_to: $('#posting_date_to').val(),
	    		page:$scope.page,
	    		page_limit:$scope.perpage
	    	};
	    	API.save(params,function(data){
	    		$log.info(data);
		    	$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
		    });
	    	
	    }
	    
	    // Paginate table records
	    $scope.page = 1;
	    $scope.perpage = 10;
	    $scope.total = 100;
	    $scope.paginate = function(page) {
			$scope.perpage = page;
			$scope.page = 1;
			$('#limit'+page).parent().parent().find('.active').removeClass('active');
			$('#limit'+page).parent().addClass('active');
			
			params = {page:$scope.page,page_limit:$scope.perpage};
			API.save(params, function(data){
				$log.info(data);
				$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
			});
		}
	    
	    // Pager table records
	    $scope.pager = function(increment,first,last) {
	    	var request = false;
	    	if(first)
	    	{
	    		$scope.page = 1;
	    		request = true;
	    	}
	    	else if(last)
	    	{
	    		$scope.page = $scope.total/$scope.perpage;
	    		request = true;
	    	}
	    	else if(($scope.page + increment > 0 && $scope.page!=($scope.total/$scope.perpage))
	    			|| (increment < 0 && $scope.page > 1))
	    	{
	    		$scope.page = $scope.page + increment;
	    		request = true;
	    	}	
	    	if(request)
	    	{
	    		params = {page:$scope.page,page_limit:$scope.perpage};
				API.save(params, function(data){
					$log.info(data);
					$scope.records = data.records;		    	
			    	$scope.toggleFilter = true;
				});
	    	}
		}
	}
	
	/**
	 * Van & Inventory (Frozen) controller
	 */

	app.controller('VanInventoryFrozen',['$scope','$resource','$log',VanInventoryFrozen]);
	
	function VanInventoryFrozen($scope, $resource, $log)
	{
		// Filter flag
		$scope.toggleFilter = true;
		
		// Fetch table headers from server
	    $scope.tableHeaders = {};
	    $resource('/reports/getheaders/salescollectionreport').query({}, function(data){
	    	$scope.tableHeaders = data;
	    });
	    
	    // Fetch table data from server
	    $scope.records = {};	    
	    
	    var API = $resource('/reports/getdata/salescollectionreport');
	    var params = {page:'1',page_limit:'10'};
	    
	    API.save(params,function(data){
	    	$scope.records = data.records;
	    	$log.info($scope.records);
	    });	    
	    
	    
	    // Filter table records
	    $scope.filter = function(){
	    	
	    	params = {
	    		customer_code: $('#customer_code').val(),
	    		invoice_date_from: $('#invoice_date_from').val(),
	    		invoice_date_to: $('#invoice_date_to').val(),
	    		collection_date_from: $('#collection_date_from').val(),
	    		collection_date_to: $('#collection_date_to').val(),
	    		posting_date_from: $('#posting_date_from').val(),
	    		posting_date_to: $('#posting_date_to').val(),
	    		page:$scope.page,
	    		page_limit:$scope.perpage
	    	};
	    	API.save(params,function(data){
	    		$log.info(data);
		    	$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
		    });
	    	
	    }
	    
	    // Paginate table records
	    $scope.page = 1;
	    $scope.perpage = 10;
	    $scope.total = 100;
	    $scope.paginate = function(page) {
			$scope.perpage = page;
			$scope.page = 1;
			$('#limit'+page).parent().parent().find('.active').removeClass('active');
			$('#limit'+page).parent().addClass('active');
			
			params = {page:$scope.page,page_limit:$scope.perpage};
			API.save(params, function(data){
				$log.info(data);
				$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
			});
		}
	    
	    // Pager table records
	    $scope.pager = function(increment,first,last) {
	    	var request = false;
	    	if(first)
	    	{
	    		$scope.page = 1;
	    		request = true;
	    	}
	    	else if(last)
	    	{
	    		$scope.page = $scope.total/$scope.perpage;
	    		request = true;
	    	}
	    	else if(($scope.page + increment > 0 && $scope.page!=($scope.total/$scope.perpage))
	    			|| (increment < 0 && $scope.page > 1))
	    	{
	    		$scope.page = $scope.page + increment;
	    		request = true;
	    	}	
	    	if(request)
	    	{
	    		params = {page:$scope.page,page_limit:$scope.perpage};
				API.save(params, function(data){
					$log.info(data);
					$scope.records = data.records;		    	
			    	$scope.toggleFilter = true;
				});
	    	}
		}
	}
	
	/**
	 * Bir controller
	 */

	app.controller('Bir',['$scope','$resource','$log',Bir]);
	
	function Bir($scope, $resource, $log)
	{
		// Filter flag
		$scope.toggleFilter = true;
		
		// Fetch table headers from server
	    $scope.tableHeaders = {};
	    $resource('/reports/getheaders/salescollectionreport').query({}, function(data){
	    	$scope.tableHeaders = data;
	    });
	    
	    // Fetch table data from server
	    $scope.records = {};	    
	    
	    var API = $resource('/reports/getdata/salescollectionreport');
	    var params = {page:'1',page_limit:'10'};
	    
	    API.save(params,function(data){
	    	$scope.records = data.records;
	    	$log.info($scope.records);
	    });	    
	    
	    
	    // Filter table records
	    $scope.filter = function(){
	    	
	    	params = {
	    		customer_code: $('#customer_code').val(),
	    		invoice_date_from: $('#invoice_date_from').val(),
	    		invoice_date_to: $('#invoice_date_to').val(),
	    		collection_date_from: $('#collection_date_from').val(),
	    		collection_date_to: $('#collection_date_to').val(),
	    		posting_date_from: $('#posting_date_from').val(),
	    		posting_date_to: $('#posting_date_to').val(),
	    		page:$scope.page,
	    		page_limit:$scope.perpage
	    	};
	    	API.save(params,function(data){
	    		$log.info(data);
		    	$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
		    });
	    	
	    }
	    
	    // Paginate table records
	    $scope.page = 1;
	    $scope.perpage = 10;
	    $scope.total = 100;
	    $scope.paginate = function(page) {
			$scope.perpage = page;
			$scope.page = 1;
			$('#limit'+page).parent().parent().find('.active').removeClass('active');
			$('#limit'+page).parent().addClass('active');
			
			params = {page:$scope.page,page_limit:$scope.perpage};
			API.save(params, function(data){
				$log.info(data);
				$scope.records = data.records;		    	
		    	$scope.toggleFilter = true;
			});
		}
	    
	    // Pager table records
	    $scope.pager = function(increment,first,last) {
	    	var request = false;
	    	if(first)
	    	{
	    		$scope.page = 1;
	    		request = true;
	    	}
	    	else if(last)
	    	{
	    		$scope.page = $scope.total/$scope.perpage;
	    		request = true;
	    	}
	    	else if(($scope.page + increment > 0 && $scope.page!=($scope.total/$scope.perpage))
	    			|| (increment < 0 && $scope.page > 1))
	    	{
	    		$scope.page = $scope.page + increment;
	    		request = true;
	    	}	
	    	if(request)
	    	{
	    		params = {page:$scope.page,page_limit:$scope.perpage};
				API.save(params, function(data){
					$log.info(data);
					$scope.records = data.records;		    	
			    	$scope.toggleFilter = true;
				});
	    	}
		}
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

	
})();