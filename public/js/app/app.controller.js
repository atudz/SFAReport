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
		$http.get('/controller/reports/getdata/salescollectionreport')
			.success(function(response){
				$scope.records = response.records;
		});
	}
	
	
	/**
	 * Sales & Collection controller
	 */

	angular.module('app')
		.controller('SalesCollectionReport',['$scope','$http','$log',SalesCollectionReport]);
	
	function SalesCollectionReport($scope, $http)
	{
		var scr = this;
		$http.get('/controller/reports/getdata/salescollectionreport')
			.success(function(response){
				$scope.records = response.records;
		});
	}
	
})();