/**
 * Application route list
 */

(function(){
	'use strict';
		
	angular.module('app').config(['$routeProvider',
	      function($routeProvider){
		
				// Append application route list here
				$routeProvider
				// Dashboard
				.when('/dashboard',{
					templateUrl: '/js/testing/dashboard.html',
					controller: 'SalesCollectionReport',
					controllerAs: 'scr'
				})
				// Sales & Collection
				.when('/salescollection.report',{
					templateUrl: '/reports/salescollection/report',
					controller: 'SalesCollectionReport'
					//controllerAs: 'scr'*/
				})
				.when('/salescollection.posting',{
					templateUrl: '/reports/salescollection/posting',
					controller: 'SalesCollectionPosting'
					//controllerAs: 'scp'*/
				})
				.when('/salescollection.summary',{
					templateUrl: '/reports/salescollection/summary',
					controller: 'SalesCollectionSummary',
					//controllerAs: 'scp'*/
				})
				// Van Inventory
				.when('/vaninventory.canned',{
					templateUrl: 'js/app/views/vanInventoryCanned.html',
					/*controller: 'VanInventoryCanned',
					controllerAs: 'vic'*/
				})
				// Sales Report
				.when('/salesreport.permaterial',{
					templateUrl: 'js/app/views/salesReportPerMaterial.html',
					/*controller: 'SalesReportPerMaterial',
					controllerAs: 'srpm'*/
				})
				.when('/salesreport.pesovalue',{
					templateUrl: 'js/app/views/salesReportPesoValue.html',
					/*controller: 'SalesReportPesoValue',
					controllerAs: 'srpv'*/
				})
				.when('/salesreport.returnpermaterial',{
					templateUrl: 'js/app/views/salesReportReturnPerMaterial.html',
					/*controller: 'SalesReportReturnPerMaterial',
					controllerAs: 'srrpm'*/
				})
				.when('/salesreport.returnpesovalue',{
					templateUrl: 'js/app/views/salesReportReturnPesoValue.html',
					/*controller: 'SalesReportReturnPesoValue',
					controllerAs: 'srrpv'*/
				})
				// Unpaid Invoice
				.when('/unpaid',{
					templateUrl: 'js/app/views/unpaid.html',
					/*controller: 'Unpaid',
					controllerAs: 'up'*/
				})
				// bir
				.when('/bir',{
					templateUrl: 'js/app/views/bir.html',
					/*controller: 'Bir',
					controllerAs: 'bir'*/
				})
				// Sync 
				.when('/sync',{
					templateUrl: 'js/app/views/sync.html',
					/*controller: 'Sync',
					controllerAs: 'sync'*/
				})	
				/*.otherwise({
			        redirectTo: '/dashboard'
			    });*/
		  }
	]);
	
})();