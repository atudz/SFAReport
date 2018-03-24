<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;
use App\Factories\FilterFactory;
use Excel;

class SfiTransactionDataPresenter extends PresenterCore
{
    public function index()
    {
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->salesman = PresenterFactory::getInstance('Reports')->getSalesman(true);
        $this->view->jrSalesmans = PresenterFactory::getInstance('VanInventory')->getJrSalesman();
        $reportsPresenter = PresenterFactory::getInstance('Reports');
        $this->view->areas = $reportsPresenter->getArea();
        $this->view->customers = $reportsPresenter->getCustomer(true,[
            '1000_Adjustment',
            '2000_Adjustment',
            '1000_Van to Warehouse Transaction',
            '2000_Van to Warehouse Transaction',
        ]);
        $this->view->companyCode = $reportsPresenter->getCompanyCode();
        $this->view->navigationActions = PresenterFactory::getInstance('UserAccessMatrix')->getNavigationActions('sfi-transaction-data',$user_group_id,$user_id);
        $this->view->tableHeaders = [
            ['name' => 'SO number'],
            ['name' => 'Reference number'],
            ['name' => 'Activity Code'],
            ['name' => 'Customer Code'],
            ['name' => 'Customer Name'],
            ['name' => 'Customer Address'],
            ['name' => 'Remarks'],
            ['name' => 'Van Code'],
            ['name' => 'Device Code'],
            ['name' => 'Salesman Code'],
            ['name' => 'Salesman Name'],
            ['name' => 'Area'],
            ['name' => 'Invoice No/ Return Slip No.'],
            ['name' => 'Invoice Date/ Return Date'],
            ['name' => 'Invoice/Return Posting Date'],
            ['name' => 'Taxable Amount'],
            ['name' => 'Vat Amount'],
            ['name' => 'Discount Rate Per Item'],
            ['name' => 'Discount Amount Per Item'],
            ['name' => 'Collective Discount Rate'],
            ['name' => 'Collective Discount Amount'],
            ['name' => 'Reference No.'],
            ['name' => 'Remarks'],
            ['name' => 'Total Sales'],
            ['name' => 'Segment'],
            ['name' => 'Segment Abbr.'],
            ['name' => 'Document Type'],
            ['name' => 'Company Code'],
            ['name' => 'Header Text'],
            ['name' => 'GL Account'],
            ['name' => 'Tax Code'],
            ['name' => 'PROFIT CENTER'],
            ['name' => 'DETAIL TEXT']
        ];

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => $user_id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','sfi-transaction-data')->value('id'),
            'action_identifier' => 'visit',
            'action'            => 'visit SFI Transaction Data'
        ]);

        return $this->view('index');
    }
    
    /**
     * Get sfi transaction data
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSfiTransactionData()
    {
    	$prepare = $this->getPreparedSfiTransactionData();
    	
    	$presenter = PresenterFactory::getInstance('Reports');
    	$result = $presenter->paginate($prepare);
    	$data['records'] = $presenter->validateInvoiceNumber($result->items());
    	
    	$data['summary'] = '';
    	$data['total'] = $result->total();
    	
    	if(!empty($data['records'])){
    		foreach ($data['records'] as $key => $value) {
    			$data['records'][$key]->invoice_number_updated = '';
    			$data['records'][$key]->invoice_date_updated = '';
    			$data['records'][$key]->invoice_posting_date_updated = '';
    			$data['records'][$key]->delete_remarks_updated = '';
    			$data['records'][$key]->has_delete_remarks = '';
    			if(!empty($value->invoice_pk_id) || !is_null($value->invoice_pk_id)){
    				$data['records'][$key]->invoice_number_updated = ModelFactory::getInstance('TableLog')->where('table','=',$value->invoice_table)->where('column','=',$value->invoice_number_column)->where('pk_id','=',$value->invoice_pk_id)->count() ? 'modified' : '';
    				$data['records'][$key]->invoice_date_updated = ModelFactory::getInstance('TableLog')->where('table','=',$value->invoice_table)->where('column','=',$value->invoice_date_column)->where('pk_id','=',$value->invoice_pk_id)->count() ? 'modified' : '';
    				$data['records'][$key]->invoice_posting_date_updated = ModelFactory::getInstance('TableLog')->where('table','=',$value->invoice_table)->where('column','=',$value->invoice_posting_date_column)->where('pk_id','=',$value->invoice_pk_id)->count() ? 'modified' : '';
    				$data['records'][$key]->delete_remarks_updated = ModelFactory::getInstance('TableLog')->where('table','=',$value->invoice_table)->where('column','=','delete_remarks')->where('pk_id','=',$value->invoice_pk_id)->count() ? 'modified' : '';
    				$data['records'][$key]->has_delete_remarks = ($data['records'][$key]->delete_remarks_updated == 'modified' ? 'has-deleted-remarks' : '');
    			}
    			
    			$customer_code_info = explode('_', $value->customer_code);
    			$data['records'][$key]->closed_period = !empty(PresenterFactory::getInstance('OpenClosingPeriod')->periodClosed($customer_code_info[0],15,date('n',strtotime($value->invoice_posting_date)),date('Y',strtotime($value->invoice_posting_date)))) ? 1 : 0;
    		}
    	}
    	
    	return response()->json($data);
    }
    
    /**
     * Get sfi transaction data prepared statement
     * @param string $summary
     * @return unknown
     */
    public function getPreparedSfiTransactionData($summary=false)
    {
    	$querySales = '
    			SELECT
				all_so.so_number,
    			tas.reference_num,
				tas.activity_code,
				all_so.customer_code,
				ac.customer_name,
    			IF(ac.address_1=\'\',
	    				IF(ac.address_2=\'\',ac.address_3,
	    					IF(ac.address_3=\'\',ac.address_2,CONCAT(ac.address_2,\', \',ac.address_3))
	    					),
	    				IF(ac.address_2=\'\',
	    					IF(ac.address_3=\'\',ac.address_1,CONCAT(ac.address_1,\', \',ac.address_3)),
	    					  IF(ac.address_3=\'\',
	    							CONCAT(ac.address_1,\', \',ac.address_2),
	    							CONCAT(ac.address_1,\', \',ac.address_2,\', \',ac.address_3)
	    						)
	    					)
	    		  ) customer_address,
    			remarks.remarks,
			    all_so.van_code,
				all_so.device_code,
				all_so.salesman_code,
				aps.salesman_name,
    			aa.area_code,
				aa.area_name area,
                all_so.invoice_number,
				all_so.delete_remarks,
				all_so.so_date invoice_date,
				all_so.sfa_modified_date invoice_posting_date,
				TRUNCATE(ROUND(coalesce(all_so.gross_served_amount,0.00),2),2) gross_served_amount,
    			TRUNCATE(ROUND(coalesce(all_so.vat_amount,0.00),2),2) vat_amount,
				CONCAT(TRUNCATE(coalesce(all_so.discount_rate,0.00),0),\'%\') discount_rate,
    			TRUNCATE(ROUND(coalesce(all_so.discount_amount,0.00),2),2) discount_amount,
			    CONCAT(TRUNCATE(coalesce(all_so.collective_discount_rate,0.00),0),\'%\') collective_discount_rate,
    			TRUNCATE(ROUND(coalesce(all_so.collective_discount_amount,0.00),2),2) collective_discount_amount,
			    all_so.discount_reference_num,
			    all_so.discount_remarks,
    			TRUNCATE(coalesce(all_so.total_sales,0.00),2) total_invoice,
				aim.segment_code,
				sc.abbreviation segment_abbr,
				\'DR\' document_type ,
				substr(all_so.customer_code,1,4) company_code,
				CONCAT(substr(all_so.customer_code,1,4) ,\'-\',ac.customer_name) header_text,
				IF(substr(all_so.customer_code,1,1) = \'1\', \'110000\',\'110010\') gl_account,
				IF(substr(all_so.customer_code,1,4) = \'1000\', \'O1\',\'OX\') tax_code,
				pc.profit_center,
				CONCAT(aim.segment_code,\'-\',ac.customer_name) detail_text,
    			
				IF(all_so.updated =\'modified\',\'modified\',\'\') updated,
    			
				\'txn_sales_order_header\' invoice_table,
				\'invoice_number\' invoice_number_column,
				\'so_date\' invoice_date_column,
				\'sfa_modified_date\' invoice_posting_date_column,
    			all_so.sales_order_header_id invoice_pk_id,
				\'\' condition_code_table,
				\'\' condition_code_column,
				0 condition_code_pk_id
    			
    			
				FROM
    			(
    				 -- For SO Regular Skus --
						 select
    							tsoh.sales_order_header_id,
    							tsoh.so_number,
								tsoh.reference_num,
    							tsoh.customer_code,
								tsoh.salesman_code,
				    			tsoh.van_code,
								tsoh.device_code,
								tsoh.sfa_modified_date,
								tsoh.invoice_number,
                                tsoh.delete_remarks,
    							tsoh.so_date,
    							SUM(tsod.gross_served_amount) gross_served_amount,
								SUM(tsod.vat_amount) vat_amount,
								SUM(tsod.discount_rate) discount_rate,
								SUM(tsod.discount_amount) discount_amount,
    							tsohd.served_deduction_rate collective_discount_rate,
    							SUM(coalesce((tsod.gross_served_amount + tsod.vat_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) collective_discount_amount,
			    				tsohd.ref_no discount_reference_num,
			    				tsohd.remarks discount_remarks,
								tsod.item_code,
                                SUM( coalesce( (tsod.gross_served_amount + tsod.vat_amount),0.00 ) - (discount_amount + coalesce((tsod.gross_served_amount + tsod.vat_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) ) total_sales,
    							IF(SUM(tsoh.updated_by),\'modified\', IF(SUM(tsod.updated_by),\'modified\', \'\')) updated
    			
								from txn_sales_order_header tsoh
								inner join txn_sales_order_detail tsod
								on tsoh.reference_num = tsod.reference_num
								and tsoh.salesman_code = tsod.modified_by -- added to bypass duplicate refnums
    							left join (
    								select
    									reference_num,
    									served_deduction_rate,
			    						ref_no,
			    						remarks,
    									sum(coalesce(served_deduction_amount,0)) served_deduction_amount
										from txn_sales_order_header_discount
    									where deduction_code <> \'EWT\'
										group by reference_num
    							) tsohd on tsoh.reference_num = tsohd.reference_num
    							group by tsoh.so_number
    			
    			
							union all
    			
							-- For SO Deals --
								select
    							tsoh.sales_order_header_id,
    							tsoh.so_number,
								tsoh.reference_num,
    							tsoh.customer_code,
								tsoh.salesman_code,
				    			tsoh.van_code,
								tsoh.device_code,
								tsoh.sfa_modified_date,
								tsoh.invoice_number,
                                tsoh.delete_remarks,
    							tsoh.so_date,
    							SUM(tsodeal.gross_served_amount) gross_served_amount,
								SUM(tsodeal.vat_served_amount) vat_amount,
								0.00 discount_rate,
								0.00 discount_amount,
    							tsohd.served_deduction_rate collective_discount_rate,
    							SUM(coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) collective_discount_amount,
			    				tsohd.ref_no discount_reference_num,
			    				tsohd.remarks discount_remarks,
								tsodeal.item_code,
								SUM(coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)-coalesce((tsodeal.gross_served_amount + tsodeal.vat_served_amount),0.00)*(coalesce(tsohd.served_deduction_rate,0.00)/100)) total_sales,
    							IF(SUM(tsoh.updated_by),\'modified\', IF(SUM(tsodeal.updated_by),\'modified\', \'\')) updated
    			
								from txn_sales_order_header tsoh
								inner join txn_sales_order_deal tsodeal
								on tsoh.reference_num = tsodeal.reference_num
    							left join (
    								select
    									reference_num,
    									served_deduction_rate,
			    						ref_no,
			    						remarks,
    									sum(coalesce(served_deduction_amount,0)) served_deduction_amount
										from txn_sales_order_header_discount
    									where deduction_code <> \'EWT\'
										group by reference_num
    							) tsohd on tsoh.reference_num = tsohd.reference_num
    							group by tsoh.so_number
    			
    			) all_so
				LEFT JOIN app_customer ac ON(ac.customer_code=all_so.customer_code)
				LEFT JOIN app_area aa ON(ac.area_code=aa.area_code)
				LEFT JOIN profit_centers pc ON(aa.area_code=pc.area_code)
				LEFT JOIN app_salesman aps ON(aps.salesman_code=all_so.salesman_code)
				LEFT JOIN app_item_master aim ON(aim.item_code=all_so.item_code)
				LEFT JOIN segment_codes sc ON(sc.segment_code=aim.segment_code)
				LEFT JOIN txn_activity_salesman tas ON(tas.reference_num=all_so.reference_num AND tas.salesman_code=all_so.salesman_code)
    			LEFT JOIN (
    				select reference_num,remarks from txn_evaluated_objective  group by reference_num order by sfa_modified_date desc
    			) remarks ON(remarks.reference_num = tas.reference_num)
				';
    	
    	$queryReturns = '
    			SELECT
				trh.return_txn_number so_number,
    			trh.reference_num,
				tas.activity_code,
				trh.customer_code,
				ac.customer_name,
    			IF(ac.address_1=\'\',
	    				IF(ac.address_2=\'\',ac.address_3,
	    					IF(ac.address_3=\'\',ac.address_2,CONCAT(ac.address_2,\', \',ac.address_3))
	    					),
	    				IF(ac.address_2=\'\',
	    					IF(ac.address_3=\'\',ac.address_1,CONCAT(ac.address_1,\', \',ac.address_3)),
	    					  IF(ac.address_3=\'\',
	    							CONCAT(ac.address_1,\', \',ac.address_2),
	    							CONCAT(ac.address_1,\', \',ac.address_2,\', \',ac.address_3)
	    						)
	    					)
	    		  ) customer_address,
    			remarks.remarks,
				trh.van_code,
				trh.device_code,
				trh.salesman_code,
				aps.salesman_name,
    			aa.area_code,
				aa.area_name area,
                trh.return_slip_num invoice_number,
				trh.delete_remarks,
				trh.return_date invoice_date,
				trh.sfa_modified_date invoice_posting_date,
    			(-1 * TRUNCATE(ROUND(SUM(coalesce(trd.gross_amount,0.00)),2),2)) gross_served_amount,
    			(-1 * TRUNCATE(ROUND(SUM(coalesce(trd.vat_amount,0.00)),2),2)) vat_amount,
				CONCAT(0,\'%\') discount_rate,
    			(-1 * TRUNCATE(ROUND(SUM(coalesce(trd.discount_amount,0.00)),2),2)) discount_amount,
				CONCAT(TRUNCATE(coalesce(trhd.deduction_rate,0.00),0),\'%\') collective_discount_rate,
			    (-1 * TRUNCATE(ROUND(coalesce(trhd.served_deduction_amount,0.00),2),2)) collective_discount_amount,
			    trhd.ref_no discount_reference_num,
			    trhd.remarks discount_remarks,
			    (-1 * TRUNCATE(ROUND((SUM((coalesce(trd.gross_amount,0.00) + coalesce(trd.vat_amount,0.00)) - coalesce(trd.discount_amount,0.00)) - coalesce(trhd.served_deduction_amount,0.00)),2),2)) total_invoice,
				aim.segment_code,
				sc.abbreviation segment_abbr,
				\'DR\' document_type ,
				substr(ac.customer_code,1,4) company_code,
				CONCAT(substr(ac.customer_code,1,1),\'-\',ac.customer_name) header_text,
				IF(substr(ac.customer_code,1,1) = \'1\', \'110000\',\'110010\') gl_account,
				IF(substr(ac.customer_code,1,4) = \'1000\', \'O1\',\'OX\') tax_code,
				pc.profit_center,
				CONCAT(aim.segment_code,\'-\',ac.customer_name) detail_text,
			    IF(SUM(trh.updated_by),\'modified\',IF(SUM(trd.updated_by),\'modified\',\'\')) updated,
    			
			    \'txn_return_header\' invoice_table,
				\'return_slip_num\' invoice_number_column,
				\'return_date\' invoice_date_column,
				\'sfa_modified_date\' invoice_posting_date_column,
    			trh.return_header_id invoice_pk_id,
				\'txn_return_detail\' condition_code_table,
				\'condition_code\' condition_code_column,
				trd.return_detail_id condition_code_pk_id
    			
    		FROM txn_return_header trh
			LEFT JOIN app_customer ac ON(ac.customer_code=trh.customer_code)
			LEFT JOIN app_area aa ON(aa.area_code=ac.area_code)
			LEFT JOIN profit_centers pc ON(aa.area_code=pc.area_code)
			LEFT JOIN app_salesman aps ON(aps.salesman_code=trh.salesman_code)
			LEFT JOIN txn_activity_salesman tas ON(tas.salesman_code=trh.salesman_code AND tas.reference_num=trh.reference_num)
			LEFT JOIN txn_return_detail trd ON(trh.reference_num=trd.reference_num)
			LEFT JOIN app_item_master aim ON(aim.item_code=trd.item_code)
			LEFT JOIN segment_codes sc ON(sc.segment_code=aim.segment_code)
    		LEFT JOIN
    		(
    			select
    				reference_num,
			    	ref_no,
			    	remarks,
    				deduction_rate,
    				sum(coalesce(deduction_amount,0)) served_deduction_amount
					from  txn_return_header_discount
    				where deduction_code  <> \'EWT\'
					group by reference_num
    		) trhd ON(trhd.reference_num=trh.reference_num)
    			
    		LEFT JOIN (
    				select reference_num,remarks from txn_evaluated_objective  group by reference_num order by sfa_modified_date desc
    		) remarks ON(remarks.reference_num = trh.reference_num)
    			
    		GROUP BY trh.return_txn_number
				';
    	
    	$select = '
    			sales.so_number,
    			sales.reference_num,
				sales.activity_code,
				sales.customer_code,
				sales.customer_name,
    			sales.customer_address,
    			sales.remarks,
			    sales.van_code,
				sales.device_code,
				sales.salesman_code,
				sales.salesman_name,
				sales.area,
                sales.invoice_number,
				sales.delete_remarks,
				sales.invoice_date,
				sales.invoice_posting_date,
				sales.gross_served_amount,
				sales.vat_amount,
				sales.discount_rate,
				sales.discount_amount,
			    sales.collective_discount_rate,
			    sales.collective_discount_amount,
			    sales.discount_reference_num,
			    sales.discount_remarks,
			    sales.total_invoice,
				sales.segment_code,
				sales.segment_abbr,
				sales.document_type,
				sales.company_code,
				UPPER(sales.header_text) header_text,
				sales.gl_account,
				sales.tax_code,
				sales.profit_center,
				UPPER(sales.detail_text) detail_text,
				sales.updated,
				sales.invoice_table,
				sales.invoice_number_column,
				sales.invoice_date_column,
				sales.invoice_posting_date_column,
    			sales.invoice_pk_id,
				sales.condition_code_table,
				sales.condition_code_column,
				sales.condition_code_pk_id
    			';
    	
    	if($summary)
    	{
    		$select = '
    			   TRUNCATE(ROUND(SUM(sales.gross_served_amount),2),2) gross_served_amount,
    			   TRUNCATE(ROUND(SUM(sales.discount_amount),2),2) discount_amount,
				   TRUNCATE(ROUND(SUM(sales.vat_amount),2),2) vat_amount,
    			   TRUNCATE(ROUND(SUM(sales.collective_discount_amount),2),2) collective_discount_amount,
				   TRUNCATE(ROUND(SUM(sales.total_invoice),2),2) total_invoice
    			';
    	}
    	
    	$prepare = \DB::table(\DB::raw('('.$querySales.' UNION '.$queryReturns.') sales'))
    	->selectRaw($select);
    	
    	$salesmanFilter = FilterFactory::getInstance('Select');
    	$prepare = $salesmanFilter->addFilter($prepare,'salesman_code',
    			function($self, $model){
    				return $model->where('sales.salesman_code','=',$self->getValue());
    			});
    	
    	$areaFilter = FilterFactory::getInstance('Select');
    	$prepare = $areaFilter->addFilter($prepare,'area',
    			function($self, $model){
    				return $model->where('sales.area_code','=',$self->getValue());
    			});
    	
    	$companyCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $companyCodeFilter->addFilter($prepare,'company_code',
    			function($self, $model){
    				return $model->where('sales.customer_code','like',$self->getValue().'%');
    			});
    	
    	$invoiceNumFilter = FilterFactory::getInstance('Text');
    	$prepare = $invoiceNumFilter->addFilter($prepare,'invoice_number',
    			function($self, $model){
    				return $model->where('sales.invoice_number','LIKE','%'.$self->getValue().'%');
    			});
    	
    	$customerFilter = FilterFactory::getInstance('Select');
    	$prepare = $customerFilter->addFilter($prepare,'customer',
    			function($self, $model){
    				return $model->where('sales.customer_code','=',$self->getValue());
    			});
    	
    	$itemCodeFilter = FilterFactory::getInstance('Select');
    	$prepare = $itemCodeFilter->addFilter($prepare,'item_code',
    			function($self, $model){
    				return $model->where('sales.item_code','=',$self->getValue());
    			});
    	
    	$invoiceDateFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $invoiceDateFilter->addFilter($prepare,'invoice_date',
    			function($self, $model){
    				return $model->whereBetween(\DB::raw('DATE(sales.invoice_date)'),$self->formatValues($self->getValue()));
    			});
    	
    	$postingFilter = FilterFactory::getInstance('DateRange');
    	$prepare = $postingFilter->addFilter($prepare,'posting_date',
    			function($self, $model){
    				return $model->whereBetween(\DB::raw('DATE(sales.invoice_posting_date)'),$self->formatValues($self->getValue()));
    			});
    	
    	$prepare->orderBy('sales.invoice_date', 'desc');
    	
    	if(!$this->hasAdminRole() && auth()->user())
    	{
    		$codes = $this->getAlikeAreaCode(auth()->user()->location_assignment_code);
    		$prepare->whereIn('sales.area_code',$codes);
    	}
    	
    	if($this->isSalesman())
    	{
    		$prepare->where('sales.salesman_code',auth()->user()->salesman_code);
    	}
    	
    	if(!$this->request->has('sort'))
    	{
    		$prepare->orderBy('sales.invoice_date','desc');
    		$prepare->orderBy('sales.invoice_number');
    	}
    	
    	return $prepare;
    }
    
    /**
     * Download
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download($type)
    {
    	$navigation = ModelFactory::getInstance('Navigation')->where('slug','=','sfi-transaction-data')->first();
    	
    	ModelFactory::getInstance('UserActivityLog')->create([
    			'user_id'           => auth()->user()->id,
    			'navigation_id'     => $navigation->id,
    			'action_identifier' => '',
    			'action'            => 'preparing ' . $navigation->name . ' for ' . $type . ' download; download proceeding'
    	]);
    	
    	$convert = request()->get('convert');
    	$sfi_transactions = $this->getPreparedSfiTransactionData()->get();
    	
    	ModelFactory::getInstance('UserActivityLog')->create([
    			'user_id'           => auth()->user()->id,
    			'navigation_id'     => $navigation->id,
    			'action_identifier' => 'downloading',
    			'action'            => 'preparation done ' . $navigation->name . ' for ' . $type . ' download; download proceeding'
    	]);
    	
    	if($type == 'xlsx'){
    		
    		Excel::create('SFITransaction', function($excel) use ($sfi_transactions,$convert){
    			$data = [
    					'records' => $sfi_transactions
    			];
    			if($convert == 'header' || $convert == 'both'){
    				$excel->sheet('SAP HEADER', function($sheet) use ($data){
    					$sheet->loadView('SfiTransactionData.header',$data);
    				});
    			}
    			if($convert == 'detail' || $convert == 'both'){
    				$excel->sheet('SAP DETAIL', function($sheet) use ($data){
    					$sheet->loadView('SfiTransactionData.detail',$data);
    				});
    			}
    		})->download($type);
    	}
    	
    	if($type == 'txt'){
    		$file_name = '';
    		switch ($convert) {
    			case 'header':
    				$file_name = 'SAP-HEADER.txt';
    				break;
    				
    			case 'detail':
    				$file_name = 'SAP-DETAIL.txt';
    				break;
    				
    			default:
    				$file_name = 'SAP-HEADER-AND-DETAIL.txt';
    				break;
    		}
    		
    		$file = fopen($file_name,'w');
    		
    		if($convert == 'header' || $convert == 'both'){
    			fwrite(
    					$file,
    					implode("\t",[
    							'Document Date',
    							'Posting Date',
    							'Document Type',
    							'Company Code',
    							'Reference',
    							'Header Text',
    							'REF',
    							'SEND',
    					]) . "\n"
    					);
    			
    			foreach ($sfi_transactions as $index => $record) {
    				fwrite(
    						$file,
    						implode("\t",[
    								date('mdy',strtotime($record->invoice_date)),
    								date('mdy',strtotime($record->invoice_posting_date)),
    								$record->document_type,
    								$record->company_code,
    								$record->invoice_number,
    								$record->header_text,
    								$index + 1,
    								''
    						]) . "\n"
    						);
    			}
    		}
    		
    		if($convert == 'both'){
    			fwrite($file,"\n");
    			fwrite($file,"\n");
    			fwrite($file,"\n");
    			fwrite($file,"\n");
    			fwrite($file,"\n");
    		}
    		
    		if($convert == 'detail' || $convert == 'both'){
    			fwrite(
    					$file,
    					implode("\t",[
    							'POSTINGKEY',
    							'ACCOUNT',
    							'GL Account',
    							'SPECIALGLINDICATOR',
    							'AMOUNT',
    							'Tax Code',
    							'COSTCENTER',
    							'BASELINEDATE',
    							'PROFIT CENTER',
    							'TEXT',
    							'ASSIGNMENT',
    							'Business Area',
    							'Contract Number',
    							'COntract Type',
    							'VBEWA',
    							'REF',
    							'SEND',
    					]) . "\n"
    					);
    			
    			foreach ($sfi_transactions as $index => $record) {
    				$salesman = $record->salesman_name;
    				$salesman_split = explode(", ", $salesman);
    				
    				$salesman = $salesman_split[0];
    				if(count($salesman_split) > 1){
    					$salesman .= ', ' . substr($salesman_split[1], 0,1) . '.';
    				}
    				
    				fwrite(
    						$file,
    						implode("\t",[
    								'01',
    								str_replace(['1000_','2000_'],'',$record->customer_code),
    								$record->gl_account,
    								'',
    								$record->total_invoice,
    								$record->tax_code,
    								'',
    								date('mdy',strtotime($record->invoice_date)),
    								$record->profit_center,
    								$record->detail_text,
    								$salesman,
    								'',
    								'',
    								'',
    								'',
    								$index + 1,
    								''
    						]) . "\n"
    						);
    				
    				fwrite(
    						$file,
    						implode("\t",[
    								'50',
    								'400000',
    								$record->gl_account,
    								'',
    								$record->total_invoice,
    								$record->tax_code,
    								'',
    								date('mdy',strtotime($record->invoice_date)),
    								$record->profit_center,
    								$record->detail_text,
    								$salesman,
    								'',
    								'',
    								'',
    								'',
    								$index + 1,
    								''
    						]) . "\n"
    						);
    				
    			}
    		}
    		
    		return response()->download($file_name,$file_name)->deleteFileAfterSend(true);
    	}
    }
}