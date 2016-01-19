<?php

namespace App\Libraries;

use App\Core\LibraryCore;

/**
 * This is a library class for TemporaryTable
 *
 * @author abner
 *
 */

class TemporaryTableLibrary extends LibraryCore
{
	//hold the table name
	private $tableName;
	
	//hold the columns of the temporary table example array('title' => 'TEXT')
	private $columns = array();
	
	
	/**
	 * Setting the table name.
	 *
	 * @param string $tableName
	 * @return $this->tableName
	*/
	public function setTableName($tableName)
	{
		$this->tableName = $tableName;
		return $this->tableName;
	}
	
	/**
	 * Retrieve the Table name.
	 *
	 * @return $this->tableName
	 */
	public function getTableName()
	{
		return $this->tableName;
	}
	
	/**
	 * Specify the list of columns and defining their types.
	 *
	 * @param array $fields
	 * @param boolean $withId
	 * @return $this->columns
	 */
	public function setColumns($fields, $withId, $typeText = true)
	{
		$updatedFields = array();
	
		foreach ($fields AS $col => $type)
		{
			$col = str_replace(array("\r\n", "\r", "\n", "\t", ' ', '-'), "_", strtolower($col));
			//use TEXT as default type
			$type = (!$typeText && !is_numeric($type)) ? $type : 'TEXT';
	
			$updatedFields[$col] = $type;
		}
	
		if ($withId)
		{
			$this->columns['id'] = 'INT(10) UNSIGNED NOT NULL DEFAULT 0';
		}
		$this->columns = array_merge($this->columns, $updatedFields);
	
		return $this->columns;
	}
	
	/**
	 * This function will help in getting the list of fields
	 * taking into consideration the retrieve of the column id.
	 *
	 * @param boolean $onlyName
	 * @param boolean $withId
	 * @return $this->columns
	 */
	public function getColumns($onlyName = false, $withId = true)
	{
		$columns = $this->columns;
	
		if (!$withId)
		{
			unset($columns['id']);
		}
	
		return !$onlyName ? $columns : array_keys($columns);
	}
	
	/**
	 * This function is responsible for creating temporary table.
	 * The name and the set of fields are set depending on the parameters
	 * passed to the function.
	 *
	 * @param array $fields
	 * @param boolean $withId
	 * @param string $tableName
	 *
	 * @return $this->tableName or Boolean
	 */
	public function create($fields, $withId = false, $tableName = "", $typeText = false, $index = '')
	{
		if (!$tableName)
		{
			$tableName = uniqid();
		}
		$this->tableName = 'temp_' . $tableName;
	
		//sanitize columns
		$this->setColumns($fields, $withId, $typeText);
	
		$fieldString = "";
		foreach ($this->columns as $col => $type)
		{
			$fieldString .= ",$col $type";
		}
	
		$sql = "CREATE TEMPORARY TABLE IF NOT EXISTS $this->tableName (" . substr($fieldString, 1) . ' )';	
		\DB::statement($sql);
	
		if($index)
		{
			$sql = "ALTER TABLE {$this->tableName} ADD INDEX ({$index})";
			\DB::statement($sql);
		}
		return $this->tableName;
	}
	
	/**
	 * This function is used to insert an array of values to the related table dynamically.
	 *
	 * @param array $dataToInsert
	 *
	 * @return Boolean
	 */
	public function populateFromArray($dataToInsert)
	{
		global $atlas;
		//insert to temporary table
		$query = "INSERT INTO $this->tableName (" . implode(',', array_keys($this->columns)) . ") VALUES ";
	
		foreach ($dataToInsert as $row)
		{
			$toAdd = "";
			foreach ($this->columns AS $col => $type)
			{
				if( is_array($row[$col]) ) // Handle array for multivalueds fields - gsalameh
				{
					$toAdd .= ',' . $this->quoteSmart( implode(',', $row[$col]) );
				}
				else
				{
					$toAdd .= ',' . $this->quoteSmart($row[$col]);
				}
			}
			$query .= '(' . substr($toAdd, 1) . '),';
		}
	
		//remnove last Comma
		$query = substr($query, 0, -1);
	
		\DB::statement($query);
	
		return true;
	}
	
	/**
	 * This function is used to insert values to the related table dynamically.
	 *
	 * @param string $query
	 *
	 * @return Boolean
	 */
	public function populateFromQuery($query)
	{
		//insert to temporary table from a query
		$query = "INSERT INTO $this->tableName (" . implode(',', array_keys($this->columns)) . ") ($query) ";
		\DB::statement($query);
		return true;
	}
		
	/**
	 * drop
	 *
	 * @return Boolean
	 */
	public function drop()
	{
		if ($this->tableName)
		{
			$query = "DROP TEMPORARY TABLE IF EXISTS $this->tableName";
			\DB::statement($query);
			return true;
		}
		return false;
	}
	
	/**
	 * Escape string or array
	 * @param unknown $values
	 * @return Ambigous <string, multitype:string >
	 */
	public function quoteSmart($values)
	{
		if(is_array($values))
		{
			$tmp = [];
			foreach($values as $key=>$str)
			{
				$tmp[$key] = "'".addslashes($str)."'";
			}		
			$values = $tmp;
		}
		else
		{
			$values = "'".addslashes($values)."'";
		}
		
		return $values;
	}
}

