<?php

use Illuminate\Database\Seeder;

use App\Factories\ModelFactory;
use App\Factories\ControllerFactory;

class TableLogsSalesmanCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = [
            'txn_collection_header',
            'txn_sales_order_header',
            'txn_return_header',
            'txn_evaluated_objective',
            'txn_stock_transfer_in_header',
            'txn_collection_detail',
            'txn_collection_invoice',
            'txn_return_detail',
            'txn_sales_order_deal',
            'txn_sales_order_header_discount',
            'txn_sales_order_detail',
            'txn_stock_transfer_in_detail',
        ];

        foreach ($tables as $table) {
            $records = DB::table('table_logs')->where('table',$table)->get();

            for ($i=0; $i < count($records); $i++) {
                $salesman_code = ControllerFactory::getInstance('Reports')->getSalesmanCode($table,$records[$i]->pk_id);

                ModelFactory::getInstance('TableLog')->where('id',$records[$i]->id)->update([
                    'salesman_code' => $salesman_code
                ]);
            }
        }
    }
}
