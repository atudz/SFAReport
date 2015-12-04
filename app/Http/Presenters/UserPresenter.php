<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;

class UserPresenter extends PresenterCore
{
	/**
	 * Return User List view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function userList()
	{
		return $this->view('users');
	}

	
	public function changePassword(){
		return $this->view('changePassword');
	}
	
	public function profile(){
		return $this->view('myProfile');
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
}
