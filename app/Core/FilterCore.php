<?php

namespace App\Core;

use App\Interfaces\FilterableInterface;
abstract class FilterCore implements FilterableInterface
{
	/**
	 * The field label
	 * @var unknown
	 */
	protected $label;
	
	/**
	 * The input type
	 * @var unknown
	 */
	protected $input = 'text';
	
	/**
	 * The field ID and name
	 * @var unknown
	 */
	protected $name;
	
	/**
	 * The field options
	 * @var unknown
	 */
	protected $options = [];
	
	/**
	 * The field value
	 * @var unknown
	 */
	protected $value;

	/**
	 * The Request
	 * @var unknown
	 */
	protected $request;
	
	/**
	 * The session
	 * @var unknown
	 */
	protected $session;
	
	/**
	 * The class constructor
	 * @param string $label
	 */
	public function __construct($label='')
	{
		$this->label = $label;
		$this->request = app('request');
		$this->session = app('session');
		
		// setup filter index 
		if(!$this->session->has('filters'))
		{
			$this->session->put('filters',$this->request->getPathInfo());
		}
		
		$this->clear();
	}
	
	/**
	 * Get the field label
	 */
	public function getLabel()
	{
		return $this->label;
	}
	
	/**
	 * Set the label
	 * @param unknown $text
	 */
	public function setLabel($text)
	{
		$this->label = $text;
	}
	
	/**
	 * Set the input
	 * @param unknown $type
	 */
	public function setInput($type)
	{
		$this->input = $type;
	}
	
	/**
	 * Get the input
	 * @return \App\Core\unknown
	 */
	public function getInput()
	{
		return $this->input;
	}
	
	/**
	 * Set the name
	 * @param unknown $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Get the name
	 * @return \App\Core\unknown
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * Set the value
	 * @param unknown $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}
	
	/**
	 * Get the value
	 * @return \App\Core\unknown
	 */
	public function getValue()
	{
		return $this->value;
	}
	
	/**
	 * Set the options
	 * @param unknown $options
	 */
	public function setOptions($options)
	{
		$this->options = $options;
	}
	
	/**
	 * Get the options
	 * @return \App\Core\unknown
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * Render the filter field
	 */
	public function render()
	{
		return \Form::filterInput($this->getInput(),$this->name,$this->label, $this->value);
	}
	
	/**
	 * Render the filter value
	 */
	public function renderValue()
	{
		if(!$this->value)
		{
			return '';
		}
		
		if($this->options instanceof \Illuminate\Support\Collection)
		{
			$this->options = $this->options->toArray();
			$this->value = array_only($this->options, $this->value);
		}
		
		$value = is_array($this->value) ? implode(', ',$this->value) : $this->value;
		return \Html::filterValue($this->label, $value);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see \App\Interfaces\FilterableInterface::addFilter()
	 */
	abstract public function addFilter($model, $name, $scope='');
	
	
	/**
	 * Store selected data to session
	 */
	protected function store()
	{
		$this->session->put('filters.'.$this->request->getPathInfo().'.'.$this->name, $this->value);
	}
	
	/**
	 * Get data from session
	 */
	protected function get()
	{
		$data = $this->session->get('filters');
		if(isset($data[$this->request->getPathInfo()][$this->name]))
		{
			return $data[$this->request->getPathInfo()][$this->name];
		}
		return '';
	}
	
	
	/**
	 * Clear data filter from session
	 * @param string $key
	 */
	protected function clear($key='')
	{
		$data = $this->session->get('filters');
		if($this->request->has('clear_filter'))
		{
			if(isset($data[$this->request->getPathInfo()]))
			{
				$this->session->set('filters.'.$this->request->getPathInfo(),'');
			}
		}
		elseif($key)
		{
			if(isset($data[$this->request->getPathInfo()][$key]))
			{
				unset($data[$this->request->getPathInfo()][$key]);
				$this->session->set('filters',$data);
			}
		}
	}
}