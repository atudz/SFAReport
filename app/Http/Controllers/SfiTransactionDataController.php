<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use DB;
use Excel;

class SfiTransactionDataController extends ControllerCore
{
    public function index()
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','sfi-transaction-data')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for SFI Transaction Data'
        ]);

        try{
            $sfi_transactions = $this->getSFITransactionData();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','sfi-transaction-data')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for SFI Transaction Data'
            ]);

            $total = count($sfi_transactions);
            $range = [];
            $from = 0;

            for($i=0;$i < floor($total/1000);$i++)
            {
                $from = $from + 1;
                $to = $from + 999;
                $range[] = [
                    'from' => $from,
                    'to'   => $to
                ];
                $from = $to;
            }

            if($from < $total){
                $range[] = [
                    'from' => $from + 1,
                    'to'   => $total
                ];
            }

            return  response()->json([
                        'success' => true,
                        'data'    => $sfi_transactions->toArray(),
                        'total'   => count($sfi_transactions),
                        'range'   => $range
                    ]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','sfi-transaction-data')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for SFI Transaction Data'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    public function download()
    {
        $navigation = ModelFactory::getInstance('Navigation')->where('slug','=','sfi-transaction-data')->first();
        $type = request()->get('download_type');

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => $navigation->id,
            'action_identifier' => '',
            'action'            => 'preparing ' . $navigation->name . ' for ' . $type . ' download; download proceeding'
        ]);

        $convert = request()->get('convert');
        $sfi_transactions = $this->getSFITransactionData();

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
                            date('mdy',strtotime($record->sales->invoice_date)),
                            date('mdy',strtotime($record->sales->invoice_posting_date)),
                            'DR',
                            $record->sales->company_code,
                            $record->sales->invoice_number,
                            strtoupper($record->sales->van_code . '-' . $record->sales->salesman->salesman_name),
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
                    $salesman = $record->sales->salesman->salesman_name;
                    $salesman_split = explode(", ", $salesman);

                    $salesman = $salesman_split[0];
                    if(count($salesman_split) > 1){
                        $salesman .= ', ' . substr($salesman_split[1], 0,1) . '.';
                    }

                    $gl_accounts = '';
                    if(substr($record->sales->company_code_after, 0,1) == 1){
                        $gl_accounts = '110000';
                    }
                    if(substr($record->sales->company_code_after, 0,1) == 2){
                        $gl_accounts = '110010';
                    }

                    $tax_code = '';
                    if($record->sales->company_code == 1000){
                        $tax_code = '01';
                    }
                    if($record->sales->company_code == 2000){
                        $tax_code = '0X';
                    }

                    fwrite(
                        $file,
                        implode("\t",[
                            '01',
                            $record->sales->company_code_after,
                            $gl_accounts,
                            '',
                            $record->total_sales,
                            $tax_code,
                            '',
                            date('mdy',strtotime($record->sales->invoice_date)),
                            (!is_null($record->sales->customer->area->profit_center) ? $record->sales->customer->area->profit_center->profit_center : ''),
                            strtoupper($record->app_item_master->segment->abbreviation . '-' . $record->sales->customer->customer_name),
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
                            $gl_accounts,
                            '',
                            $record->total_sales,
                            $tax_code,
                            '',
                            date('mdy',strtotime($record->sales->invoice_date)),
                            (!is_null($record->sales->customer->area->profit_center) ? $record->sales->customer->area->profit_center->profit_center : ''),
                            strtoupper($record->app_item_master->segment->abbreviation . '-' . $record->sales->customer->customer_name),
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

    public function getActiveAppCustomers($area_code = '')
    {
        $customer_codes = ModelFactory::getInstance('AppCustomer')->whereNotIn('customer_name',[
                    '1000_Adjustment',
                    '2000_Adjustment',
                    '1000_Van to Warehouse Transaction',
                    '2000_Van to Warehouse Transaction',
                ])->where('status', '=', 'A');

        if(!empty($area_code))
        {
            $customer_codes = $customer_codes->where('area_code','=',$area_code);
        }

        return $customer_codes->orderBy('customer_name')->lists('customer_code');
    }

    public function includedSONumbers()
    {
        $customer_codes = $this->getActiveAppCustomers((request()->has('area_code') ? request()->get('area_code') : ''));
        $so_numbers = ModelFactory::getInstance('TxnSalesOrderHeader')->whereIn('customer_code',$customer_codes);

        if(request()->has('salesman_code')){
            $so_numbers = $so_numbers->where('salesman_code','=',request()->get('salesman_code'));
        }

        if(request()->has('customer_code')){
            $so_numbers = $so_numbers->where('customer_code','=',request()->get('customer_code'));
        }

        if(request()->has('company_code')){
            $so_numbers = $so_numbers->where('customer_code','LIKE','%'.request()->get('company_code').'%');
        }

        if(request()->has('so_date_from') && !request()->has('so_date_to')){
            $so_date_from = date('Y-m-d H:i:s',strtotime(request()->get('so_date_from') . ' 00:00:00'));
            $so_date_from = date('Y-m-d H:i:s',strtotime(request()->get('so_date_from') . ' 23:59:59'));

            $so_numbers = $so_numbers->whereBetween('so_date',[$so_date_from,$so_date_to]);
        }

        if(request()->has('so_date_from') && request()->has('so_date_to')){
            $so_date_from = date('Y-m-d H:i:s',strtotime(request()->get('so_date_from') . ' 00:00:00'));
            $so_date_to = date('Y-m-d H:i:s',strtotime(request()->get('so_date_to') . ' 23:59:59'));

            $so_numbers = $so_numbers->whereBetween('so_date',[$so_date_from,$so_date_to]);
        }

        if(request()->has('posting_date_from')){
            $posting_date_from = date('Y-m-d H:i:s',strtotime(request()->get('posting_date_from') . ' 00:00:00'));
            $posting_date_to = date('Y-m-d H:i:s',strtotime(request()->get('posting_date_from') . ' 23:59:59'));

            $so_numbers = $so_numbers->whereBetween('sfa_modified_date',[$posting_date_from,$posting_date_to]);
        }

        if(request()->has('invoice_number')){
            $so_numbers = $so_numbers->where('invoice_number','LIKE','%'.request()->get('invoice_number').'%');
        }

        return $so_numbers->orderBy('so_number')->lists('so_number');
    }

    public function getSFITransactionData()
    {
        $so_numbers = $this->includedSONumbers();

        $sfi_transactions = ModelFactory::getInstance('TxnSalesOrderDetail')->with([
                'app_item_master' => function ($query) {
                    $query->select('item_code','segment_code');
                },
                'app_item_master.segment' => function ($query) {
                    $query->select('segment_code','abbreviation');
                },
                'sales' => function ($query) {
                    $query->select(
                        'reference_num',
                        'so_number',
                        'customer_code',
                        'van_code',
                        'device_code',
                        'salesman_code',
                        'invoice_number',
                        'so_date as invoice_date',
                        'sfa_modified_date as invoice_posting_date',
                        DB::raw('SUBSTRING_INDEX(customer_code, "_", 1) AS company_code'),
                        DB::raw('SUBSTRING_INDEX(customer_code, "_", -1) AS company_code_after')
                    );
                },
                'sales.customer' => function ($query) {
                    $query->select(
                        'customer_code',
                        'customer_name',
                        DB::raw("IF(address_1='',
                            IF(address_2='',address_3,
                                IF(address_3='',address_2,CONCAT(address_2,' ',address_3))
                                ),
                            IF(address_2='',
                                IF(address_3='',address_1,CONCAT(address_1,' ',address_3)),
                                  IF(address_3='',
                                        CONCAT(address_1,' ',address_2),
                                        CONCAT(address_1,' ',address_2,' ',address_3)
                                    )
                                )
                        ) customer_address"),
                        'area_code'
                    );
                },
                'sales.customer.area' => function ($query) {
                    $query->select('area_code','area_name as area');
                },
                'sales.customer.area.profit_center' => function ($query) {
                    $query->select('area_name','profit_center');
                },
                'sales.salesman' => function ($query) {
                    $query->select('salesman_code','salesman_name');
                },
                'sales.activity_salesman' => function ($query) {
                    $query->select('reference_num','activity_code');
                },
                'sales.activity_salesman.evaluated_objective' => function ($query) {
                    $query->select('reference_num','remarks')->orderBy('sfa_modified_date','DESC')->limit(1);
                },
                'sales.sales_order_header_discount' => function ($query) {
                    $query->select(
                        'reference_num',
                        'ref_no as discount_reference_num',
                        'remarks',
                        'served_deduction_rate'
                    );
                }
            ])
            ->select(
                'so_number',
                'reference_num',
                DB::raw('SUM(gross_served_amount) as gross_served_amount'),
                DB::raw('SUM(vat_amount) as vat_amount'),
                DB::raw('SUM(discount_rate) as discount_rate'),
                DB::raw('SUM(discount_amount) as discount_amount')
            )
            ->distinct()
            ->whereIn('so_number',$so_numbers)
            ->groupBy('reference_num');


        if(request()->has('offset')){
            $sfi_transactions = $sfi_transactions->skip(request()->get('offset'))->take(1000);
        }

        return $sfi_transactions->get();
    }
}