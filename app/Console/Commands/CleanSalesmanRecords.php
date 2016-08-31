<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use DB;

class CleanSalesmanRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:pilot_run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean salesman pilot run records';

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
     * get Date range
     */
    public function dateRange()
    {
    	return [
    		(new Carbon('2016-07-30'))->startOfDay(),	
    		(new Carbon('2016-08-26'))->endOfDay(),
    	];
    }
    
    /**
     * Get salesman records
     */
    public function getSalesman()
    {
		return [
			'G02'			
		];    	
    }
   
    /**
     * Get transaction tables
     */
    public function getTransactionTables()
    {
    	return [
    		'txn_activity_salesman'=> [
    			'txn_collection_detail' => 'reference_num',
    			'txn_collection_header' => 'reference_num',
    			'txn_collection_invoice' => 'reference_num',
    			'txn_evaluated_objective' => 'reference_num',
    			'txn_return_detail' => 'reference_num',
    			'txn_return_header' => 'reference_num',
    			'txn_return_header_discount' => 'reference_num',
    			'txn_sales_order_deal' => 'reference_num',
    			'txn_sales_order_detail' => 'reference_num',
    			'txn_sales_order_detail_discount' => 'reference_num',
    			'txn_sales_order_header' => 'reference_num',
    			'txn_sales_order_header_discount' => 'reference_num',
    		],
    			
    		'txn_collection_header'=> [
    			'txn_collection_detail' => 'reference_num',
    			'txn_collection_invoice' => 'reference_num',
    		],
    			
    		'txn_return_header'=> [
    			'txn_return_detail' => 'reference_num',
    			'txn_return_header_discount' => 'reference_num',
    		],
    			
    		'txn_sales_order_header'=> [
    			'txn_sales_order_detail' => 'reference_num',
    			'txn_sales_order_deal' => 'reference_num',
    			'txn_sales_order_header_discount' => 'reference_num',
    			'txn_sales_order_detail_discount' => 'reference_num',
    		],
    			
    		'txn_replenishment_header' => [
    			'txn_replenishment_detail' => 'reference_number',	
    		],
    		'txn_stock_transfer_in_header' => [
    			'txn_stock_transfer_in_detail'=> 'stock_transfer_number',
    		],
    	];
    }
    
    /**
     * Get reference date column
     * @return string[]
     */
    public function getReferenceDateColumn()
    {
    	return [
    		'txn_activity_salesman' => 'start_datetime',
    		'txn_replenishment_header' => 'replenishment_date',
    		'txn_collection_header' => 'or_date',
    		'txn_return_header' => 'return_date',
    		'txn_sales_order_header' => 'so_date',
    		'txn_stock_transfer_in_header' => 'transfer_date',
    	];
    }
    
    /**
     * Get reference date column
     * @return string[]
     */
    public function getPkColumn()
    {
    	return [
    			'txn_activity_salesman' => 'activity_header_id',
    			'txn_replenishment_header' => 'replenishment_header_id',
    			'txn_collection_header' => 'collection_header_id',
    			'txn_return_header' => 'return_header_id',
    			'txn_sales_order_header' => 'sales_order_header_id',
    			'txn_stock_transfer_in_header' => 'stock_transfer_in_header_id',
    	];
    }
    
    /**
     * Get salesman van
     * @param unknown $salesman
     */
    public function getSalesmanVan($salesman)
    {
    	return DB::table('app_salesman_van')->where('salesman_code',$salesman)->lists('van_code');
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //        
    	$salesmanCodes = $this->getSalesman();
    	$dateRange = $this->dateRange();
    	$dateRefCols = $this->getReferenceDateColumn();
    	$pkCols = $this->getPkColumn();
    	
    	$txnTables = $this->getTransactionTables();
    	foreach($txnTables as $table=>$relTable)
    	{
    		if(isset($dateRefCols[$table]) && isset($pkCols[$table]))
    		{
    			$refCol = $dateRefCols[$table];
    			$pkCol = $pkCols[$table];
    			foreach($salesmanCodes as $salesman)
    			{
    				if($table == 'txn_replenishment_header')
    				{
    					$vanCodes = $this->getSalesmanVan($salesman);
		    			$data = DB::table($table)
		    							->whereIn('van_code',$vanCodes)
		    							->whereBetween($refCol,$dateRange)
		    							->whereNotNull('updated_at')
		    							->get();
    				}
    				else
    				{
    					$data = DB::table($table)
			    					->where('salesman_code',$salesman)
			    					->whereBetween($refCol,$dateRange)
			    					->whereNotNull('updated_at')
			    					->get();
    				}
    				
	    			if($data)
	    			{	 
	    				$this->info('Deleting pilot run data for salesman: '.$salesman. ' for table:'.$table);
	    				foreach($data as $value)
	    				{
				    		foreach($relTable as $rTable => $fKey)
				    		{		
				    			DB::table($rTable)->where($fKey,$value->$fKey)->whereNotNull('updated_at')->update(['updated_at'=>NULL,'updated_by'=>0]);
				    		}				    		
				    		if($table == 'txn_replenishment_header')
				    			DB::table($table)->whereIn('van_code',$vanCodes)->where($pkCol,$value->$pkCol)->whereNotNull('updated_at')->update(['updated_at'=>NULL,'updated_by'=>0]);
				    		else 
				    			DB::table($table)->where('salesman_code',$salesman)->where($pkCol,$value->$pkCol)->whereNotNull('updated_at')->update(['updated_at'=>NULL,'updated_by'=>0]);
	    				}	    				
	    			}	    			
    			}
    		}
    		else
    			$this->info('Table date ref or pk column not found for '.$table);
    	}
    }
}
