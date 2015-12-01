<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use Illuminate\Http\Request;

class ReportsController extends ControllerCore
{

	/**
	 * Update databsae record
	 * @param unknown $table
	 * @param unknown $id
	 * @param unknown $value
	 * @return boolean
	 */
	public function save(Request $request)
	{
		$table = $request->get('table');
		$column = $request->get('column');
		$value = $request->get('value');
		$id = $request->get('id');
		
		$syncTables = config('sync.sync_tables');
		
		if($pk = $syncTables[$table])
		{
			return \DB::table($table)->where($pk,$id)->update([$column => $value]);	
		}
		
		return true;	
	}
}
