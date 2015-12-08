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
				.when('/home',{
					templateUrl: '/home',
					/*controller: 'SalesCollectionReport',
					controllerAs: 'scr'*/
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
					templateUrl: '/reports/vaninventory/canned',
					controller: 'VanInventoryCanned',
					//controllerAs: 'vic'*/
				})
				.when('/vaninventory.frozen',{
					templateUrl: '/reports/vaninventory/frozen',
					controller: 'VanInventoryFrozen',
					//controllerAs: 'vic'*/
				})
				// Sales Report
				.when('/salesreport.permaterial',{
					templateUrl: '/reports/salesreport/permaterial',
					/*controller: 'SalesReportPerMaterial',
					controllerAs: 'srpm'*/
				})
				.when('/salesreport.pesovalue',{
					templateUrl: '/reports/salesreport/perpeso',
					/*controller: 'SalesReportPesoValue',
					controllerAs: 'srpv'*/
				})
				.when('/salesreport.returnpermaterial',{
					templateUrl: '/reports/salesreport/returnpermaterial',
					/*controller: 'SalesReportReturnPerMaterial',
					controllerAs: 'srrpm'*/
				})
				.when('/salesreport.returnpesovalue',{
					templateUrl: '/reports/salesreport/returnperpeso',
					/*controller: 'SalesReportReturnPesoValue',
					controllerAs: 'srrpv'*/
				})
				// Unpaid Invoice
				.when('/unpaid',{
					templateUrl: '/reports/unpaidinvoice',
					/*controller: 'Unpaid',
					controllerAs: 'up'*/
				})
				// bir
				.when('/bir',{
					templateUrl: '/reports/bir',
					controller: 'Bir',
					//controllerAs: 'bir'*/
				})
				// Sync 
				.when('/sync',{
					templateUrl: '/reports/sync',
					/*controller: 'Sync',
					controllerAs: 'sync'*/
				})
				
				// Users 
				.when('/user.list',{
					templateUrl: '/user/list',
					/*controller: 'Sync',
					controllerAs: 'sync'*/
				})

				.when('/profile.changepassword',{
					templateUrl: '/changepass',
					/*controller: 'Sync',
					controllerAs: 'sync'*/
				})

				.when('/profile.my',{
					templateUrl: '/profile',
					/*controller: 'Sync',
					controllerAs: 'sync'*/
				})

				.when('/usergroup.rights',{
					templateUrl: '/user/group/rights',
					/*controller: 'Sync',
					controllerAs: 'sync'*/
				})
				

				.otherwise({
			        redirectTo: '/home'
			    });
		  }
	]);
	
})();