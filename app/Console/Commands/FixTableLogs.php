<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixTableLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:table_logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix table logs data discrepancies.';

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
        //
    	$configTables = config('sync.sync_tables');
        $logs = \DB::table(\DB::raw('(select * from table_logs order by id desc) as logs'))        			
        			->groupBy('logs.table','logs.column','logs.pk_id')
        			->get();
        
        foreach($logs as $log)
        {        		
        	if(isset($configTables[$log->table]))
        	{
        		$info = $configTables[$log->table];
        		$pk = array_shift($info);
        		if(!$pk)
        		{
        			$this->info('Pk not found for '.$log->table.' with pk id '.$log->pk_id);
        			continue;        			
        		}
        		
        		$row = \DB::table($log->table)->where($pk,$log->pk_id)->first();
        		if($row)
        		{
        			$currentValue = $row->{$log->column};
        			if($currentValue != $log->value)
        			{
        				$this->info('Value not equal for '.$log->table.' column '.$log->column.' with pk id '.$log->pk_id . ' val: '.$currentValue. ':'.$log->value);
        				if(false !== strpos($log->column, 'date'))
        					$values = [
        							$log->column => new \DateTime($log->value),
        							'updated_at' => $log->created_at,
        							'updated_by' => $log->updated_by,
        					];
        				else 
        					$values = [
        							$log->column=>$log->value,
        							'updated_at' => $log->created_at,
        							'updated_by' => $log->updated_by,
        					];
        				\DB::table($log->table)->where($pk,$log->pk_id)->lockForUpdate()->update($values);
        			}
        			
        		}
        		else 
        		{
        			$this->info('Row not found for '.$log->table.' with pk id '.$log->pk_id);
        		}
        	}
        	else
        	{
        		$this->info('Table pk column not found '.$log->table);
        	}
        }
    }
}
