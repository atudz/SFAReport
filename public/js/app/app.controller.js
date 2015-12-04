/**
 * Application controller list
 */

(function(){
	'use strict';

	/**
	 * Sales & Collection Report controller
	 */
	var app = angular.module('app');
	
	app.controller('SalesCollectionReport',['$scope','$http','$log',SalesCollectionReport]);
	
	function SalesCollectionReport($scope, $http, $log)
	{
		$http.get('/reports/getdata/salescollectionreport')
			.success(function(response){
				$scope.records = response.records;
		});
		
		
		$scope.update = function(data) {
			if(confirm('Are you sure you want to delete this record?'))
			{
				//var status = false;
				$http.post('/controller/reports/save',
							{table:'user', id:'1', column:'firstname', value:'Test123'}
				).success(function(response){
					$log.info(response);
					//status = true;
				});
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

	app.controller('SalesCollectionPosting',['$scope','$http','$log',SalesCollectionPosting]);
	
	function SalesCollectionPosting($scope, $http)
	{
		var scr = this;
		$http.get('/controller/reports/getdata/salescollectionposting')
			.success(function(response){
				$scope.records = response.records;
		});
	}
	
	
	/**
	 * Sales & Collection Summary controller
	 */

	app.controller('SalesCollectionSummary',['$scope','$http','$log',SalesCollectionSummary]);
	
	function SalesCollectionSummary($scope, $http)
	{
		var scr = this;
		$http.get('/controller/reports/getdata/salescollectionsummary')
			.success(function(response){
				$scope.records = response.records;
		});
	}
	
	
	/**
	 * Filter Controller
	 */
	app.controller('Filter',['$scope','$http','$log', FilterOptions]);
	
	function FilterOptions($scope, $http)
	{
		$scope.toggleFilter = false;

		$scope.dateFrom = null;
	    $scope.dateTo = null;

	    // Disable weekend selection
		$scope.disabled = function(date, mode) {
		    return ( mode === 'day' && ( date.getDay() === 0 || date.getDay() === 6 ) );
		};

		  
		$scope.maxDate = new Date(2020, 5, 22);

		$scope.open = function($event, elementId) {
		    $scope[elementId] = true;
		};

		$scope.dateOptions = {
		    formatYear: 'yy',
		    startingDay: 0
		};

		$scope.format = 'yyyy/MM/dd';
			  
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