<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnReturnHeader extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_return_header';
	
	protected $timestamp = false;
}
