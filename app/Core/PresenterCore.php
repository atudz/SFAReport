<?php

namespace App\Core;

use App\Http\Controllers\Controller;
use App\Factories\LibraryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use App\Factories\PresenterFactory;
use Illuminate\Http\Request;

/**
 * This class is a wrapper class for Laravel's Controller.
 * Its mainly used for the core class for Presenters.
 * Presenters should extend this class
 *
 * @author abner
 *
 */

class PresenterCore extends Controller
{

	/**
	 * The default sort value
	 * @var unknown
	 */
	protected $defaultSort = 'asc';
	
	/**
	 * The Request 
	 * @var unknown
	 */
	protected $request;
	
	/**
	 * An StdClass object that will hold the values that should be passed to view
	 * @var unknown
	 */
	protected $view;
		
	/**
	 * Returns the Presenter Classes directory
	 * @return string
	 */

	public function __construct()
    {
        $this->middleware('auth', ['except' => ['viewLogin','logout']]);
        $this->view = new \stdClass();
        $this->request = app('request');
    }

    /**
     * Get presenter files directory
     * @return string
     */
	public static function getPresenterDirectory()
	{
		return app_path('Http/Presenters/');
	}
	
	/**
	 * This is a helper method which will handle necessary data
	 * needed for the view. This is created to centralize this functionality
	 * for all presenters
	 * @param string $template
	 * @param array $data
	 * @param string $parent
	 */
	protected function view($template, $data=[], $parent='')
	{
		if($parent)
		{
			$name = $parent;
		}
		else
		{
			$namespace = get_class($this);
			$chunks = explode('\\',$namespace);
			$name = array_pop($chunks);
			$name = str_replace(PresenterFactory::getSuffix(), '', $name);
		}
		
		$menu = LibraryFactory::getInstance('Menu')->getMyMenus();
		$this->view->menu = $menu;
		$templateName = $name.'.'.$template;
		
		return view($templateName,$data, (array)$this->view);
	}
	
	/**
	 * Paginate the given criteria
	 * @param Builder $criteria
	 * @param unknown $columns
	 * @return \App\Core\PaginatorCore
	 */
	public function paginate(Builder $criteria, $columns = ['*'])
	{
		$pageName = 'page';
		$sortColumn = '';
		$sortOrder = '';
		$default = config('storage_directory.pagination_limit');
		$total = $criteria->getQuery()->getCountForPagination();
		if(!is_null($this->request) && $this->request->has('limit'))
		{
			$perPage = $this->request->has('limit') ? $this->request->get('limit') : $default;
			$page = $this->request->has($pageName) ? $this->request->get($pageName) : null;
			$sortColumn = $this->request->has('sort') ? $this->request->get('sort') : '';
			$sortOrder = $this->request->has('order') ? $this->request->get('order') : '';
		} 
		else
		{
			$perPage = $default;
		}
		
		$criteria->getQuery()->forPage(
				$page = Paginator::resolveCurrentPage($pageName),
				$perPage
		);
		
		if($sortColumn)
		{
			$sortOrder = $sortOrder ? $sortOrder : $this->defaultSort;
			$criteria = $criteria->orderBy($sortColumn,$sortOrder);	
		}
		return new PaginatorCore($criteria->get($columns), $total, $perPage, $page, [
				'path' => Paginator::resolveCurrentPath(),
				'pageName' => $pageName,
				'sortColumn' => $sortColumn,
				'sortOrder' => $sortOrder,
		]);
	}
}