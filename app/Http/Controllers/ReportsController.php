<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use Illuminate\Http\Request;
use App\Factories\LibraryFactory;

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
		
		$stockTransNum = '';
		$syncTables = config('sync.sync_tables');
		if($pk = array_shift($syncTables[$table]))
		{
			if($table == 'txn_stock_transfer_in_header')
			{
				$stockTransNum = \DB::table($table)->where($pk,$id)->value($column);
			}
			\DB::table($table)->where($pk,$id)->update([
					$column => $value,
					'updated_at' => new \DateTime(),
					'updated_by' => auth()->user()->id,
			]);

			\DB::table('table_logs')->insert([
					'table' => $table,
					'column' => $column,
					'pk_id' => $id,
					'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value, 
					'updated_at' => new \DateTime(),
					'created_at' => new \DateTime(),
					'updated_by' => auth()->user()->id,
			]);
		}
		
		if($table == 'txn_stock_transfer_in_header' && $stockTransNum)
		{
			\DB::table('txn_stock_transfer_in_detail')->where($column,$stockTransNum)->update([
					$column => $value,
					'updated_at' => new \DateTime(),
					'updated_by' => auth()->user()->id,
			]);
			
			\DB::table('table_logs')->insert([
					'table' => $table,
					'column' => $column,
					'pk_id' => $id,
					'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
					'updated_at' => new \DateTime(),
					'created_at' => new \DateTime(),
					'updated_by' => auth()->user()->id,
			]);
		}
		
		$data['success'] = true;
		return response()->json($data);	
	}
	
	
	/**
	 * Sync reports from SFA db
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sync()
	{
		$message = '';
		$result = LibraryFactory::getInstance('Sync')->sync();
		if($result)
		{
			$message = file_get_contents(storage_path('logs/sync/'.date('Y-m-d').'.log'));
		}
		$data['logs'] = $message;		
		return response()->json($data);
	}
}
