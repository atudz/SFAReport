<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
		'reports/getdata/salescollectionreport',
    	'reports/getdata/salescollectionposting',
    	'reports/getdata/salescollectionsummary',    		
    	'reports/getdata/vaninventorycanned',
    	'reports/getdata/vaninventoryfrozen',
        'reports/getdata/salesreportpermaterial',
    	'reports/getdata/salesreportperpeso',
    	'reports/getdata/returnpermaterial',
    	'reports/getdata/returnperpeso',
    	'reports/getdata/customerlist',
    	'reports/getdata/materialpricelist',
    		
    		
    	'/controller/reports/save',
    ];
}
