<?php

return [
		
	// Cache report request and response
	'cache_request' => false,
		
	// Cache storage directory
	'cache_storage' => storage_path('cache/filter/'),
		
	// System default recipient email for errors
	// Should be comma separated for multiple emails
	'error_email' => 'abnertudtud@gmail.com,alexjohnsuarez@gmail.com,jarisse.carbo13@gmail.com,skitbane@gmail.com',

	// System default email from
	'from' => 'Sunpride Admin',
		
	// System default email
	'from_email' => 'noreply@sunpride.com',
		
	//Password complexity
	'password_complexity' => '',
		
	// Pagination limit default
	'page_limit' => '25',
		
	// Report limit data export xls
	'report_limit_xls' => '2500',
		
	// Report limit data export xls
	'report_limit_pdf' => '100',
		
	// Go live date for van inventory
	'go_live_date' => '2016-05-01',
		
	// Maximum admin users
	'max_admin_users' => 6	
];