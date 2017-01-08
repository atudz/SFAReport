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
		$prevInvoiceNum = '';
		$reference='';
		$salesman='';
		$syncTables = config('sync.sync_tables');
		if($pk = array_shift($syncTables[$table]))
		{
			if($table == 'txn_stock_transfer_in_header')
			{
				$stockTransNum = \DB::table($table)->where($pk,$id)->value($column);
			}
			
			$prevData = \DB::table($table)->where($pk,$id)->first();
			$before = isset($prevData->$column) ? $prevData->$column : '';
			if($column == 'invoice_number')
			{
				$prevInvoiceNum = $before;
				$reference = isset($prevData->reference_num) ? $prevData->reference_num : '';
				$salesman = isset($prevData->salesman_code) ? $prevData->salesman_code : '';
			}
						
			\DB::table($table)->where($pk,$id)->lockForUpdate()->update([
					$column => $value,
					'updated_at' => new \DateTime(),
					'updated_by' => auth()->user()->id,
			]);

			\DB::table('table_logs')->insert([
					'table' => $table,
					'column' => $column,
					'pk_id' => $id,
					'before' => $before,
					'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value, 
					'updated_at' => new \DateTime(),
					'created_at' => new \DateTime(),
					'updated_by' => auth()->user()->id,
			]);
		}
		
		if($table == 'txn_stock_transfer_in_header' && $stockTransNum && $column == 'stock_transfer_number')
		{
			$transfer = \DB::table('txn_stock_transfer_in_detail')->where($column,$stockTransNum)->first();			
			
			if($transfer)
			{
				\DB::table('txn_stock_transfer_in_detail')->where($column,$stockTransNum)->lockForUpdate()->update([
						$column => $value,
						'updated_at' => new \DateTime(),
						'updated_by' => auth()->user()->id,
				]);
					
				\DB::table('table_logs')->insert([
						'table' => 'txn_stock_transfer_in_detail',
						'column' => $column,
						'pk_id' => $transfer->stock_transfer_in_detail_id,
						'before' => $transfer->stock_transfer_number,
						'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
						'updated_at' => new \DateTime(),
						'created_at' => new \DateTime(),
						'updated_by' => auth()->user()->id,
				]);
			}
			
		}
		
		
		if($column == 'invoice_number' && $prevInvoiceNum)
		{
			$insertData = [];
			$data1 = \DB::table('txn_collection_invoice')->where($column,$prevInvoiceNum)->first();
			if($data1)
			{
				$prepare = \DB::table('txn_collection_invoice')->where($column,$prevInvoiceNum);
				if($reference)		
					$prepare->where('reference_num',$reference);
				if($salesman)
					$prepare->where('modified_by',$salesman);
				
				$updated = $prepare->lockForUpdate()->update([
							$column => $value,
							'updated_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
				]);
				
				if(!$updated)
					$updated = \DB::table('txn_collection_invoice')->where($column,$prevInvoiceNum)->lockForUpdate()->update([
													$column => $value,
													'updated_at' => new \DateTime(),
													'updated_by' => auth()->user()->id,
								]);
					
				//if($updated)
				//{
					$insertData[] = [
							'table' => 'txn_collection_invoice',
							'column' => $column,
							'pk_id' => $data1->collection_invoice_id,
							'before' => $data1->invoice_number,
							'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
							'updated_at' => new \DateTime(),
							'created_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
					];
				//}
			}			
			
			
			if($table != 'txn_invoice')
			{
				$data2 = \DB::table('txn_invoice')->where($column,$prevInvoiceNum)->first();
				if($data2)
				{
					\DB::table('txn_invoice')->where($column,$prevInvoiceNum)->lockForUpdate()->update([
							$column => $value,
							'updated_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
					]);
						
					$insertData[] = [
							'table' => 'txn_invoice',
							'column' => $column,
							'pk_id' => $data2->invoice_id,
							'before' => $data2->invoice_number,
							'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
							'updated_at' => new \DateTime(),
							'created_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
					];
				}
			}
			
			if($insertData)
				\DB::table('table_logs')->insert($insertData);
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
		$setting = \DB::table('settings')->where('name','synching_sfi')->first();
		if($setting->value)
		{
			$data['synching'] = true;
		}
		else
		{
			$result = LibraryFactory::getInstance('Sync')->sync();
			$data['synching'] = false;
			$data['logs'] = $result ? true : '';
		}	
		//$data['synching'] = false;
		//$data['logs'] = true;
		return response()->json($data);
	}
}
