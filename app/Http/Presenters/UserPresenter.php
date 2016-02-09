<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\FilterFactory;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;

class UserPresenter extends PresenterCore
{
	/**
	 * Return User List view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function userList()
	{
		$this->view->roles = $this->getRoles();		
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->tableHeaders = $this->getUserTableColumns();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(!$this->hasAdminRole());
		return $this->view('users');
	}

	
	/**
	 * Display add edit form
	 * @param number $userId
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function addEdit($userId=0)
	{
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		return $this->view('addEdit');
	}
	
	/**
	 * Get user info
	 * @param number $userId
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function getUser($userId)
	{
		$user = ModelFactory::getInstance('User')->find($userId);
		$data = $user ? $user->toArray() : [];
		return response()->json($data);
	}
	
	
	/**
	 * Display add edit form
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function edit()
	{
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		return $this->view('edit');
	}
	
	
	public function changePassword(){
		return $this->view('changePassword');
	}
	
	public function profile(){
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		return $this->view('myProfile');
	}
	
	/**
	 * Get my profile
	 * @return \App\Http\Presenters\Ambigous
	 */
	public function myProfile(){
		return $this->getUser(auth()->user()->id);
	}
	
	/**
	 * Get user roles
	 */
	public function getRoles()
	{
		return \DB::table('user_group')->lists('name','id');	
	}
	
	/**
	 * Get user emails
	 */
	public function getUserEmails($id=0, $json=true)
	{
		$prepare = \DB::table('user');
		if($id)
		{
			$prepare = $prepare->where('id','<>',$id);
		}
		$result = $prepare->whereNull('deleted_at')->lists('email','id');
		return $json ? response()->json($result) : $result;
	}
	
	/**
	 * Get user emails
	 */
	public function getUsernames($id=0, $json=true)
	{
		$prepare = \DB::table('user');
		if($id)
		{
			$prepare = $prepare->where('id','<>',$id);
		}
		
		$result = $prepare->whereNull('deleted_at')->lists('username','id');
		return $json ? response()->json($result) : $result;
	}
	
	/**
	 * Get assignment options
	 * @return multitype:string
	 */
	public function getAssignmentOptions()
	{
		return [
			1 => 'Permanent',
			2 => 'Reassigned',
			3 => 'Temporary'			
		];	
	}
	
	/**
	 * Get gender
	 * @return multitype:string
	 */
	public function getGender()
	{
		return [
				//0 => 'NA',
				1 => 'Male',
				2 => 'Female'
		];
	}
	
	/**
	 * Return User Group Rights view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function userGroupRights()
	{
		return $this->view('userGroupRights');
	}
	
	public function getUsers()
	{
		$select = '
				user.id,
				user.created_at,
				CONCAT(user.firstname,\' \',user.lastname) fullname,
				app_area.area_name,
				IF(user.location_assignment_type = 1, \'Permanent\', IF(user.location_assignment_type = 2, \'Reassigned\', IF(user.location_assignment_type = 3, \'Temporary\', \'\'))) assignment,
				user_group.name role,
				user.status,
				user.email
				';
		
		$prepare = \DB::table('user')
						->selectRaw($select)
						->leftJoin('user_group','user.user_group_id','=','user_group.id')
						->leftJoin('app_area','app_area.area_code','=','user.location_assignment_code');		
		 
		$fnameFilter = FilterFactory::getInstance('Text');
		$prepare = $fnameFilter->addFilter($prepare,'fullname', function($filter, $model){
						return $model->where(function ($query) use ($filter){
							$query->where('user.firstname','like','%'.$filter->getValue().'%')
								  ->where('user.lastname','like','%'.$filter->getValue().'%','or');
						});						
					});
				
		$roleFilter = FilterFactory::getInstance('Select');
		$prepare = $roleFilter->addFilter($prepare,'user_group_id');
		
		$createdFilter = FilterFactory::getInstance('DateRange');
		$prepare = $createdFilter->addFilter($prepare,'created_at', function ($filter, $model){
					return $model->whereBetween(\DB::raw('DATE(user.created_at)'),$filter->getValue());			
					});
		
		$branchFilter = FilterFactory::getInstance('Select');
		$prepare = $branchFilter->addFilter($prepare,'location_assignment_code');
		
		$assignmentFilter = FilterFactory::getInstance('Select');
		$prepare = $assignmentFilter->addFilter($prepare,'location_assignment_type');
		
		$exclude = [1,auth()->user()->id];
		$prepare->whereNotIn('user.id',$exclude);
		$prepare->whereNull('user.deleted_at');
		
		//dd($prepare->toSql());
		$result = $this->paginate($prepare);
		
		$items = $result->items();
		
		foreach($items as $k=>$item)
		{
			if($item->status == 'A')
				$items[$k]->active = true;
			else
				$items[$k]->active = false;
		}
		
		$data['records'] = $items;
		$data['total'] = $result->total();
		
		return response()->json($data);
		
		
	}
	
	/**
	 * Get User Table Columns
	 * @return multitype:multitype:string
	 */
	public function getUserTableColumns()
	{
		$headers = [
				['name'=>'Full Name', 'sort'=>'lastname'],
				['name'=>'Email', 'sort'=>'email'],
				['name'=>'Role', 'sort'=>'role'],
				['name'=>'Branch', 'sort'=>'area_name'],
				['name'=>'Assignment', 'sort'=>'assignment'],
				['name'=>'Date Created', 'sort'=>'created_at'],
				['name'=>'Actions'],				
		];
		 
		return $headers;
	}
}
