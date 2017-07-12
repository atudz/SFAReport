<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class ReportReferenceRevision extends ModelCore
{
	/**
	 * The table name
	 * @var $table
	 */
	protected $table = 'report_reference_revision_numbers';

    /**
     * Required fields
     * @var $fillable
     */
    protected $fillable = ['navigation_id','salesman_code'];
}