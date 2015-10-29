<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnCollectionInvoice extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'txn_collection_invoice';
	
	protected $timestamp = false;
}
