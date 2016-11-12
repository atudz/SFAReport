<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnCollectionHeader extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'txn_collection_header';
	
	public $timestamps = false;
}
