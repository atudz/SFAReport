<?php

namespace App\Filters;

use App\Core\FilterCore;
use Illuminate\Database\Query\Builder;

class DateFilter extends FilterCore
{
	
	/**
	 * Reference table column
	 * @var unknown
	 */
	protected $column;
	
	/**
	 * Class constructor
	 * @param unknown $label
	 * @param string $column
	 */
	public function __construct($label='',$column='')
	{
		$this->column = $column;
		parent::__construct($label);
	}
	
	/**
	 * Set reference column
	 * @param unknown $column
	 */
	public function setColumn($column)
	{
		$this->column = $column;
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \App\Core\FilterCore::addFilter()
	 */
	public function addFilter($model, $name, $scope='')
	{

		$this->setName($name);
		//$this->value = $this->get();
		
		if(!$this->request->has($name) || !$this->request->get($name))
		{
			return $model;
		}
		elseif($value = $this->request->get($name))
		{			
			$this->setValue($value);
			//$this->store();
		}
		
		if($model instanceof Model)
		{
			$name = $model->getTable().'.'.$name;
		}
		elseif($model instanceof Builder)
		{
			$name = $model->from.'.'.$name;
		}
		else
		{
			$name = $model->getModel()->getTable().'.'.$name;
		}
		
		if($scope instanceof \Closure)
		{
			return $scope($this,$model);	
		}
				
		return $scope ? $this->$scope($model) : $model->where(\DB::raw('DATE('.$name.')'),'=',$this->getValue());
	}
	
	/**
	 * Render the filter field
	 */
	public function render()
	{
		return \Form::filterSelect($this->name.'[]',$this->options,$this->label, $this->value, $multiple);
	}

}
