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