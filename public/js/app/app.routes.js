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
					//controllerAs: 'bir'*/
				})
				// Sync 
				.when('/sync',{
					templateUrl: '/reports/sync',
					controller: 'Sync',
					/*controllerAs: 'sync'*/
				})
				
				// Users 
				.when('/user.list',{
					templateUrl: '/user/list',
					controller: 'UserList'
					/*controllerAs: 'sync'*/
				})
				.when('/user.add',{
					templateUrl: '/user/addEdit',
					controller: 'UserAdd'
					/*controllerAs: 'sync'*/
				})
				.when('/user.edit/:id',{
					templateUrl: '/user/edit',
					controller: 'UserEdit'
					/*controllerAs: 'sync'*/
				})
				.when('/contact.us', {
					templateUrl: '/user/contactus',
					controller: 'ContactUs'
					/*controllerAs: 'sync'*/
				})
				.when('/summaryofincident.report', {
					templateUrl: '/user/summaryofincidentreport',
					controller: 'SummaryOfIncidentReport'
					/*controllerAs: 'sync'*/
				})
				.when('/adminuser.guide', {
					templateUrl: '/user/adminUserGuide',
					controller: 'AdminUserGuide'
					/*controllerAs: 'sync'*/
				})
				.when('/auditoruser.guide', {
					templateUrl: '/user/auditorUserGuide',
					controller: 'AuditorUserGuide'
					/*controllerAs: 'sync'*/
				})
				.when('/accountinginchargeuser.guide', {
					templateUrl: '/user/accountingInChargeUserGuide',
					controller: 'AccountingInChargeUserGuide'
					/*controllerAs: 'sync'*/
				})
				.when('/vansalesmanuser.guide', {
					templateUrl: '/user/vanSalesmanUserGuide',
					controller: 'VanSalesmanUserGuide'
					/*controllerAs: 'sync'*/
				})
				.when('/manageruser.guide', {
					templateUrl: '/user/managerUserGuide',
					controller: 'ManagerUserGuide'
					/*controllerAs: 'sync'*/
				})
				.when('/guest1user.guide', {
					templateUrl: '/user/guest1UserGuide',
					controller: 'Guest1UserGuide'
					/*controllerAs: 'sync'*/
				})
				.when('/guest2user.guide', {
					templateUrl: '/user/guest2UserGuide',
					controller: 'Guest2UserGuide'
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
				

				.otherwise({
			        redirectTo: '/home'
			    });
		  }
	]);
	
})();