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
        $navigation_slug = '';

        $data = [
            'navigations' => $this->getNavigation()
        ];

        if(!empty($request->get('user_group_id')) || $request->get('user_group_id') != ''){
            $data['user_nav_overrides'] = [];
            $data['user_nav_action_overrides'] = [];
            $navigation_slug = 'role-access-matrix';

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=',$navigation_slug)->value('id'),
                'action'        => 'loading User Management - Role Access Matrix data for user_group_id ' . $request->get('user_group_id')
            ]);
        }

        if(!empty($request->get('user_id')) || $request->get('user_id') != ''){
            $user_group_id = ModelFactory::getInstance('User')->where('id','=',$request->get('user_id'))->first()->user_group_id;
            $data['user_nav_overrides'] = $this->nav_overrides->getUserNavigations($request->get('user_id'))->toArray();
            $data['user_nav_action_overrides'] = $this->nav_permission_overrides->getUserNavigationPermissions($request->get('user_id'))->toArray();
            $navigation_slug = 'user-access-matrix';

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=',$navigation_slug)->value('id'),
                'action'        => 'loading User Management - User Access Matrix data for user_id ' . $request->get('user_id')
            ]);
        }

        $data['user_navs'] = $this->nav->getGroupNavigations($user_group_id)->toArray();
        $data['user_nav_actions'] =  $this->nav_permissions->getGroupNavigationPermissions($user_group_id)->toArray();

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => auth()->user()->id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=',$navigation_slug)->value('id'),
            'action'        => 'finished loading User Management - ' . ($navigation_slug == 'role-access-matrix' ? 'Role' : 'User') . ' Access Matrix data ' . ($navigation_slug == 'role-access-matrix' ? 'user_group_id ' . $request->get('user_group_id') : 'user_id ' . $request->get('user_id'))
        ]);

        return response()->json($data);
    }

    public function savePermissions(Request $request){
        try{
            if($request->get('type') == 'role'){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'       => auth()->user()->id,
                    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                    'action'        => 'Processing Role Access for user_group_id ' . $request->get('id')
                ]);

                if(count($request->get('allowed_navs')) > 0){
                    $this->nav->where('user_group_id','=',$request->get('id'))->whereNotIn('navigation_id',$request->get('allowed_navs'))->delete();

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'       => auth()->user()->id,
                        'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                        'action'        => 'denied - Role Navigation Access not in ' . implode(',', $request->get('allowed_navs')) . ' for user_group_id ' . $request->get('id')
                    ]);

                    foreach($request->get('allowed_navs') as $navigation_id){
                        if($this->nav->withTrashed()->where('user_group_id','=',$request->get('id'))->where('navigation_id','=',$navigation_id)->first()){
                            $this->nav->withTrashed()->where('user_group_id','=',$request->get('id'))->where('navigation_id','=',$navigation_id)->restore();

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'       => auth()->user()->id,
                                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                                'action'        => 'denied to allowed - Role Navigation Access id ' . $navigation_id . ' for user_group_id ' . $request->get('id')
                            ]);
                        } else {
                            $this->nav->create(['user_group_id' => $request->get('id'), 'navigation_id' => $navigation_id]);

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'       => auth()->user()->id,
                                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                                'action'        => 'allowed - Role Navigation Access id ' . $navigation_id . ' for user_group_id ' . $request->get('id')
                            ]);
                        }
                    }
                }

                if(count($request->get('allowed_nav_actions')) > 0){
                    $this->nav_permissions->where('user_group_id','=',$request->get('id'))->whereNotIn('permission_id',$request->get('allowed_nav_actions'))->delete();

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'       => auth()->user()->id,
                        'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                        'action'        => 'denied - Role Navigation Permission Access not in ' . implode(',', $request->get('allowed_nav_actions')) . ' for user_group_id ' . $request->get('id')
                    ]);

                    foreach($request->get('allowed_nav_actions') as $permission_id){
                        if($this->nav_permissions->withTrashed()->where('user_group_id','=',$request->get('id'))->where('permission_id','=',$permission_id)->first()){
                            $this->nav_permissions->withTrashed()->where('user_group_id','=',$request->get('id'))->where('permission_id','=',$permission_id)->restore();

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'       => auth()->user()->id,
                                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                                'action'        => 'denied to allowed - Role Navigation Permission Access id ' . $permission_id . ' for user_group_id ' . $request->get('id')
                            ]);
                        } else {
                            $this->nav_permissions->create(['user_group_id' => $request->get('id'), 'permission_id' => $permission_id]);

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'       => auth()->user()->id,
                                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                                'action'        => 'allowed - Role Navigation Permission Access id ' . $permission_id . ' for user_group_id ' . $request->get('id')
                            ]);
                        }
                    }
                }

                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'       => auth()->user()->id,
                    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                    'action'        => 'done processing Role Access for user_group_id ' . $request->get('id')
                ]);
            }

            if($request->get('type') == 'user'){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'       => auth()->user()->id,
                    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                    'action'        => 'Processing User Access for user_id ' . $request->get('id')
                ]);

                if(count($request->get('user_navs')) > 0){
                    foreach($request->get('user_navs') as $navigation){
                        if($this->nav_overrides->where('user_id','=',$request->get('id'))->where('navigation_id','=',$navigation['id'])->first()){
                            $this->nav_overrides->where('user_id','=',$request->get('id'))->where('navigation_id','=',$navigation['id'])->update(['status' => $navigation['status']]);

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'       => auth()->user()->id,
                                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                                'action'        => 'updating - User Navigation Access ' . $navigation['id'] . ' to ' . $navigation['status'] . ' for user_id ' . $request->get('id')
                            ]);
                        } else{
                            $this->nav_overrides->create(['user_id' => $request->get('id'), 'navigation_id' => $navigation['id'], 'status' => $navigation['status']]);

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'       => auth()->user()->id,
                                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                                'action'        => 'creating - User Navigation Access ' . $navigation['id'] . ' to ' . $navigation['status'] . ' for user_id ' . $request->get('id')
                            ]);
                        }
                    }
                }

                if(count($request->get('user_nav_actions')) > 0){
                    foreach($request->get('user_nav_actions') as $navigation_action){
                        if($this->nav_permission_overrides->where('user_id','=',$request->get('id'))->where('permission_id','=',$navigation_action['id'])->first()){
                            $this->nav_permission_overrides->where('user_id','=',$request->get('id'))->where('permission_id','=',$navigation_action['id'])->update(['status' => $navigation_action['status']]);

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'       => auth()->user()->id,
                                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                                'action'        => 'updating - User Navigation Permission Access ' . $navigation_action['id'] . ' to ' . $navigation_action['status'] . ' for user_id ' . $request->get('id')
                            ]);
                        } else{
                            $this->nav_permission_overrides->create(['user_id' => $request->get('id'), 'permission_id' => $navigation_action['id'], 'status' => $navigation_action['status']]);

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'       => auth()->user()->id,
                                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                                'action'        => 'creating - User Navigation Permission Access ' . $navigation_action['id'] . ' to ' . $navigation_action['status'] . ' for user_id ' . $request->get('id')
                            ]);
                        }
                    }
                }

                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'       => auth()->user()->id,
                    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                    'action'        => 'done processing User Access for user_id ' . $request->get('id')
                ]);
            }

            return response()->json(['success'=>true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=', $request->get('type') . '-access-matrix')->value('id'),
                'action'        => 'error processing ' . ucfirst($request->get('type')) . ' Access for user_' . ($request->get('id') == 'role' ? 'group_id' : 'id') . $request->get('id')
            ]);

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