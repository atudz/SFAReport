<?php

namespace App\Libraries;

use App\Core\LibraryCore;
use PDO;
use App\Factories\PresenterFactory;

/**
 * This is a library class for Sync
 *
 * @author abner
 *
 */

class SyncLibrary extends LibraryCore
{
	/**
	 * Server credentials
	 * @var unknown
	 */
	protected $host;
	protected $port;
	protected $database;
	protected $dbuser;
	protected $dbpass;
	
	/**
	 * Class consctuctor
	 */
	public function __construct()
	{
		$this->host = config('sync.host');
		$this->port = config('sync.port');
		$this->database = config('sync.database');
		$this->dbuser = config('sync.dbuser');
		$this->dbpass = config('sync.dbpass');	
	}
	
	/**
	 * Sync sfa database to my database
	 * @param string $display
	 * @return boolean
	 */
	public function sync($display=false)
	{		
		$this->log('Synchronization started '.date('Y-m-d H:m:s')."\n");
		try 
		{
			$dbh = new PDO("dblib:host=$this->host:$this->port;dbname=$this->database",$this->dbuser,$this->dbpass);

			$configTables = config('sync.sync_tables');
			$tables = array_keys($configTables);
			$limit = 1000;
			
			foreach($tables as $table)
			{
				
				//Delete records from local database
				\DB::table($table)->whereNull('updated_at')->delete();
				
				$ids = [];
				if($keys = $configTables[$table])
				{
					$records = \DB::table($table)->get($keys);
					$pKey = array_shift($keys);				
					foreach($records as $record)
					{
						$ids[] = $record->$pKey;
					}
				}
				
				$query = 'SELECT * FROM '.$table;
				if($ids)
				{
					//exclude records
				 	$query .= ' WHERE '.$pKey.' NOT IN('.implode(',', $ids).')';
				}			
					
				$stmt = $dbh->prepare($query);
				$stmt->execute();
				$data = $stmt->fetchAll(PDO::FETCH_ASSOC);		
				
				$data = $this->formatData($data);
				
				$count = count($data);
				if($count > $limit)
				{
					foreach(array_chunk($data,$limit,true) as $row)
					{
						// Import data to local database						
						\DB::table($table)->insert($row);
					}					
					$msg = "$table : inserted ". count($data)." records.\n";
					$this->log($msg);
					if($display) echo $msg;
				}
				else
				{
					// Import data to local database					
					\DB::table($table)->insert($data);
					$msg = "$table : inserted ". count($data)." records.\n";
					$this->log($msg);
					if($display) echo $msg;
				}
				unset($data);
			}			
			
		} catch (PDOException $e) {
			$this->log('Error :'.$e->getMessage());
			//$email = config('system.error_email');
			if($email)
			{
				$email = explode(',',$email);
				$data['email'] = $email;
				$data['errors'] = $e->getMessage();
				\Mail::send('emails.error', $data, function ($m) use ($email) {
					$m->from(config('system.from_email'),config('system.from'));
					$m->to($email)->subject('Application Error');
				});
			}
			return false;
		}
		
		$this->log('Synchronization ended '.date('Y-m-d H:m:s')."\n");
		
		// update report summary columns
		PresenterFactory::getInstance('Reports')->updateReportSummary();
		
		return true;
		
	}
	
	/**
	 * log message to file 
	 * @param unknown $message
	 * @return number
	 */
	public function log($message)
	{
		$filename = date('Y-m-d') . '.log';
		if(file_exists(config('sync.dir').$filename))
		{
			chown(config('sync.dir').$filename, 'www-data');
			chmod(config('sync.dir').$filename, 0775);
		}
		
		return file_put_contents(config('sync.dir').$filename, $message, FILE_APPEND);		
	}
	
	/**
	 * Format data to correct type
	 * @param unknown $data
	 * @return multitype:
	 */
	public function formatData($data)
	{
		foreach($data as $key=>$value)
		{
			foreach($value as $col=>$val)
			{
				if(false !== strpos($col, 'date'))
				{
					$data[$key][$col] = new \DateTime($val);
				}
			}
		}
		return $data;
	}
}

