<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Factories\ModelFactory;

class FixTableLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $logs = ModelFactory::getInstance('TableLog')
        				->orderBy('created_at')
        				->get();
        
       \DB::table('report_revisions')->truncate();
        				
        $today = new DateTime();
        foreach($logs as $log)
        {
        	if(!$log->report_type)
        	{
	        	$log->report_type = 'Sales & Collection - Report';        	
	        	if($log->save())
	        	{
		        	\DB::table('report_revisions')->insert([
		        			'revision_number' => generate_revision('salescollectionreport'),
		        			'report' => 'salescollectionreport',
		        			'updated_at' => $log->created_at,
		        			'created_at' => $log->updated_at,
		        			'user_id' => $log->updated_by,
		        			'table_log_id' => $log->id
		        	]);
	        	}
        	}
        	else
        	{
        		$type = $this->getType($log->report_type);
        		\DB::table('report_revisions')->insert([
        				'revision_number' => generate_revision($type),
        				'report' => $type,
        				'updated_at' => $log->created_at,
        				'created_at' => $log->updated_at,
        				'user_id' => $log->updated_by,
        				'table_log_id' => $log->id
        		]);
        	}
        }
    }

    
    public function getType($type)
    {
    	$types = [
    			'Sales & Collection - Report' => 'salescollectionreport',
				'Van Inventory - Canned & Mixes' => 'vaninventorycanned',
				'Sales Report - Per Material' => 'salesreportpermaterial',
				'Sales Report - Peso Value' => 'salesreportperpeso',
				'Van Inventory - Stock Transfer' => 'stocktransfer',
				'Van Inventory - Frozen & Kassel' => 'vaninventoryfrozen',
    	];
    	
    	return isset($types[$type]) ? $types[$type] : ''; 
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
