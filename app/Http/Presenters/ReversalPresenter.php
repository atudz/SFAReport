<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\FilterFactory;
use DB;


class ReversalPresenter extends PresenterCore
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reportsPresenter = PresenterFactory::getInstance('Reports');
    	$this->view->salesman = $reportsPresenter->getSalesman(true);
    	$this->view->tableHeaders = $this->getSummaryReversalColumns();
    	$this->view->areas = $reportsPresenter->getArea(true);
    	$this->view->customers = $reportsPresenter->getCustomer();

    	return $this->view('index');
    }


    /**
     * Get cash payments
     * @return string[][]
     */
    public function getSummaryReversalColumns()
    {
    	$headers = [
    			['name'=>'Reversal No.','sort'=>'revision_number'],
    			['name'=>'Reversal Date','sort'=>'created_at'],
    			['name'=>'Type of Report','sort'=>'report_type'],
    			['name'=>'Area'],
    			['name'=>'Salesman Name'],
    			['name'=>'Original','sort'=>'before'],
    			['name'=>'Edited','sort'=>'value'],
    			['name'=>'Reason of Reversal','sort'=>'comment'],
    			['name'=>'Username','sort'=>'username'],
    	];

    	return $headers;
    }


    /**
     * Get Cash Payment Select Columns
     * @return string[][]
     */
    function getSummaryReversalSelectColumns()
    {
    	return [
    			'revision_number',
    			'created_at',
    			'report_type',
    			'area_name',
    			'salesman_name',
    			'before',
    			'value',
    			'comment',
    			'username',
    	];
    }

    /**
     * get Cash Payment Filter Data
     * @return string[]|unknown[]
     */
    public function getSummaryReversalFilterData()
    {
    	$reportPresenter = PresenterFactory::getInstance('Reports');
    	$report = $this->request->get('report') ? get_reports()[$this->request->get('report')] : 'All';
    	$branch = $this->request->get('branch') ? $reportPresenter->getArea()[$this->request->get('branch')] : 'All';
    	$user = $this->request->get('updated_by') ? get_users(false)[$this->request->get('updated_by')] : 'All';
    	$mDate = ($this->request->get('created_at_from') && $this->request->get('created_at_to')) ? $this->request->get('created_at_from').' - '.$this->request->get('created_at_to') : 'All';
    	$revision = $this->request->get('revision') ?  $this->request->get('revision') : 'All';

    	$filters = [
    			'Report' => $report,
    			'Branch' => $branch,
    			'User' => $user,
    			'Modified Date' => $mDate,
    			'Revision' => $revision,
    	];

    	return $filters;
    }

    /**
     * Get summary of reversal report
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSummaryReversalReport()
    {
    	$prepare = $this->getPreparedSummaryReversal();
    	$result = $this->paginate($prepare);

    	$records = $this->addSalesmanDetails($result->items());
    	$data['records'] = $records;
    	$data['total'] = $result->total();
    	return response()->json($data);
    }

    /**
     * Add salesman details
     * @param unknown $records
     */
    public function addSalesmanDetails($records)
    {
    	foreach($records as $record)
    	{
    		$syncTables = config('sync.sync_tables');
    		$pkColumn = array_shift($syncTables[$record->table]);
    		if(!$pkColumn)
    			continue;

    		switch($record->table)
    		{
    			case 'txn_collection_header':
    			case 'txn_sales_order_header':
    			case 'txn_return_header':
    			case 'txn_evaluated_objective':
    			case 'txn_stock_transfer_in_header':
    				$row = DB::table($record->table)->where($pkColumn,$record->pk_id)->first();
    				if($row)
    				{
    					$details = $this->getSalesmanDetails($row->salesman_code);
    					if($details)
    					{
    						$record->salesman_name = $details->salesman_name;
    						$record->area_name = $details->area_name;
    					}
    				}
    				break;
    			case 'txn_collection_detail':
    			case 'txn_collection_invoice':
    				$row = DB::table($record->table)
		    					->select('txn_collection_header.salesman_code')
		    					->join('txn_collection_header','txn_collection_header.reference_num','=',$record->table.'.reference_num')
		    					->where($record->table.'.'.$pkColumn,$record->pk_id)
		    					->first();
    				if($row)
    				{
    					$details = $this->getSalesmanDetails($row->salesman_code);
    					if($details)
    					{
    						$record->salesman_name = $details->salesman_name;
    						$record->area_name = $details->area_name;
    					}
    				}
    				break;
    			case 'txn_return_detail':
    				$row = DB::table($record->table)
    						->select('txn_return_header.salesman_code')
	    					->join('txn_return_header','txn_return_header.reference_num','=',$record->table.'.reference_num')
	    					->where($record->table.'.return_detail_id',$record->pk_id)
	    					->first();
    				if($row)
    				{
    					$details = $this->getSalesmanDetails($row->salesman_code);
    					if($details)
    					{
    						$record->salesman_name = $details->salesman_name;
    						$record->area_name = $details->area_name;
    					}

    				}
    				break;
    			case 'txn_sales_order_deal':
    			case 'txn_sales_order_detail':
    			case 'txn_sales_order_header_discount':
    			case 'txn_sales_order_detail':
    				$row = DB::table($record->table)
	    					->select('txn_sales_order_header.salesman_code')
	    					->join('txn_sales_order_header','txn_sales_order_header.reference_num','=',$record->table.'.reference_num')
	    					->where($record->table.'.'.$pkColumn,$record->pk_id)
	    					->first();
    				if($row)
    				{
    						$details = $this->getSalesmanDetails($row->salesman_code);
    						if($details)
    						{
    							$record->salesman_name = $details->salesman_name;
    							$record->area_name = $details->area_name;
    						}

    				}
    				break;
    			case 'txn_stock_transfer_in_detail':
    				$row = DB::table($record->table)
	    					->select('txn_stock_transfer_in_header.salesman_code')
	    					->join('txn_stock_transfer_in_header','txn_stock_transfer_in_header.stock_transfer_number','=',$record->table.'.stock_transfer_number')
	    					->where($record->table.'.stock_transfer_in_detail_id',$record->pk_id)
	    					->first();
    				if($row)
    				{
    					$details = $this->getSalesmanDetails($row->salesman_code);
    					if($details)
    					{
    						$record->salesman_name = $details->salesman_name;
    						$record->area_name = $details->area_name;
    					}

    				}
    				break;
    		}
    	}
    	return $records;
    }

    public function getSalesmanDetails($salesmanCode, $select='app_salesman.salesman_name,app_area.area_name')
    {

    	return \DB::table('app_salesman')
			    	->selectRaw($select)
			    	->leftJoin('app_salesman_customer','app_salesman_customer.salesman_code','=','app_salesman.salesman_code')
			    	->leftJoin('app_customer','app_customer.customer_code','=','app_salesman_customer.customer_code')
			    	->leftJoin('app_area','app_area.area_code','=','app_customer.area_code')
			    	->where('app_salesman_customer.status','=','A')
			    	->where('app_customer.status','=','A')
			    	->where('app_area.status','=','A')
			    	->where('app_salesman.salesman_code','=',$salesmanCode)
			    	->groupBy('app_salesman.salesman_code')
			    	->groupBy('app_salesman.salesman_name')
			    	->groupBy('app_area.area_code')
			    	->first();
    }

    /**
     * Get prepared statement summary of reversal
     * @return unknown
     */
    public function getPreparedSummaryReversal()
    {
    	$select = '
    			   report_revisions.revision_number,
    			   table_logs.created_at,
    			   table_logs.report_type,
    			   table_logs.table,
                   table_logs.pk_id,
    			   table_logs.salesman_code,
    			   CONCAT(user.firstname,\' \',user.lastname) username,
    			   table_logs.before,
    			   table_logs.value,
    		 	   table_logs.comment,
    			   \'\' salesman_name,
    			   \'\' area_name
    			';

    	$prepare = \DB::table('report_revisions')
    					->selectRaw($select)
    					->leftJoin('table_logs','table_logs.id','=','report_revisions.table_log_id')
				    	->leftJoin('user','user.id','=','table_logs.updated_by');

        $salesmanFilter = FilterFactory::getInstance('Select');
        $prepare = $salesmanFilter->addFilter($prepare,'salesman',
                function($self, $model){
                    return $model->where('table_logs.salesman_code','=',$self->getValue());
                });

    	$reportFilter = FilterFactory::getInstance('Select');
    	$prepare = $reportFilter->addFilter($prepare,'report',
    			function($self, $model){
    				return $model->where('report_revisions.report',$self->getValue());
    			});

    	$branchFilter = FilterFactory::getInstance('Text');
    	$prepare = $branchFilter->addFilter($prepare,'branch',
    			function($self, $model){
    				return $model->where('user.location_assignment_code',$self->getValue());
    			});

    	$userFilter = FilterFactory::getInstance('Select');
    	$prepare = $userFilter->addFilter($prepare,'updated_by',
    			function($self, $model){
    				return $model->where('table_logs.updated_by',$self->getValue());
    			});

    	$mDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $mDateFilter->addFilter($prepare,'created_at',
    			function($self, $model){
    				return $model->whereBetween('table_logs.created_at',$self->formatValues($self->getValue()));
    			});

    	$revNumFilter = FilterFactory::getInstance('Date');
    	$prepare = $revNumFilter->addFilter($prepare,'revision',
    			function($self, $model){
    				return $model->where('report_revisions.revision_number','LIKE','%'.$self->getValue().'%');
    			});

    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('table_logs.created_at','desc');
    	}

    	$prepare->whereNull('user.deleted_at');

    	return $prepare;
    }
}
