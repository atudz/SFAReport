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
		'app_area' => ['area_id'],
		'app_customer' => ['customer_id'],
		'app_discount_group' => ['discount_group_id'],
		'app_item_brand' => ['item_brand_id'],
		'app_item_master' => ['item_master_id'],
		'app_item_master_uom' => ['item_master_uom_id'],
		'app_item_price' => ['item_price_id'],
		'app_item_segment' => ['item_segment_id'],
		'app_item_uom' => ['item_uom_id'],
		'app_return_reason' => ['return_reason_id'],
		'app_salesman' => ['salesman_id'],
		'app_salesman_customer' => ['salesman_customer_id'],
		'app_salesman_van' => ['salesman_van_id'],
		'app_storetype' => ['storetype_id'],
		'app_van' => ['van_id'],
		'app_vatposting_setup' => ['vatposting_id'],
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
		'txn_sales_order_detail_discount' => ['reference_num'],
		'txn_return_header_discount' => ['reference_num'],
		'txn_replenishment_detail' => ['replenishment_detail_id'],
		'txn_replenishment_header' => ['replenishment_header_id'],
		'txn_stock_transfer_in_detail' => ['stock_transfer_in_detail_id'],
		'txn_stock_transfer_in_header' => ['stock_transfer_in_header_id'],
		
		'txn_item_flexi_deal' => ['deal_id'],
	],
		
	// synchronization log storage directory
	'dir' => storage_path('logs/sync/sync.log'),
];