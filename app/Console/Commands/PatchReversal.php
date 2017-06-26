<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PatchReversal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'patch:reversal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	DB::beginTransaction();
    	$this->fixLogs();
    	$this->patch();	
    	DB::commit();
    }
    
    public function fixLogs()
    {
    	$syncTables = config('sync.sync_tables');
    	$logs = DB::table('table_logs')
				    	->groupBy('table')
				    	->groupBy('column')
				    	->groupBy('pk_id')
				    	->orderBy('created_at')
				    	->get(['table','column','pk_id','id']);
    	foreach($logs as $log) {
    		$pks = $syncTables[$log->table];
    		$pk = array_shift($pks);
    		$data = DB::connection('sfa_backup')
    					->table($log->table)    					
    					->where($pk,$log->pk_id)
			    		->first();
    		if(!$data) {    			
    			$count = DB::table('table_logs')
			    			->where('table', $log->table)
			    			->where('column', $log->column)
			    			->where('pk_id', $log->pk_id)
    						->delete();
				$this->info('Deleted table log '.$log->table.' : '.$log->pk_id.' : '. $log->column.', deleted : '.$count);
    		}
    	}
    }
    
    public function patch()
    {
    	$syncTables = config('sync.sync_tables');
    	$logs = DB::table('table_logs')
				    	->groupBy('table')
				    	->groupBy('column')
				    	->groupBy('pk_id')
				    	->orderBy('created_at')
				    	->get(['table','column','pk_id','id']);
    	foreach($logs as $log) {
    		$rows = DB::table('table_logs')
			    		->where('table',$log->table)
			    		->where('column',$log->column)
			    		->where('pk_id',$log->pk_id)
			    		->orderBy('created_at')
			    		->get();
    		
    		foreach($rows as $row) {
    			$pks = $syncTables[$row->table];
    			$pk = array_shift($pks);
    			$data = DB::table($row->table)
    							->where($row->column, $row->before)
    							->where($pk,$row->pk_id)
    							->first();
    			if($data) {
    				$updates = [
    						'updated_at' => $row->created_at,
    						'updated_by' => $row->updated_by,
    						$row->column => $row->value,
    				];
					$count = DB::table($row->table)
								->where($pk,$data->{$pk})
								->update($updates);
					$this->info('Data found '.$row->table.' : '.$row->pk_id.', '. $row->column.' : '.$row->before. ' , updated : '.$count);								
    				
    			} else {
    				$reference = DB::connection('sfa_backup')
    								->table($row->table)    								
				    				->where($pk,$row->pk_id)
				    				->first();
    				if($reference) {
    					$prepare = DB::table($row->table);
    					switch($row->table) {
    					    case 'txn_sales_order_header':
    					    	$prepare->where('so_number',$reference->so_number);
    					    	break;
    					    case 'txn_sales_order_detail':
    					    	$prepare->where('so_number',$reference->so_number)->where('item_code',$reference->item_code);
    					    	break;
    					    case 'txn_collection_header':
    					    	$prepare->where('collection_num',$reference->collection_num);
    					    	break;
    					    case 'txn_collection_detail':
    					    	$prepare->where('collection_num',$reference->collection_num)->where('payment_method_code',$reference->payment_method_code);
    					    	break;
    					    case 'txn_return_header':
    					    	$prepare->where('return_txn_number',$reference->return_txn_number);
    					    	break;
    					    case 'txn_return_header_discount':
    					    	$prepare->where('return_txn_number',$reference->return_txn_number)->where('item_code',$reference->item_code);
    					    	break;    					    	
    					    case 'txn_stock_transfer_in_header':
    					    	$prepare->where('salesman_code',$reference->salesman_code)
    					    			->where('dest_van_code',$reference->dest_van_code)
    					    			->where('src_van_code',$reference->src_van_code)
    					    			->where('sfa_modified_date',$reference->sfa_modified_date);
    					    	break;
    					    case 'txn_stock_transfer_in_detail':
    					    	$prepare->where('item_code',$reference->item_code)
    					    			->where('modified_by',$reference->modified_by)
		    					    	->where('sfa_modified_date',$reference->sfa_modified_date);
    					    	break;
    					}
    					
    					$result = $prepare->first();
    					if($result) {
    						$updates = [
    								'updated_at' => $row->created_at,
    								'updated_by' => $row->updated_by,
    								$row->column => $row->value,
    						];
    						$count = DB::table($row->table)
		    						->where($pk,$result->{$pk})
		    						->update($updates);
    						$this->info('Data found '.$row->table.' : '.$row->pk_id.', '. $row->column.' : '.$row->before. ' , updated : '.$count);
    						$this->info('Update table log '.$row->table.' '.$row->pk_id.':'.$result->{$pk});
    					} else {
    						$this->info('Data not found '.$row->table.' : '.$row->pk_id.', '. $row->column.' : '.$row->before);
    						
    						if(isset($reference->reference_num)) {
    							$activity = DB::table('txn_activity_salesman')->where('reference_num',$reference->reference_num)->first();
    							if($activity) {
    								$this->info('Activity Salesman found ref : '.$reference->reference_num);
    							} else {
    								$this->info('Activity Salesman not found ref : '.$reference->reference_num);
    							}
    						}
    						
    						$records = (array)$reference;
    						$exist = DB::connection('sfa_patch')->table($row->table)->where($pk,$reference->{$pk})->first();
    						if(!$exist) {
    							DB::connection('sfa_patch')->table($row->table)->insert($records);
    						}    						
    					}   
    					
    				} else {    					
    					$this->info('Reference data not found '.$row->table.' : '.$row->pk_id.', '. $row->column.' : '.$row->before);    					
    				}
    				 			
    			}
    		}    		
    	}
    }
    
}
