<?php

namespace App\Libraries;

use App\Core\LibraryCore;
use App\Factories\ModelFactory;

/**
 * This is a library class for DataTree
 *
 * @author abner
 *
 */

class DataTreeLibrary extends LibraryCore
{
	
	/**
	 * The subject model
	 * @var $subjectModel
	 */
	protected $subjectModel;
	
	/**
	 * The relational field to parent
	 * @var $parentField
	 */
	protected $parentColumn;
	
	/**
	 * Sort order
	 * @var unknown
	 */
	protected $sort = 'asc';
	
	/**
	 * Sort column
	 * @var unknown
	 */
	protected $sortColumn;
	
	/**
	 * The resulting data
	 * @var unknown
	 */
	protected $dateTree = [];
	
	/**
	 * Prepared flag
	 * @var unknown
	 */
	protected $prepared = false;
	
	/**
	 * 
	 * @var unknown
	 */
	protected $conditions = [
			'where' => [],
			'whereIn' => [],			
	];
	
	
	/**
	 * The class contructor
	 */
	public function __construct($model=null,$parent=null)
	{
		
		$this->subjectModel = $model;
		$this->parentColumn = $parent;
	}
	
	/**
	 * Sets the subject model
	 * @param unknown $model
	 */
	public function setModel($model)
	{
		$this->subjectModel = $model;
	}
	
	/**
	 * Set the parent column
	 * @param unknown $column
	 */
	public function setParentColumn($column)
	{
		$this->parentColumn = $column;
	}
	
	
	public function addSort($column, $order='asc')
	{
		$this->sortColumn = $column;
		$this->sort = $order;
	}
	
	/**
	 * Get the data tree
	 * @param string $select
	 * @return \App\Libraries\unknown
	 */
	public function getData($select=['*'])
	{
		// get parent root data		
		$data = [];
		$root = $this->getRoot($select);
		$pkId = $this->subjectModel->getKeyName();
		foreach($root as $index=>$parent)
		{
			$tmp = $parent;
			$tmp['sub'] = $this->getChildren($parent[$pkId],[],$select);
			$data[] = $tmp;
		}
		$this->dateTree = $data;
		$this->prepared = true;
		
		return $this->dateTree;
	}
	
	/**
	 * Get root elements 
	 * @param string $select
	 */
	public function getRoot($select=['*'])
	{
		$prepare = $this->subjectModel->where($this->parentColumn,'=',0);
		
		$prepare = $this->addAdhocConditions($prepare);
		if($this->sortColumn)
		{
			$prepare->orderBy($this->sortColumn, $this->sort);
		}
		
		return $prepare->get($select)->toArray();		
	}
	
	/**
	 * A recursive method for retrieving parent children
	 * @param unknown $parentId
	 * @param unknown $data
	 * @param string $select
	 * @return string
	 */
	public function getChildren($parentId, $data=[], $select=['*'])
	{
		$prepare = $this->subjectModel->where($this->parentColumn,'=',$parentId);
		$prepare = $this->addAdhocConditions($prepare);
		if($this->sortColumn)
		{
			$prepare->orderBy($this->sortColumn, $this->sort);
		}
		
		$elements = $prepare->get($select)->toArray();
		if(empty($elements))
		{
			return '';
		}
		
		$pkId = $this->subjectModel->getKeyName();
		foreach($elements as $index => $parent)
		{		
			$tmp = $parent;
			$tmp['sub'] = $this->getChildren($parent[$pkId],$data,$select);
			$data[$index] = $tmp;
		}
		
		return $data;
	}

	/**
	 * Add adhoc conditions to the query
	 * @param unknown $prepare
	 */
	protected function addAdhocConditions($prepare)
	{
		// Add where conditions
		foreach($this->conditions['where'] as $where)
		{
			$prepare = $prepare->where($where['column'], $where['operator'], $where['value'], $where['boolean']);	
		}
		
		// Add where In conditions
		foreach($this->conditions['whereIn'] as $where)
		{
			$prepare = $prepare->whereIn($where['column'], $where['values'], $where['boolean'],$where['not']);
		}
		
		return $prepare;	
	}
	
	/**
	 * Add where condition
	 * @param unknown $column
	 * @param unknown $operator
	 * @param unknown $value
	 * @param string $boolean
	 */
	public function addWhere($column, $operator = '=', $value = null, $boolean = 'and')
	{
		$condition = [
			'operator'=> $operator,
			'value' => $value,
			'column' => $column,
			'boolean'=>$boolean
		];
		$this->conditions['where'][] = $condition;
	}
	
	/**
	 * Add where in condition
	 * @param unknown $column
	 * @param unknown $values
	 * @param string $boolean
	 * @param string $not
	 */
	public function addwhereIn($column, array $values, $boolean = 'and', $not = false)
	{
		$condition = [
				'not'=> $not,
				'values' => $values,
				'column' => $column,
				'boolean'=> $boolean
		];
		$this->conditions['whereIn'][] = $condition;
	}
	
}

