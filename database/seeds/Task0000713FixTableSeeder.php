<?php

use Illuminate\Database\Seeder;
use App\Factories\ModelFactory;

class Task0000713FixTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(ModelFactory::getInstance('TxnSalesOrderHeader')->where('sales_order_header_id','=','101869')->where('invoice_number','=','DCB0008348')->count()){
            ModelFactory::getInstance('TxnSalesOrderHeader')->where('sales_order_header_id','=','101869')->update([
                'invoice_number' => 'COR013315',
                'updated_by'     => 1
            ]);

            ModelFactory::getInstance('TableLog')->insert([
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'table'      => 'txn_sales_order_header',
                'column'     => 'invoice_number',
                'value'      => 'COR013315',
                'pk_id'      => 101869,
                'updated_by' => 1,
                'before'     => 'DCB0008348',
                'comment'    => 'wrong invoice number and inconsistent data upon migration',
                'report_type' => 'Sales & Collection - Report'
            ]);
        }
    }
}
