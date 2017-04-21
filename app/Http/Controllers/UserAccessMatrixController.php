<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use Illuminate\Http\Request;

class UserAccessMatrixController extends ControllerCore
{
    protected $nav;

    protected $nav_overrides;

    protected $nav_permissions;

    protected $nav_action_overrides;

    public function __construct(){
        $this->nav = ModelFactory::getInstance('UserGroupToNav');

        $this->nav_overrides = ModelFactory::getInstance('UserGroupToNavOverride');

        $this->nav_permissions = ModelFactory::getInstance('UserGroupToNavPermission');

        $this->nav_permission_overrides = ModelFactory::getInstance('UserGroupToNavPermissionOverride');
    }

    public function loadPermissions(Request $request){
        $user_group_id = $request->get('user_group_id');

        $data = [
            'navigations' => $this->getNavigation()
        ];

        if(!empty($request->get('user_group_id')) || $request->get('user_group_id') != ''){
            $data['user_nav_overrides'] = [];
            $data['user_nav_action_overrides'] = [];
        }

        if(!empty($request->get('user_id')) || $request->get('user_id') != ''){
            $user_group_id = ModelFactory::getInstance('User')->where('id','=',$request->get('user_id'))->first()->user_group_id;
            $data['user_nav_overrides'] = $this->nav_overrides->getUserNavigations($request->get('user_id'))->toArray();
            $data['user_nav_action_overrides'] = $this->nav_permission_overrides->getUserNavigationPermissions($request->get('user_id'))->toArray();
        }

        $data['user_navs'] = $this->nav->getGroupNavigations($user_group_id)->toArray();
        $data['user_nav_actions'] =  $this->nav_permissions->getGroupNavigationPermissions($user_group_id)->toArray();
        return response()->json($data);
    }

    public function savePermissions(Request $request){
        try{
            if($request->get('type') == 'role'){
                if(count($request->get('allowed_navs')) > 0){
                    $this->nav->where('user_group_id','=',$request->get('id'))->whereNotIn('navigation_id',$request->get('allowed_navs'))->delete();

                    foreach($request->get('allowed_navs') as $navigation_id){
                        if($this->nav->withTrashed()->where('user_group_id','=',$request->get('id'))->where('navigation_id','=',$navigation_id)->first()){
                            $this->nav->withTrashed()->where('user_group_id','=',$request->get('id'))->where('navigation_id','=',$navigation_id)->restore();
                        } else {
                            $this->nav->create(['user_group_id' => $request->get('id'), 'navigation_id' => $navigation_id]);
                        }
                    }
                }

                if(count($request->get('allowed_nav_actions')) > 0){
                    $this->nav_permissions->where('user_group_id','=',$request->get('id'))->whereNotIn('permission_id',$request->get('allowed_nav_actions'))->delete();

                    foreach($request->get('allowed_nav_actions') as $permission_id){
                        if($this->nav_permissions->withTrashed()->where('user_group_id','=',$request->get('id'))->where('permission_id','=',$permission_id)->first()){
                            $this->nav_permissions->withTrashed()->where('user_group_id','=',$request->get('id'))->where('permission_id','=',$permission_id)->restore();
                        } else {
                            $this->nav_permissions->create(['user_group_id' => $request->get('id'), 'permission_id' => $permission_id]);
                        }
                    }
                }
            }

            if($request->get('type') == 'user'){
                if(count($request->get('user_navs')) > 0){
                    foreach($request->get('user_navs') as $navigation){
                        if($this->nav_overrides->where('user_id','=',$request->get('id'))->where('navigation_id','=',$navigation['id'])->first()){
                            $this->nav_overrides->where('user_id','=',$request->get('id'))->where('navigation_id','=',$navigation['id'])->update(['status' => $navigation['status']]);
                        } else{
                            $this->nav_overrides->create(['user_id' => $request->get('id'), 'navigation_id' => $navigation['id'], 'status' => $navigation['status']]);
                        }
                    }
                }

                if(count($request->get('user_nav_actions')) > 0){
                    foreach($request->get('user_nav_actions') as $navigation_action){
                        if($this->nav_permission_overrides->where('user_id','=',$request->get('id'))->where('permission_id','=',$navigation_action['id'])->first()){
                            $this->nav_permission_overrides->where('user_id','=',$request->get('id'))->where('permission_id','=',$navigation_action['id'])->update(['status' => $navigation_action['status']]);
                        } else{
                            $this->nav_permission_overrides->create(['user_id' => $request->get('id'), 'permission_id' => $navigation_action['id'], 'status' => $navigation_action['status']]);
                        }
                    }
                }
            }
            return response()->json(['success'=>true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function getNavigation(){
        return ModelFactory::getInstance('Navigation')
            ->with('action','children','children.action')
            ->where('parent_id','=',0)
            ->get()
            ->toArray();
    }
}