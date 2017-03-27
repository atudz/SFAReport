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
					controller: 'SalesCollectionPosting',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id == 4 || $window.user.user_group_id == 5 || $window.user.user_group_id == 6) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					//controllerAs: 'scp'*/
				})
				.when('/salescollection.summary',{
					templateUrl: '/reports/salescollection/summary',
					controller: 'SalesCollectionSummary',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id != 1 && $window.user.user_group_id != 2) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					//controllerAs: 'scp'*/
				})
				// Sales & Collection
				.when('/cashpayments',{
					templateUrl: '/reports/cashpayments',
					controller: 'CashPaymentsReport'
					//controllerAs: 'scr'*/
				})
								// Sales & Collection
				.when('/checkpayments',{
					templateUrl: '/reports/checkpayments',
					controller: 'CheckPaymentsReport'
					//controllerAs: 'scr'*/
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
				.when('/vaninventory.stocktransfer',{
					templateUrl: '/reports/stocktransfer',
					controller: 'StockTransfer',
					//controllerAs: 'vic'*/
				})
				.when('/stocktransfer.add',{
					templateUrl: '/reports/stocktransfer/add',
					controller: 'StockTransferAdd',
					//controllerAs: 'vic'*/
				})
				.when('/vaninventory.stockaudit',{
					templateUrl: '/reports/stockaudit',
					controller: 'StockAudit',
					//controllerAs: 'vic'*/
				})
				.when('/vaninventory.flexideal',{
					templateUrl: '/reports/flexideal',
					controller: 'FlexiDeal',
					//controllerAs: 'vic'*/
				})
				.when('/vaninventory.replenishment',{
					templateUrl: '/reports/replenishment',
					controller: 'Replenishment',
					//controllerAs: 'vic'*/
				})
				.when('/replenishment.add',{
					templateUrl: '/reports/replenishment/add',
					controller: 'ReplenishmentAdd',
					//controllerAs: 'vic'*/
				})
				.when('/replenishment.edit/:id',{
					templateUrl: function(params){ return '/reports/replenishment/edit/'+params.id},
					controller: 'ReplenishmentAdd',
					//controllerAs: 'vic'*/
				})
				.when('/vaninventory.adjustment',{
					templateUrl: '/reports/adjustment',
					controller: 'Adjustment',
					//controllerAs: 'vic'*/
				})
				.when('/adjustment.add',{
					templateUrl: '/reports/adjustment/add',
					controller: 'AdjustmentAdd',
					//controllerAs: 'vic'*/
				})
				.when('/adjustment.edit/:id',{
					templateUrl: function(params){ return '/reports/adjustment/edit/'+params.id},
					controller: 'AdjustmentAdd',
					//controllerAs: 'vic'*/
				})
				
				
				// Sales Report
				.when('/salesreport.permaterial',{
					templateUrl: '/reports/salesreport/permaterial',
					controller: 'SalesReportPerMaterial',
					//controllerAs: 'srpm'*/
				})
				.when('/salesreport.pesovalue',{
					templateUrl: '/reports/salesreport/perpeso',
					controller: 'SalesReportPerPeso',
					//controllerAs: 'srpv'*/
				})
				.when('/salesreport.returnpermaterial',{
					templateUrl: '/reports/salesreport/returnpermaterial',
					controller: 'ReturnReportPerMaterial',
					//controllerAs: 'srrpm'*/
				})
				.when('/salesreport.returnpesovalue',{
					templateUrl: '/reports/salesreport/returnperpeso',
					controller: 'ReturnReportPerPeso',
					//controllerAs: 'srrpv'*/
				})
				.when('/salesreport.customerlist',{
					templateUrl: '/reports/salesreport/customerlist',
					controller: 'CustomerList',
					//controllerAs: 'srrpv'*/
				})
				.when('/salesreport.salesmanlist',{
					templateUrl: '/reports/salesreport/salesmanlist',
					controller: 'SalesmanList',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id == 4 || $window.user.user_group_id == 6) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					//controllerAs: 'srrpv'*/
				})
				.when('/salesreport.materialpricelist',{
					templateUrl: '/reports/salesreport/materialpricelist',
					controller: 'MaterialPriceList',
					//controllerAs: 'srrpv'*/
				})
				
				
				// Unpaid Invoice
				.when('/unpaid',{
					templateUrl: '/reports/unpaidinvoice',
					controller: 'Unpaid',
					//controllerAs: 'up'*/
				})
				// bir
				.when('/bir',{
					templateUrl: '/reports/bir',
					controller: 'Bir',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id == 4 || $window.user.user_group_id == 6) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					//controllerAs: 'bir'*/
				})
				// Sync 
				.when('/sync',{
					templateUrl: '/reports/sync',
					controller: 'Sync',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id == 5 || $window.user.user_group_id == 6) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					/*controllerAs: 'sync'*/
				})
				
				// Users 
				.when('/user.list',{
					templateUrl: '/user/list',
					controller: 'UserList',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id != 1) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					/*controllerAs: 'sync'*/
				})
				.when('/user.add',{
					templateUrl: '/user/addEdit',
					controller: 'UserAdd',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id != 1) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					/*controllerAs: 'sync'*/
				})
				.when('/user.edit/:id',{
					templateUrl: '/user/edit',
					controller: 'UserEdit',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id != 1) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					/*controllerAs: 'sync'*/
				})
				.when('/contact.us', {
					templateUrl: '/user/contactus',
					controller: 'ContactUs'
					/*controllerAs: 'sync'*/
				})
				.when('/summaryofincident.report', {
					templateUrl: '/user/summaryofincidentreport',
					controller: 'SummaryOfIncidentReport',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id != 1) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					/*controllerAs: 'sync'*/
				})
				.when('/user.guide', {
					templateUrl: '/user/userGuide',
					controller: 'UserGuide'
					/*controllerAs: 'sync'*/
				})
				.when('/profile.changepassword',{
					templateUrl: '/changepass',
					controller: 'ChangePassword',
					/*controllerAs: 'sync'*/
				})

				.when('/profile.my',{
					templateUrl: '/profile',
					controller: 'Profile',
					/*controllerAs: 'sync'*/
				})

				.when('/usergroup.rights',{
					templateUrl: '/user/group/rights',
					controller: 'UserGroupList',
					resolve: {
						security: ['$q', '$window', function ($q, $window) {
							if ($window.user.user_group_id != 1) {
								$q.reject("Not Authorized");
								return window.location.href = '/403';
							}
						}]
					}
					/*controllerAs: 'sync'*/
				})
				
				.when('/invoiceseries.mapping',{
					templateUrl: '/reports/invoiceseries',
					controller: 'InvoiceSeries',
					/*controllerAs: 'sync'*/
				})
				.when('/invoiceseries.add',{
					templateUrl: '/reports/invoiceseries/add',
					controller: 'InvoiceSeriesAdd',
					/*controllerAs: 'sync'*/
				})
				
				.when('/invoiceseries.edit/:id',{
					templateUrl: function(params){ return '/reports/invoiceseries/edit/'+params.id},
					controller: 'InvoiceSeriesAdd',
					/*controllerAs: 'sync'*/
				})
				
				
				.when('/bounce.check',{
					templateUrl: '/reports/bouncecheck',
					controller: 'BounceCheck',
					/*controllerAs: 'sync'*/
				})
				.when('/bouncecheck.add',{
					templateUrl: '/reports/bouncecheck/add',
					controller: 'BounceCheckAdd',
					/*controllerAs: 'sync'*/
				})
				
				.when('/bouncecheck.edit/:id',{
					templateUrl: function(params){ return '/reports/bouncecheck/edit/'+params.id},
					controller: 'BounceCheckAdd',
					/*controllerAs: 'sync'*/
				})
				
				.when('/reversal.summary',{
					templateUrl: '/reports/reversal/summary',
					controller: 'ReversalSummary',
					/*controllerAs: 'sync'*/
				})
				

				.otherwise({
			        redirectTo: '/home'
			    });
		  }
	]);
	
})();