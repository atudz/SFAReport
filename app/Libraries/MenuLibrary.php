<?php

namespace App\Libraries;

use App\Interfaces\SingletonInterface;
use App\Core\LibraryCore;
use App\Factories\ModelFactory;

/**
 * This is a library class for Menu
 *
 * @author abner
 *
 */

class MenuLibrary extends LibraryCore implements SingletonInterface
{
	/**
	 * Flags if this class has already initiated the necessary data.
	 * @var $prepared
	 */
	protected $prepared = false;
	
	/**
	 * The list of system menus
	 * @var $menuList
	 */
	protected $menuList = [];

	/**
	 * List of menu items that should be excluded per group
	 *
	 * TODO: This is only here as a temporary fix and should be tied
	 * 		 to a group -> item table relation 
	 *
	 * @var Array user_group.id to navigation_item.url
	 */
	protected $menuItemExclude = [
		4 => [
			'salesmanList' => 'salesreport.salesmanlist',
			'salesCollectionPosting' => 'salescollection.posting',
			'salesCollectionSummary' => 'salescollection.summary',
		],
	];

	/**
	 * The class constructor. This will load all the menu data in the system.
	 */
	public function __construct()
	{
		if(!$this->prepared)
		{
			$this->prepare();	
		}
	}
	
	/**
	 * Magic clone method
	 */
	public function __clone()
	{
		// throw exception here since Singleton can't be cloned
		throw new RuntimeException(get_class($this) . ' is a Singleton and cannot be cloned.');
	}
	
	/**
	 * Gets the current user's menu list
	 * @param int $userId
	 * @return \App\Libraries\$menuList
	 */
	public function getMyMenus()
	{
		if(!$this->prepared)
		{
			$this->prepare();
		}
		
		return $this->menuList;
	}
	
	/**
	 * Loads the necessary data for the class
	 */
	protected function prepare()
	{
		if(app('session')->has('menu_list'))
		{
			$this->menuList = app('session')->pull('menu_list');
		}
		elseif(\Auth::user())
		{
			$userId = \Auth::user()->id;
			$groupId = \Auth::user()->group->id;

			$excludeGroups = (isset($this->menuItemExclude[$groupId])) ? $this->menuItemExclude[$groupId]:[];

			$userModel = ModelFactory::getInstance('User');

			$user = $userModel->with(['group.navigations' => function($query)
						{
							$query->where('navigation.active','=',1);
						},
						'group.navigations.navitems' => function($query) use ($excludeGroups)
						{
							$query->where('navigation_item.active','=',1);
							$query->whereNotIn('navigation_item.url', $excludeGroups);
						}
					])->find($userId);

			$this->menuList = $user->group->navigations->sortBy(function($navs) {
									return $navs->id;
								})->toArray();

			// store this to session so that we'll just pull the data from session
			// and no longer need to Query again
			
			//app('session')->put('menu_list', $this->menuList); 
		}

		$this->prepared = true;
	}

	public function isActionAllowed($action)
	{
		$groupId = \Auth::user()->group->id;

		if(isset($this->menuItemExclude[$groupId][$action]))
		{
			return false;
		}

		return true;
	}
}

