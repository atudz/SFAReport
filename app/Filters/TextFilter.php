<?php

namespace App\Filters;

use App\Core\FilterCore;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class TextFilter extends FilterCore
{
	
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
		elseif($this->request->get($name))
		{
			$this->setValue($this->request->get($name));
			//$this->store();
		}
		
		if($model instanceof Model)
		{
			$name = $model->getTable().'.'.$name;
		}
		elseif($model instanceof \Illuminate\Database\Query\Builder)
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
		
		return $scope ? $this->$scope($model) : $model->where($name,'LIKE','%'.$this->getValue().'%');
	}
	
	/**
	 * Get the input
	 * @return \App\Core\unknown
	 */
	public function getInput()
	{
		return 'text';
	}
}
