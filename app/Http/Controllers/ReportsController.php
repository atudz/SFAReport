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
		$comment = $request->get('comment');
		$report_type = $request->has('report_type') ? $request->get('report_type') : '';
		$report = $request->has('report') ? $request->get('report') : '';

		if($report == 'salescollectionreport' && $column == 'or_date' && (strtotime(date('Y-m-d',strtotime($request->get('invoice_date')))) > strtotime(date('Y-m-d',strtotime($request->get('value')))))){
			return response()->json(['error' => 'OR Date must be same or after Invoice Date ' . date('F d,Y',strtotime($request->get('invoice_date'))) ],422);
		}

		$stockTransNum = '';
		$prevInvoiceNum = '';
		$reference='';
		$syncTables = config('sync.sync_tables');
		$deleteRemarks = $column == 'delete_remarks';
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
			}

			\DB::table($table)->where($pk,$id)->lockForUpdate()->update([
							$column => $value,
							'updated_at' => $deleteRemarks ? null : new \DateTime(),
							'updated_by' => $deleteRemarks ? 0 : auth()->user()->id,
			]);

			$logId = \DB::table('table_logs')->insertGetId([
							'table' => $table,
							'column' => $column,
							'pk_id' => $id,
							'before' => $before,
							'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
							'updated_at' => new \DateTime(),
							'created_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
							'comment' => $comment,
							'report_type' => $report_type,
							'salesman_code' => $this->getSalesmanCode('txn_stock_transfer_in_detail',$id)
					]);

			if($logId)
			{
						\DB::table('report_revisions')->insert([
								'revision_number' => generate_revision($report),
								'report' => $report,
								'updated_at' => new \DateTime(),
								'created_at' => new \DateTime(),
								'user_id' => auth()->user()->id,
								'table_log_id' => $logId
						]);
			}
		}

		if($table == 'txn_stock_transfer_in_header' && $stockTransNum && $column == 'stock_transfer_number')
		{
			$transfer = \DB::table('txn_stock_transfer_in_detail')->where($column,$stockTransNum)->first();

			if($transfer)
			{
				\DB::table('txn_stock_transfer_in_detail')->where($column,$stockTransNum)->lockForUpdate()->update([
								$column => $value,
								'updated_at' => $deleteRemarks ? null : new \DateTime(),
								'updated_by' => $deleteRemarks ? 0 : auth()->user()->id,
				]);

				\DB::table('table_logs')->insertGetId([
								'table' => 'txn_stock_transfer_in_detail',
								'column' => $column,
								'pk_id' => $transfer->stock_transfer_in_detail_id,
								'before' => $transfer->stock_transfer_number,
								'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
								'updated_at' => new \DateTime(),
								'created_at' => new \DateTime(),
								'updated_by' => auth()->user()->id,
								'comment' => $comment,
								'report_type' => $report_type,
								'salesman_code' => $this->getSalesmanCode('txn_stock_transfer_in_detail',$id)
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

				$updated = $prepare->lockForUpdate()->update([
									$column => $value,
									'updated_at' => $deleteRemarks ? null : new \DateTime(),
									'updated_by' => $deleteRemarks ? 0 : auth()->user()->id,
							]);

				if(!$updated)
					$updated = \DB::table('txn_collection_invoice')->where($column,$prevInvoiceNum)->lockForUpdate()->update([
										$column => $value,
										'updated_at' => $deleteRemarks ? null : new \DateTime(),
										'updated_by' => $deleteRemarks ? 0 : auth()->user()->id,
								]);

				if($updated)
				{
					$insertData[] = [
											'table' => 'txn_collection_invoice',
											'column' => $column,
											'pk_id' => $data1->collection_invoice_id,
											'before' => $data1->invoice_number,
											'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
											'updated_at' => new \DateTime(),
											'created_at' => new \DateTime(),
											'updated_by' => auth()->user()->id,
											'comment' => $comment,
											'report_type' => $report_type,
									];
				}
			}


			if($table != 'txn_invoice')
			{
				$data2 = \DB::table('txn_invoice')->where($column,$prevInvoiceNum)->first();
				if($data2)
				{
					\DB::table('txn_invoice')->where($column,$prevInvoiceNum)->lockForUpdate()->update([
										$column => $value,
										'updated_at' => $deleteRemarks ? null : new \DateTime(),
										'updated_by' => $deleteRemarks ? 0 : auth()->user()->id,
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
										'comment' => $comment,
										'report_type' => $report_type,
								];
					}
			 }


			 if($insertData)
			 {
			 	$insertData['salesman_code'] = $this->getSalesmanCode($insertData['table'],$insertData['pk_id']);
			 	\DB::table('table_logs')->insert($insertData);
			 }
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
	
	/**
	 * Get Salesman Code
	 * @param  $table  [table to search]
	 * @param  $pk_id  [the primary key of the table]
	 * @return String
	 */
	public function getSalesmanCode($table,$pk_id){
		$salesman_code = '';
		$syncTables = config('sync.sync_tables');
		$pkColumn = array_shift($syncTables[$table]);
		
		switch($table)
		{
			case 'txn_collection_header':
			case 'txn_sales_order_header':
			case 'txn_return_header':
			case 'txn_evaluated_objective':
			case 'txn_stock_transfer_in_header':
				$row = \DB::table($table)->where($pkColumn,$pk_id)->first();
				if($row)
				{
					return $row->salesman_code;
				}
				break;
			case 'txn_collection_detail':
			case 'txn_collection_invoice':
				$row = \DB::table($table)
				->select('txn_collection_header.salesman_code')
				->join('txn_collection_header','txn_collection_header.reference_num','=',$table.'.reference_num')
				->where($table.'.'.$pkColumn,$pk_id)
				->first();
				if($row)
				{
					return $row->salesman_code;
				}
				break;
			case 'txn_return_detail':
				$row = \DB::table($table)
				->select('txn_return_header.salesman_code')
				->join('txn_return_header','txn_return_header.reference_num','=',$table.'.reference_num')
				->where($table.'.return_detail_id',$pk_id)
				->first();
				$column = $table.'.return_detail_id';
				if($row)
				{
					return $row->salesman_code;
				}
				break;
			case 'txn_sales_order_deal':
			case 'txn_sales_order_header_discount':
			case 'txn_sales_order_detail':
				$row = \DB::table($table)
				->select('txn_sales_order_header.salesman_code')
				->join('txn_sales_order_header','txn_sales_order_header.reference_num','=',$table.'.reference_num')
				->where($table.'.'.$pkColumn,$pk_id)
				->first();
				if($row)
				{
					return $row->salesman_code;
				}
				break;
			case 'txn_stock_transfer_in_detail':
				$row = \DB::table($table)
				->select('txn_stock_transfer_in_header.salesman_code')
				->join('txn_stock_transfer_in_header','txn_stock_transfer_in_header.stock_transfer_number','=',$table.'.stock_transfer_number')
				->where($table.'.stock_transfer_in_detail_id',$pk_id)
				->first();
				if($row)
				{
					return $row->salesman_code;
				}
				break;
		}
		
		return $salesman_code;
	}
}
