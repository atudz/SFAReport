<?php

namespace App\Core;

use Illuminate\Database\Eloquent\Model;


/**
 * This class is a wrapper class for Laravel's Model Class.
 * Its mainly used for the core class for Models.
 * Models should extend this class
 *
 * @author abner
 *
 */
class ModelCore extends Model
{
	
	/**
	 * Save the model to the database.
	 * Overriden the parent so that customization can be added
	 *
	 * @param  array  $options
	 * @return bool
	 */
	public function save(array $options = [])
	{
		
		// Auto populate creator 
		if($this->__isset('creator_pk_id') && !$this->creator_pk_id && \Auth::user())
		{
			$this->setAttribute('creator_pk_id', \Auth::user()->id);
		}
		
		return parent::save($options);
	}
	
	
}