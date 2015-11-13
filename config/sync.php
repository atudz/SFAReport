<?php


return [
		
	// Server IP address
	'host' => '192.168.0.7',
		
	// Server port
	'port' => '1433',	
	
	// Database name
	'database' => 'SFA_SFI',
		
	// Database user
	'dbuser' => 'sfa_user',
		
	// Database password
	'dbpass' => 'sfa_user',
		
	// Synchronize table
	// table name => [primary keys or foreign keys]
	'sync_tables' => [
		'app_customer' => ['customer_code'],
		'app_salesman' => ['salesman_code'],
		//'txn_activity_salesman' => [],
		'txn_sales_order_header' => ['so_number'],
		//'txn_sales_order_detail' => [],
		//'txn_sales_order_deal' => ['customer_code'],
		'txn_return_header' => ['return_txn_number'],
		//'txn_return_detail' => [],
		'txn_collection_header' => ['collection_num'],
		//'txn_collection_detail' => [],
		//'txn_evaluated_objective' => [],
		//'txn_activity_salesman' => [],
		//'txn_collection_invoice' => [],
		'txn_invoice' => ['invoice_number'],
	],
		
	// synchronization log storage directory
	'dir' => storage_path('logs/sync/'),
];