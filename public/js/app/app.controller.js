/**
 * Application controller list
 */

(function(){
	'use strict';

	/**
	 * Sales & Collection Report controller
	 */

	angular.module('app')
		.controller('SalesCollectionReport',['$scope','$http','$log',SalesCollectionReport]);
	
	function SalesCollectionReport($scope, $http)
	{
		var scr = this;
		$http.get('/reports/getdata/salescollectionreport')
			.success(function(response){
				$scope.records = response.records;
		});
	}
	
	
	/**
	 * Sales & Collection Posting controller
	 */

	angular.module('app')
		.controller('SalesCollectionPosting',['$scope','$http','$log',SalesCollectionPosting]);
	
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

	angular.module('app')
		.controller('SalesCollectionSummary',['$scope','$http','$log',SalesCollectionSummary]);
	
	function SalesCollectionSummary($scope, $http)
	{
		var scr = this;
		$http.get('/controller/reports/getdata/salescollectionsummary')
			.success(function(response){
				$scope.records = response.records;
		});
	}
	
})();