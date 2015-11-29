<?php


return [
		
	// Server IP address
	'host' => '192.168.240.33',
		
	// Server port
	'port' => '1433',	
	
	// Database name
	'database' => 'SFA_SFI_TEST',
		
	// Database user
	'dbuser' => 'UATREAD',
		
	// Database password
	'dbpass' => 'U4tR34d',
		
	// Synchronize table
	// table name => [primary keys or foreign keys]
	'sync_tables' => [
		'app_customer' => ['customer_id'],
		'app_salesman' => ['salesman_id'],
		'txn_activity_salesman' => ['activity_header_id'],
		'txn_sales_order_header' => ['sales_order_header_id'],
		'txn_sales_order_detail' => ['sales_order_detail_id'],
		'txn_sales_order_deal' => ['so_detail_deal_id'],
		'txn_return_header' => ['return_header_id'],
		'txn_return_detail' => ['return_detail_id'],
		'txn_collection_header' => ['collection_header_id'],
		'txn_collection_detail' => ['collection_detail_id'],
		'txn_evaluated_objective' => ['evaluated_objective_id'],
		'txn_collection_invoice' => ['collection_invoice_id'],
		'txn_invoice' => ['invoice_id'],
		'txn_sales_order_header_discount' => ['reference_num'],
		'txn_return_header_discount' => ['reference_num'],
	],
		
	// synchronization log storage directory
	'dir' => storage_path('logs/sync/'),
];