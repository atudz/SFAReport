<?php

namespace App\Core;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Presenter;
use App\Core\Builder\PaginatorBuilder;
use App\Core\Builder\App\Core\Builder;

class PaginatorCore extends LengthAwarePaginator
{

	/**
	 * The PaginatorBuilder Instance
	 * @var unknown
	 */
	protected $paginatorBuilder;
	
	/**
	 * The sort order
	 * @var unknown
	 */
	protected $sortOrder = '';
	
	/**
	 * The sort column
	 * @var unknown
	 */
	protected $sortColumn = '';
	
	
	/**
	 * Render the paginator using the given presenter.
	 *
	 * @param  \Illuminate\Contracts\Pagination\Presenter|null  $presenter
	 * @return string
	 */
	public function render(Presenter $presenter = null)
	{
		/*
		 * Render custom paginator
		 */
		if(is_null($this->paginatorBuilder))
		{
			$this->paginatorBuilder = new PaginatorBuilder($this);
		}
	
		return $this->paginatorBuilder->render();
	}
	
	/**
	 * Display paginate links with limiter as option
	 * @param string $limiter
	 * @return string
	 */
	public function paginate($limiter=true)
	{
		/*
		 * Render custom paginator
		 */
		if(is_null($this->paginatorBuilder))
		{
			$this->paginatorBuilder = new PaginatorBuilder($this);
		}
	
		return $this->paginatorBuilder->render($limiter);
	}
	
	/**
	 * Generates a link for sorting a column
	 * @param unknown $column
	 * @param unknown $name
	 * @param string $alphabetical
	 * @return string
	 */
	public function sortColumn($column,$name,$alphabetical=true)
	{
					
		if($this->sortOrder && $this->sortOrder == 'desc' && $column == $this->sortColumn)
		{
			$order = 'asc';
			$icon = ($alphabetical) ? 'glyphicon glyphicon-sort-by-alphabet-alt' : 'glyphicon glyphicon-sort-by-order-alt';
		}
		elseif($this->sortOrder && $this->sortOrder == 'asc' && $column == $this->sortColumn)
		{
			$order = 'desc';
			$icon = ($alphabetical && $this->sortOrder) ? 'glyphicon glyphicon-sort-by-alphabet' : 'glyphicon glyphicon-sort-by-order';
		}
		else
		{
			$order = 'asc';
			$icon = 'glyphicon glyphicon-sort';
		}
		$options = [
				'sort' => $column,
				'order' => $order,
				'limit' => $this->perPage		
		];
		
		$this->appends($options);
		$url = $this->url($this->currentPage());
		$link = '<a href="'.$url.'">'.$name.'<span class="'.$icon.' thead-sort-icon"></span></a>';
		return $link;
	}
	
	/**
	 * Get Sort Order
	 * @return string
	 */
	public function getSortOrder()
	{
		return $this->sortOrder;
	}
	
	/**
	 * Get Sort column
	 * @return string
	 */
	public function getSortColumn()
	{
		return $this->sortColumn;
	}
}