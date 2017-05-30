<?php

namespace App\Http\Presenters;

use DB;
use App\Core\PresenterCore;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;

class UserAccessMatrixPresenter extends PresenterCore
{
    /**
     * Loads the User Access Matrix page on front-end
     * @return Laravel Blade View
     */
    public function user(){
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->users = $this->getUserList();
        $this->view->pageTitle = 'User Access Matrix';
        $this->view->navigationActions = $this->getNavigationActions('user-access-matrix',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => $user_id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
            'action'        => 'visit User Management - User Access Matrix'
        ]);

        return $this->view('index');
    }

    /**
     * Loads the Role Access Matrix page on front-end
     * @return Laravel Blade View
     */
    public function role(){
        $user_group_id = auth()->user()->group->id;
        $user_id = auth()->user()->id;

        $this->view->roles = PresenterFactory::getInstance('User')->getRoles();
        $this->view->pageTitle = 'Role Access Matrix';
        $this->view->navigationActions = $this->getNavigationActions('role-access-matrix',$user_group_id,$user_id);

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => $user_id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
            'action'        => 'visit User Management - Role Access Matrix'
        ]);

        return $this->view('index');
    }

    /**
     * Get List of Users
     * @return Array
     */
    public function getUserList(){
        return ModelFactory::getInstance('User')
            ->select('id',DB::raw("CONCAT(firstname,' ',lastname) as name"))
            ->where('status','=','A')
            ->lists('name','id')
            ->toArray();
    }

    /**
     * Get Actions of a Navigation
     * @param  {String} $slug
     * @param  {integer} $user_group_id
     * @param  {integer} $user_id
     * @return Array
     */
    public function getNavigationActions($slug, $user_group_id, $user_id){
        $navigation_id = ModelFactory::getInstance('Navigation')->where('slug','=',$slug)->value('id');

        $permissions = ModelFactory::getInstance('NavigationPermission')
            ->where('navigation_id','=',$navigation_id)
            ->select('id','permission')
            ->get()
            ->toArray();

        $role_permission = ModelFactory::getInstance('UserGroupToNavPermission')->getGroupNavigationPermissions($user_group_id)->toArray();
        $user_permission = ModelFactory::getInstance('UserGroupToNavPermissionOverride')->getUserNavigationPermissions($user_id)->toArray();

        $returned_data = [];
        foreach ($permissions as $key => $value) {
            $output = false;
            $status = '';
            $user_permission_exist = false;

            if(count($user_permission) > 0){
                foreach ($user_permission as $permission) {
                    if($value['id'] == $permission['permission_id']){
                        if($permission['status'] == 'denied'){
                            $status = $permission['status'];
                        }
                        if($permission['status'] == 'allowed' || ($permission['status'] == 'inherit' && in_array($permission['permission_id'], $role_permission))){
                            $output = true;
                            $user_permission_exist = true;
                        }
                        break;
                    }
                }
            }

            if(!$user_permission_exist){

                if($status == '' && in_array($value['id'], $role_permission)){
                    $output = true;
                }
            }

            $returned_data[$value['permission']] = $output;
        }

        return $returned_data;
    }

    /**
     * Return Allowed Navigations from navigation list
     * @param  {Array} $navigations
     * @return Array
     */
    public function getAllowedMenus($navigations){
        $user_group_id = auth()->user()->group->id;

        $user_id = auth()->user()->id;

        $allowedNavs = ModelFactory::getInstance('UserGroupToNav')->where('user_group_id','=',$user_group_id);

        $deniedMenus = ModelFactory::getInstance('UserGroupToNavOverride')->where('user_id','=',$user_id)->where('status','=','denied')->lists('navigation_id');

        if(count($deniedMenus) > 0){
            $allowedNavs = $allowedNavs->whereNotIn('navigation_id',$deniedMenus);
        }

        $allowedNavs = $allowedNavs->lists('navigation_id')->toArray();

        foreach ($navigations as $navigation_key => $navigation) {
            if(!in_array($navigation['id'],$allowedNavs)){
                unset($navigations[$navigation_key]);
            }

            if(!empty($navigations[$navigation_key]['sub'])){
                foreach ($navigations[$navigation_key]['sub'] as $navigation_sub_key => $navigation_sub) {
                    if(!in_array($navigations[$navigation_key]['sub'][$navigation_sub_key]['id'],$allowedNavs)){
                        unset($navigations[$navigation_key]['sub'][$navigation_sub_key]);
                    }
                }
            }
        }

        return $navigations;
    }
}