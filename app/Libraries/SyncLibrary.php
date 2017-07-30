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
		
		ini_set('memory_limit', '-1');
		set_time_limit (0);
		
		\DB::table('settings')->where('name','synching_sfi')->update(['value'=>1,'updated_at'=>new \DateTime()]);
		
		try 
		{
			$dbh = new PDO("dblib:host=$this->host:$this->port;dbname=$this->database",$this->dbuser,$this->dbpass);

			$configTables = config('sync.sync_tables');
			$tables = array_keys($configTables);
			$limit = 1000;			
			$pageLimit = 25000;
			
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
				
				if(!$pKey) {
					continue;
				}
				
				$query = 'SELECT %s FROM '.$table;		
				$countQuery = sprintf($query,'COUNT(*)');
				$stmt = $dbh->prepare($countQuery);
				$stmt->execute();
				$result  = $stmt->fetchAll(PDO::FETCH_ASSOC);	
				
				$getQuery = sprintf($query,'*');
				if($ids) {
					//exclude records
					$getQuery.= ' WHERE '.$pKey.' NOT IN('.implode(',', $ids).')';
				}
				
				if($result) {
					$totalRecords = array_shift($result);
					$totalRecords = array_shift($totalRecords);
					if(!$totalRecords) {
						$msg = "$table : inserted 0 records \n";
						$this->log($msg);
						if($display) echo $msg;
						continue;
					}
					$offset = 0;
					
					while($offset <= $totalRecords) {
						$limitQuery = ' ORDER BY '.$pKey.' OFFSET '.$offset.' ROWS FETCH NEXT '.$pageLimit.' ROWS ONLY';
						$getQuery .= $limitQuery;
						$stmt = $dbh->prepare($getQuery);
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
							$msg = "$table : inserted ". count($data)." records, page ".$offset.":".$pageLimit."\n";
							$this->log($msg);
							if($display) echo $msg;
						}
						else
						{
							// Import data to local database
							\DB::table($table)->insert($data);
							$msg = "$table : inserted ". count($data)." records, page ".$offset.":".$pageLimit."\n";
							$this->log($msg);
							if($display) echo $msg;
						}
						unset($data);
						
						$offset += $pageLimit;
					}
				}							
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
		
		\DB::table('settings')->where('name','synching_sfi')->update(['value'=>0,'updated_at'=>new \DateTime()]);
		
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
		return file_put_contents(config('sync.dir'), $message, FILE_APPEND);		
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

