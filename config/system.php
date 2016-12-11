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
	'from' => ['nstech.adm1n@gmail.com','nstech.us3r@gmail.com','nstech.t3st@gmail.com'],
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
		
	// Go live date for van inventory default
	'go_live_date' => '2016-05-02',
		
	// Individual branches live date
	'branch_live_date' => [
		// Ormoc, Masbate, Bacolod
		900 => '2016-10-24',
		2900 => '2016-10-24',
			
		// Ormoc, Masbate, Bacolod
		1400 => '2016-10-03',
		3400 => '2016-10-03',
		300 => '2016-10-03',
		2300 => '2016-10-03',
		//1400 => '2016-10-03',
		//3400 => '2016-10-03',
		
		// Ormoc
		1400 => '2016-10-03',
		3400 => '2016-10-03',
			
		//Davao
		600 => '2016-09-05',
		2600 => '2016-09-05',
			
		//Dumaguete
		700 => '2016-08-29',
		2700 => '2016-08-29',
			
		// Butuan, General santos
		400 => '2016-08-01',
		2400 => '2016-08-01',
		800 => '2016-08-01',
		2800 => '2016-08-01',
		
		// Zamboanga
		1300 => '2016-07-11',
		3300 => '2016-07-11',
			
		// Cagayan, Ozamis
		2500 => '2016-07-04',
		500 => '2016-07-04',
		1100 => '2016-07-04',
		3100 => '2016-07-04',
			
		// Cebu
		100 => '2016-05-02',
		200 => '2016-05-02',
		2100 => '2016-05-02',
		2200 => '2016-05-02',		
			
	],
		
	// Maximum admin users
	'max_admin_users' => 6,	

	// Reset password admin recipients	
	'reset_password_recipients' => 'abnertudtud@gmail.com,alexjohnsuarez@gmail.com,jarisse.carbo13@gmail.com,skitbane@gmail.com,suecelle_jagna@yahoo.com,markgeraldcabatingan@gmail.com,chriswhiz01@gmail.com,jurado.andybon@gmail.com',

	// Invoice Key Code for auto generating invoice code.
	'invoice_key' => [ 1000 => 'C', 2000 => 'D'],
		
	'custom_pk_start' => '2000000001',
];