/**
 * Sales & Collection controller
 */

(function(){
	'use strict';
	
	angular.module('app')
		.controller('SalesCollectionReport',['$http','$log']);
	
	function SalesCollectionReport($http, $log)
	{
		var scr = this;
		$http.get('/controller/reports/getdata/salescollectionreport')
			.success(function(response){
				$log.info(response.message);
				scr.records = reponse.records;
		});
	}
	
})();