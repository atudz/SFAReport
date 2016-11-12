<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnInvoice extends ModelCore
{
	/**
	 *
	 * @var $table The table name
	 */
	protected $table = 'txn_invoice';
	
	public $timestamps = false;
}
