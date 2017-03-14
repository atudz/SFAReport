<?php

namespace App\Libraries;

use App\Interfaces\SingletonInterface;
use App\Core\LibraryCore;
use App\Factories\ModelFactory;
use App\Factories\LibraryFactory;

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
// 		2 => [
// 			'sync' => 'sync',
// 		],
		3 => [
			'sync' => 'sync',
		],
		5 => [
			'sync' => 'sync',
		],
		6 => [
			'sync' => 'sync',
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
		if(\Session::has('menu_list'))
		{
			$this->menuList = app('session')->pull('menu_list');
		}
		elseif(\Auth::user())
		{
			$userId = \Auth::user()->id;
			$user = ModelFactory::getInstance('User')
						->with(['group'=>function($query){
									$query->select(['user_group.id']);
								},
								'group.navigations'=>function($query){
									$query->select(['navigation.id']);
								}])
						->find($userId,['user.id','user.user_group_id']);
								
			$navIds = [];
			foreach($user->group->navigations as $nav)
			{
				$navIds[] = $nav->id;						
			}			
			
			$nav = ModelFactory::getInstance('Navigation');
			$treeLib = LibraryFactory::getInstance('DataTree',$nav,'parent_id');
			$treeLib->addSort('order');
			$treeLib->addwhereIn('id', $navIds);
			$navs = $treeLib->getData();
			
			$this->menuList = $navs;
			
			// store this to session so that we'll just pull the data from session
			// and no longer need to Query again
			\Session::put('menu_list', $this->menuList); 
		}
		
		$this->prepared = true;
	}

	public function isActionAllowed($action)
	{
		$user = \Auth::user();
		
		if(!$user)
			return true;
		
		$groupId = $user->group->id;

		if(isset($this->menuItemExclude[$groupId][$action]))
		{
			return false;
		}

		return true;
	}
}

