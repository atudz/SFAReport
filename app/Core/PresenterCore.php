<?php

namespace App\Core;

use App\Http\Controllers\Controller;
use App\Factories\LibraryFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use App\Factories\PresenterFactory;
use Illuminate\Http\Request;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use App\Factories\ModelFactory;
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
	 * Valid excel export types
	 * @var unknown
	 */
	protected $validExportTypes = ['xls','xlsx','pdf'];
	
	/**
	 * Returns the Presenter Classes directory
	 * @return string
	 */

	public function __construct()
    {
        $this->middleware('auth', ['except' => ['login','forgotPassword']]);        
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

		$menuLib = LibraryFactory::getInstance('Menu');
		
		if(!$menuLib->isActionAllowed($template))
		{
			return view('errors.403');
		}

		$this->view->menu = $menuLib->getMyMenus();
		$templateName = $name.'.'.$template;
		
		$this->view->isAdmin = $this->isAdmin();
		$this->view->isAuditor = $this->isAuditor();
		$this->view->isAccounting = $this->isAcounting();
		$this->view->isGuest1 = $this->isGuest1();
		$this->view->isGuest2 = $this->isGuest2();
		$this->view->isSalesman = $this->isSalesman();
		$this->view->isManager = $this->isManager();

		return view($templateName,$data, (array)$this->view);
	}
	
	/**
	 * Paginate the given criteria
	 * @param Builder $criteria
	 * @param unknown $columns
	 * @return \App\Core\PaginatorCore
	 */
	public function paginate($criteria, $columns = ['*'])
	{
		if($criteria instanceof Illuminate\Database\Eloquent\Builder)
		{
			$builder = $criteria->getQuery();		
		}
		else
		{
			$builder = $criteria;
		}
		
		$pageName = 'page';
		$sortColumn = '';
		$sortOrder = '';
		$default = config('system.page_limit');
		$total = $builder->getCountForPagination();
		if(!is_null($this->request) && $this->request->has('page_limit'))
		{
			$perPage = $this->request->has('page_limit') ? $this->request->get('page_limit') : $default;
			$page = $this->request->has($pageName) ? $this->request->get($pageName) : null;
			$sortColumn = $this->request->has('sort') ? $this->request->get('sort') : '';
			$sortOrder = $this->request->has('order') ? $this->request->get('order') : '';
		} 
		else
		{
			$perPage = $default;
		}
		
		$builder->forPage(
				$page = Paginator::resolveCurrentPage($pageName),
				$perPage
		);
		
		if($sortColumn)
		{
			$sortOrder = $sortOrder ? $sortOrder : $this->defaultSort;
			$criteria = $builder->orderBy($sortColumn,$sortOrder);	
		}
		return new PaginatorCore($builder->get($columns), $total, $perPage, $page, [
				'path' => Paginator::resolveCurrentPath(),
				'pageName' => $pageName,
				'sortColumn' => $sortColumn,
				'sortOrder' => $sortOrder,
		]);
	}
	
	/**
	 * Export report excel or pdf file
	 * @param unknown $type
	 * @param unknown $filename
	 * @param array $columns
	 * @param array $rows
	 * @param array $data
	 */
	public function export($type,$filename,array $columns, array $rows, array $data)
	{
		if(!in_array($type, $this->validExportTypes))
		{
			return;
		}
		
		\Excel::create($filename, function($excel) use ($columns,$rows,$data){
			$excel->sheet('Sheet1', function($sheet) use ($columns,$rows,$data){
				$params['columns'] = $columns;
				$params['rows'] = $rows;
				$params['records'] = $data;
				$sheet->loadView('Reports.export', $params);
			});
		
		})->export($type);
	}
	
	/**
	 * Determine if user is restricted
	 * @return boolean
	 */
	public function hasAdminRole()
	{
		if(!auth()->user())
			return false;
		
		$group = auth()->user()->group->name;		
		return in_array($group,['Admin','Auditor','Manager']);
	}
	
	
	/**
	 * Determine if user is restricted
	 * @return boolean
	 */
	public function isAdmin()
	{
		if(!auth()->user())
			return false;
	
		$group = auth()->user()->group->name;
		return ('Admin' == $group);
	}
	
	/**
	 * Determine if user is restricted
	 * @return boolean
	 */
	public function isAuditor()
	{
		if(!auth()->user())
			return false;
	
		$group = auth()->user()->group->name;
		return ('Auditor' == $group);
	}
	
	
	/**
	 * Determine if user is restricted
	 * @return boolean
	 */
	public function isAcounting()
	{
		if(!auth()->user())
			return false;
	
		$group = auth()->user()->group->name;
		return ('Accounting in charge' == $group);
	}
	
	/**
	 * Determine if user is restricted
	 * @return boolean
	 */
	public function isSalesman()
	{
		if(!auth()->user())
			return false;
	
		$group = auth()->user()->group->name;
		return ('Van Salesman' == $group);
	}
	
	/**
	 * Determine if user is restricted
	 * @return boolean
	 */
	public function isManager()
	{
		if(!auth()->user())
			return false;
	
			$group = auth()->user()->group->name;
			return ('Manager' == $group);
	}
	
	/**
	 * Determine if user is restricted
	 * @return boolean
	 */
	public function isGuest1()
	{
		if(!auth()->user())
			return false;
	
		$group = auth()->user()->group->name;
		return ('Guest1' == $group);
	}
	
	/**
	 * Determine if user is restricted
	 * @return boolean
	 */
	public function isGuest2()
	{
		if(!auth()->user())
			return false;
	
		$group = auth()->user()->group->name;
		return ('Guest2' == $group);
	}
	
	/**
	 * Check if user has access
	 * @param unknown $name
	 */
	public function hasPageAccess($name)
	{
		$groupId = auth()->user()->user_group_id;
		$navId = ModelFactory::getInstance('Navigation')->where('name',$name)->first()->id;
		return ModelFactory::getInstance('UserGroupToNav')
					->where('navigation_id',$navId)
					->where('user_group_id',$groupId)
					->exists();
	}
		
}
