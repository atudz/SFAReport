<?php

use Illuminate\Database\Seeder;
use App\Factories\ModelFactory;

class Task0000716FixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $current_invoice_number = [
            'DCB0008320',
            'DCB0008322',
            'DCB0008323',
            'DCB0008324',
            'DCB0008325',
            'DCB0008326'
        ];

        $new_invoice_number = [
            'DBA26390',
            'DBA26391',
            'DBA26392',
            'DBA26393',
            'DBA26394',
            'DBA26395'
        ];

        for ($counter=0; $counter < count($current_invoice_number); $counter++) {
            if(ModelFactory::getInstance('TxnSalesOrderHeader')->where('salesman_code','=','C06')->where('invoice_number','=',$current_invoice_number[$counter])->count()){
                $sales_order_header = ModelFactory::getInstance('TxnSalesOrderHeader')->where('salesman_code','=','C06')->where('invoice_number','=',$current_invoice_number[$counter])->first();
                $sales_order_header_id = $sales_order_header->sales_order_header_id;
                ModelFactory::getInstance('TxnSalesOrderHeader')->where('sales_order_header_id','=',$sales_order_header_id)->update([
                    'invoice_number' => $new_invoice_number[$counter],
                    'updated_by'     => 1
                ]);

                ModelFactory::getInstance('TableLog')->insert([
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'table'      => 'txn_sales_order_header',
                    'column'     => 'invoice_number',
                    'value'      => $new_invoice_number[$counter],
                    'pk_id'      => $sales_order_header_id,
                    'updated_by' => 1,
                    'before'     => $current_invoice_number[$counter],
                    'comment'    => 'wrong invoice number and inconsistent data upon migration',
                    'report_type' => 'Sales & Collection - Report'
                ]);
            }
        }
    }
}
