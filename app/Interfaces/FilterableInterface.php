<?php

namespace App\Interfaces;

/**
 *  The interface for Filterable objects
 * @author abner
 *
 */
interface FilterableInterface
{

	/**
	 * Add filter criteria
	 * @param unknown $model
	 * @param string $name
	 * @param string $scope
	 */
	public function addFilter($model, $name, $scope='');
	
	/**
	 * Render the text field
	 */
	public function render();
	
	/**
	 * Render filter result
	 */
	public function renderValue();
	
}