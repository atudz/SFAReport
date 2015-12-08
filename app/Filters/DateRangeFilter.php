<?php

namespace App\Filters;

use App\Core\FilterCore;

class DateRangeFilter extends FilterCore
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
	public function __construct($label,$column='')
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
		
		if(!$this->request->has($name) && !$this->getValue())
		{
			return $model;
		}
		elseif($this->request->get($name))
		{
			$value = $this->request->get($name);
			if(!is_array($value))
			{
				$value = [
					'from' => $this->request->get($name.'_from'),
					'to' => $this->request->get($name.'_to')
				];
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
		
		return $scope ? $this->$scope($model) : $model->whereBetween($name,'=',$this->getValue());
	}
	
	/**
	 * Render the filter field
	 */
	public function render()
	{
		return \Form::filterSelect($this->name.'[]',$this->options,$this->label, $this->value, $multiple);
	}

}
