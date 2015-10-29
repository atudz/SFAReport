<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnReplenishmentHeader extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'txn_replenishment_header';
	
	protected $timestamp = false;
}
