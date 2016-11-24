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
		return parent::save($options);
	}
	
	
}