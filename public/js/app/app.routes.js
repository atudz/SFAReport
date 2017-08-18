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
				.when('/vaninventory.actualcount',{
					templateUrl: '/reports/actualcount',
					controller: 'ActualCount',
					//controllerAs: 'vic'*/
				})
				.when('/actualcount.add',{
					templateUrl: '/reports/actualcount/add',
					controller: 'ActualCountAdd',
					//controllerAs: 'vic'*/
				})
				.when('/actualcount.edit/:id',{
					templateUrl: function(params){ return '/reports/actualcount/edit/'+params.id},
					controller: 'ActualCountAdd',
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
				.when('/vaninventory.replenishment',{
					templateUrl: '/reports/replenishment',
					controller: 'Replenishment',
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
				
				
				.when('/openclosing.period',{
					templateUrl: '/open-closing-period',
					controller: 'OpenClosingPeriod',
					/*controllerAs: 'sync'*/
				})
				
				
				.when('/user.access.matrix',{
					templateUrl: '/user-access-matrix',
					controller: 'UserAccessMatrix',
					/*controllerAs: 'sync'*/
				})
				
				
				.when('/role.access.matrix',{
					templateUrl: '/role-access-matrix',
					controller: 'UserAccessMatrix',
					/*controllerAs: 'sync'*/
				})
				
				
				.when('/user.activity.log',{
					templateUrl: '/user-activity-log',
					controller: 'UserActivityLog',
					/*controllerAs: 'sync'*/
				})

				.when('/user-statistics/:id',{
					templateUrl: function(params) {
					    return '/profile?user_id=' + params.id ;
					},
					controller: 'Profile',
					/*controllerAs: 'sync'*/
				})

				.when('/auditors.list',{
					templateUrl: '/auditors-list',
					controller: 'AuditorsList',
					/*controllerAs: 'sync'*/
				})

				.when('/auditors.list.add',{
					templateUrl: '/auditors-list/add',
					controller: 'AuditorsListAdd',
					/*controllerAs: 'sync'*/
				})

				.when('/auditors.list.edit/:id',{
					templateUrl: function(params) {
					    return '/auditors-list/add?id=' + params.id ;
					},
					controller: 'AuditorsListEdit',
					/*controllerAs: 'sync'*/
				})
				
				
				.when('/remittance.expenses.report',{
					templateUrl: '/remittance-expenses-report',
					controller: 'RemittanceExpenses',
					/*controllerAs: 'sync'*/
				})

				.when('/remittance.expenses.report.add',{
					templateUrl: '/remittance-expenses-report/add',
					controller: 'RemittanceExpensesAdd',
					/*controllerAs: 'sync'*/
				})

				.when('/remittance.expenses.report.edit/:id',{
					templateUrl: function(params) {
					    return '/remittance-expenses-report/add?id=' + params.id ;
					},
					controller: 'RemittanceExpensesEdit',
					/*controllerAs: 'sync'*/
				})

				.when('/sfi.transaction.data',{
					templateUrl: '/sfi-transaction-data',
					controller: 'SFITransactionData',
					/*controllerAs: 'sync'*/
				})

				.when('/profit.centers',{
					templateUrl: '/profit-centers',
					controller: 'ProfitCenter',
					/*controllerAs: 'sync'*/
				})

				.when('/profit.centers.add',{
					templateUrl: '/profit-centers/add',
					controller: 'ProfitCenterForm',
					/*controllerAs: 'sync'*/
				})

				.when('/profit.centers.edit/:id',{
					templateUrl: function(params) {
					    return '/profit-centers/add?id=' + params.id ;
					},
					controller: 'ProfitCenterForm',
					/*controllerAs: 'sync'*/
				})

				.when('/gl.accounts',{
					templateUrl: '/gl-accounts',
					controller: 'GLAccount',
					/*controllerAs: 'sync'*/
				})

				.when('/gl.accounts.add',{
					templateUrl: '/gl-accounts/add',
					controller: 'GLAccountForm',
					/*controllerAs: 'sync'*/
				})

				.when('/gl.accounts.edit/:id',{
					templateUrl: function(params) {
					    return '/gl-accounts/add?id=' + params.id ;
					},
					controller: 'GLAccountForm',
					/*controllerAs: 'sync'*/
				})

				.when('/segment.codes',{
					templateUrl: '/segment-codes',
					controller: 'SegmentCode',
					/*controllerAs: 'sync'*/
				})

				.when('/segment.codes.add',{
					templateUrl: '/segment-codes/add',
					controller: 'SegmentCodeForm',
					/*controllerAs: 'sync'*/
				})

				.when('/segment.codes.edit/:id',{
					templateUrl: function(params) {
					    return '/segment-codes/add?id=' + params.id ;
					},
					controller: 'SegmentCodeForm',
					/*controllerAs: 'sync'*/
				})

				.when('/document.types',{
					templateUrl: '/document-types',
					controller: 'DocumentType',
					/*controllerAs: 'sync'*/
				})

				.when('/document.types.add',{
					templateUrl: '/document-types/add',
					controller: 'DocumentTypeForm',
					/*controllerAs: 'sync'*/
				})

				.when('/document.types.edit/:id',{
					templateUrl: function(params) {
					    return '/document-types/add?id=' + params.id ;
					},
					controller: 'DocumentTypeForm',
					/*controllerAs: 'sync'*/
				})

				.otherwise({
			        redirectTo: '/home'
			    });
		  }
	]);
	
})();