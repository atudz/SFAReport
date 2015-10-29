<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnReturnDetail extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_return_detail';
	
	protected $timestamp = false;
}
