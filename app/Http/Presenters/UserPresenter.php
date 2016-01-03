<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\FilterFactory;
use App\Factories\PresenterFactory;

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
		$this->view->tableHeaders = $this->getUserTableColumns();
		return $this->view('users');
	}

	
	/**
	 * Display add edit form
	 * @param number $userId
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function addEdit($userId=0)
	{
		$this->view->statuses = PresenterFactory::getInstance('Reports')->getCustomerStatus();
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea();
		return $this->view('addEdit');
	}
	
	
	public function changePassword(){
		return $this->view('changePassword');
	}
	
	public function profile(){
		return $this->view('myProfile');
	}
	
	/**
	 * Get user roles
	 */
	public function getRoles()
	{
		return \DB::table('user_group')->orderBy('name')->lists('name','id');	
	}
	
	/**
	 * Get user emails
	 */
	public function getUserEmails($id=0)
	{
		return \DB::table('user')->whereNotNull('deleted_at')->lists('email','id');
	}
	
	/**
	 * Get assignment options
	 * @return multitype:string
	 */
	public function getAssignmentOptions()
	{
		return [
			0 => 'Permanent',
			1 => 'Reassigned',
			2 => 'Temporary'			
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
				user_group.name role ';
		
		$prepare = \DB::table('user')
						->selectRaw($select)
						->leftJoin('user_group','user.user_group_id','=','user_group.id');		
		 
		$fnameFilter = FilterFactory::getInstance('Text');
		$prepare = $fnameFilter->addFilter($prepare,'fullname', function($filter, $model){
			dd($filter->getValue);
						return $model->where('user.firstname','like',$filter->getValue().'%')
									 ->orWhere('user.lastname','like',$filter->getValue().'%');
					});
				
		$roleFilter = FilterFactory::getInstance('Select');
		$prepare = $roleFilter->addFilter($prepare,'user_group_id');
		
		$createdFilter = FilterFactory::getInstance('DateRange');
		$prepare = $createdFilter->addFilter($prepare,'created_at', function ($filter, $model){
					return $model->whereBetween(\DB::raw('DATE(user.created_at)'),$filter->getValue());			
					});
		
		//dd($prepare->toSql());
		$result = $this->paginate($prepare);
		
		$data['records'] = $result->items();
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
				['name'=>'Role', 'sort'=>'role'],
				//['name'=>'Branch', 'sort'=>'area'],
				//['name'=>'Assignment', 'sort'=>'area'],
				['name'=>'Date Created', 'sort'=>'created_at'],
				['name'=>'Actions'],				
		];
		 
		return $headers;
	}
}
