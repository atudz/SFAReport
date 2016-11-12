<?php

namespace App\Http\Models;

use App\Core\ModelCore;

class TxnCollectionDetail extends ModelCore
{
    /**
	 * 
	 * @var $table The table name
	 */
	protected $table = 'txn_collection_detail';
	
	public $timestamps = false;
}
