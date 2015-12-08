<?php

namespace App\Filters;

use App\Core\FilterCore;

class SelectFilter extends FilterCore
{
	/**
	 * Single Select Flag
	 * @var unknown
	 */
	const SINGLE_SELECT = 1;
	
	/**
	 * Multiple Select flag
	 * @var unknown
	 */
	const MULTIPLE_SELECT = 2;
	
	/**
	 * Select type value
	 * @var unknown
	 */
	protected $selectType = self::SINGLE_SELECT;
	
	public function __construct($label,$type)
	{
		$this->selectType = $type;
		parent::__construct($label);	
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \App\Core\FilterCore::addFilter()
	 */
	public function addFilter($model, $name, $scope='')
	{

		$this->setName($name);
		//$this->value = $this->get();
		
		if(!$this->request->has($name) && !$this->getValue())
		{
			return $model;
		}
		elseif($this->request->get($name))
		{
			$value = $this->request->get($name);
			if(!is_array($value))
			{
				$value = array($value);
			}
			
			$this->setValue($value);
			//$this->store();
		}
		
		if($model instanceof Model)
		{
			$name = $model->getTable().'.'.$name;
		}
		else
		{
			$name = $model->getModel()->getTable().'.'.$name;
		}
		
		return $scope ? $this->$scope($model) : $model->where($name,'=',$this->getValue());
	}
	
	/**
	 * Render the filter field
	 */
	public function render()
	{
		$multiple = $this->selectType == self::MULTIPLE_SELECT ? true : false;
		return \Form::filterSelect($this->name.'[]',$this->options,$this->label, $this->value, $multiple);
	}
	
	/**
	 * Get select type
	 * @return string
	 */
	public function getSelectType()
	{
		return $this->selectType;
	}
	
	/**
	 * Set select type
	 * @param string $type
	 */
	public function setType($type)
	{
		$this->selectType = $type;
	}	
	
	/**
	 * Query scope for filtering data by category Ids
	 * @param unknown $model
	 * @param string $values
	 */
	public function byCategory($model, $values='')
	{
		if(!$values)
		{
			$values = $this->getValue();
		}
	
		$table = ($model instanceof Model) ? $model->getTable() : $model->getModel()->getTable();
		
		return $model->join('product_to_category',function($join) use ($table, $values) {
			$join->on($table.'.id','=','product_to_category.product_pk_id');
			$join->whereIn('product_to_category.product_category_pk_id',$values);
		});
	}
	
	/**
	 * Query scope for filtering data by category Ids
	 * @param unknown $model
	 * @param string $values
	 */
	public function byTag($model, $values='')
	{
		if(!$values)
		{
			$values = $this->getValue();
		}
	
		$table = ($model instanceof Model) ? $model->getTable() : $model->getModel()->getTable();
	
		return $model->join('product_to_tag',function($join) use ($table, $values) {
			$join->on($table.'.id','=','product_to_tag.product_pk_id');
			$join->whereIn('product_to_tag.product_tag_pk_id',$values);
		});
	}
}
