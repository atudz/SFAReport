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
		if(false === strpos($column,'date'))
			$value = $request->get('value');
		else 
			$value = new \DateTime($request->get('value'));
		$id = $request->get('id');
		
		$syncTables = config('sync.sync_tables');
		if($pk = array_shift($syncTables[$table]))
		{
			\DB::table($table)->where($pk,$id)->update([
					$column => $value,
					'updated_at' => new \DateTime(),
					'updated_by' => auth()->user()->id,
			]);	
		}
		
		$data['success'] = true;
		return response()->json($data);	
	}
}
