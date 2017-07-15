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

    /**
     * load Permission either Role/User
     * @param  Request $request
     * @return json
     */
    public function loadPermissions(Request $request){
        $user_group_id = $request->get('user_group_id');
        $navigation_slug = 'role-access-matrix';

        if(!empty($request->get('user_group_id')) || $request->get('user_group_id') != ''){
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=',$navigation_slug)->value('id'),
                'action_identifier' => '',
                'action'            => 'loading User Management - Role Access Matrix data for user_group_id ' . $request->get('user_group_id')
            ]);
        }

        if(!empty($request->get('user_id')) || $request->get('user_id') != ''){
            $navigation_slug = 'user-access-matrix';
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=',$navigation_slug)->value('id'),
                'action_identifier' => '',
                'action'            => 'loading User Management - User Access Matrix data for user_id ' . $request->get('user_id')
            ]);
        }

        $user_id = $request->has('user_id') ? $request->get('user_id') : auth()->user()->id;
        $user_id_user_group_id = ModelFactory::getInstance('User')->where('id','=',$user_id)->first()->user_group_id;

        if($request->has('user_id')){
            $user_group_id = $user_id_user_group_id;
        }

        $data = [
            'navigations'               => $this->getNavigation(),
            'can_override'              => true,
            'user_nav_overrides'        => $this->nav_overrides->getUserNavigations($user_id)->toArray(),
            'user_nav_action_overrides' => $this->nav_permission_overrides->getUserNavigationPermissions($user_id)->toArray(),
            'user_navs'                 => $this->nav->getGroupNavigations($user_group_id)->toArray(),
            'user_nav_actions'          => $this->nav_permissions->getGroupNavigationPermissions($user_group_id)->toArray(),
        ];

        if(($navigation_slug == 'role-access-matrix' && $user_group_id == $user_id_user_group_id) || ($navigation_slug == 'user-access-matrix' && $request->get('user_id') != auth()->user()->id)){
            $data['can_override'] = false;
        }

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=',$navigation_slug)->value('id'),
            'action_identifier' => '',
            'action'            => 'done loading User Management - ' . ($navigation_slug == 'role-access-matrix' ? 'Role' : 'User') . ' Access Matrix data ' . ($navigation_slug == 'role-access-matrix' ? 'user_group_id ' . $request->get('user_group_id') : 'user_id ' . $request->get('user_id'))
        ]);

        return response()->json($data);
    }

    /**
     * save Permission either Role/User
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function savePermissions(Request $request){
        try{
            if($request->get('type') == 'role'){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                    'action_identifier' => '',
                    'action'            => 'Processing Role Access for user_group_id ' . $request->get('id')
                ]);

                if(count($request->get('allowed_navs')) > 0){
                    $this->nav->where('user_group_id','=',$request->get('id'))->whereNotIn('navigation_id',$request->get('allowed_navs'))->delete();

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'           => auth()->user()->id,
                        'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                        'action_identifier' => '',
                        'action'            => 'denied - Role Navigation Access not in ' . implode(',', $request->get('allowed_navs')) . ' for user_group_id ' . $request->get('id')
                    ]);

                    $db_allowed_navs = $this->nav->withTrashed()->where('user_group_id','=',$request->get('id'))->whereIn('navigation_id',$request->get('allowed_navs'))->lists('navigation_id')->toArray();
                    $not_added_nav_ids = array_diff($request->get('allowed_navs'), $db_allowed_navs);

                    $this->nav->withTrashed()->where('user_group_id','=',$request->get('id'))->whereIn('navigation_id',$request->get('allowed_navs'))->restore();

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'           => auth()->user()->id,
                        'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                        'action_identifier' => '',
                        'action'            => 'denied to allowed - Role Navigation Access ids in ' . implode(',', $request->get('allowed_navs')) . ' for user_group_id ' . $request->get('id')
                    ]);

                    if(!empty($not_added_nav_ids)){
                        foreach($not_added_nav_ids as $navigation_id){
                            $this->nav->create(['user_group_id' => $request->get('id'), 'navigation_id' => $navigation_id]);

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'           => auth()->user()->id,
                                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                                'action_identifier' => '',
                                'action'            => 'allowed - Role Navigation Access id ' . $navigation_id . ' for user_group_id ' . $request->get('id')
                            ]);
                        }
                    }
                }

                if(count($request->get('allowed_nav_actions')) > 0){
                    $this->nav_permissions->where('user_group_id','=',$request->get('id'))->whereNotIn('permission_id',$request->get('allowed_nav_actions'))->delete();

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'           => auth()->user()->id,
                        'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                        'action_identifier' => 'updating',
                        'action'            => 'denied - Role Navigation Permission Access not in ' . implode(',', $request->get('allowed_nav_actions')) . ' for user_group_id ' . $request->get('id')
                    ]);

                    $db_allowed_permissions = $this->nav_permissions->withTrashed()->where('user_group_id','=',$request->get('id'))->whereIn('permission_id',$request->get('allowed_nav_actions'))->lists('permission_id')->toArray();
                    $not_added_permission_ids = array_diff($request->get('allowed_nav_actions'), $db_allowed_permissions);

                    $this->nav_permissions->withTrashed()->where('user_group_id','=',$request->get('id'))->whereIn('permission_id',$request->get('allowed_nav_actions'))->restore();

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'           => auth()->user()->id,
                        'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                        'action_identifier' => 'updating',
                        'action'            => 'denied to allowed - Role Navigation Permission Access id in ' . implode(',', $request->get('allowed_nav_actions')) . ' for user_group_id ' . $request->get('id')
                    ]);

                    if(!empty($not_added_permission_ids)){
                        foreach($not_added_permission_ids as $permission_id){
                            $this->nav_permissions->create(['user_group_id' => $request->get('id'), 'permission_id' => $permission_id]);

                            ModelFactory::getInstance('UserActivityLog')->create([
                                'user_id'           => auth()->user()->id,
                                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                                'action_identifier' => 'creating',
                                'action'            => 'allowed - Role Navigation Permission Access id ' . $permission_id . ' for user_group_id ' . $request->get('id')
                            ]);
                        }
                    }
                }

                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','role-access-matrix')->value('id'),
                    'action_identifier' => '',
                    'action'            => 'done processing Role Access for user_group_id ' . $request->get('id')
                ]);
            }

            if($request->get('type') == 'user'){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                    'action_identifier' => '',
                    'action'            => 'Processing User Access for user_id ' . $request->get('id')
                ]);

                // User Access Matrix Parent & Child Navigations
                $inherit_nav_ids = !empty($request->get('user_navs')['inherit']) ? array_column($request->get('user_navs')['inherit'], 'id') : [];
                $allowed_nav_ids = !empty($request->get('user_navs')['allowed']) ? array_column($request->get('user_navs')['allowed'], 'id') : [];
                $denied_nav_ids = !empty($request->get('user_navs')['denied']) ? array_column($request->get('user_navs')['denied'], 'id') : [];
                $not_added_navigations = [];

                if(!empty($inherit_nav_ids)){
                    if(!empty($this->notAddedUserAccessMatrixNavigations($inherit_nav_ids,$request->get('user_navs')['inherit'],$request->get('id'),'inherit'))){
                        $not_added_navigations = array_merge($not_added_navigations,$this->notAddedUserAccessMatrixNavigations($inherit_nav_ids,$request->get('user_navs')['inherit'],$request->get('id'),'inherit'));
                    }
                    $this->updateUserAccessMatrixNavigations($inherit_nav_ids,$request->get('id'),'inherit');
                }

                if(!empty($allowed_nav_ids)){
                    if(!empty($this->notAddedUserAccessMatrixNavigations($allowed_nav_ids,$request->get('user_navs')['allowed'],$request->get('id'),'allowed'))){
                        $not_added_navigations = array_merge($not_added_navigations,$this->notAddedUserAccessMatrixNavigations($allowed_nav_ids,$request->get('user_navs')['allowed'],$request->get('id'),'allowed'));
                    }
                    $this->updateUserAccessMatrixNavigations($allowed_nav_ids,$request->get('id'),'allowed');
                }

                if(!empty($denied_nav_ids)){
                    if(!empty($this->notAddedUserAccessMatrixNavigations($denied_nav_ids,$request->get('user_navs')['denied'],$request->get('id'),'denied'))){
                        $not_added_navigations = array_merge($not_added_navigations,$this->notAddedUserAccessMatrixNavigations($denied_nav_ids,$request->get('user_navs')['denied'],$request->get('id'),'denied'));
                    }
                    $this->updateUserAccessMatrixNavigations($denied_nav_ids,$request->get('id'),'denied');
                }

                if(!empty($not_added_navigations)){
                    foreach($not_added_navigations as $navigation){
                        $this->nav_overrides->create(['user_id' => $request->get('id'), 'navigation_id' => $navigation['id'], 'status' => $navigation['status']]);

                        ModelFactory::getInstance('UserActivityLog')->create([
                            'user_id'           => auth()->user()->id,
                            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                            'action_identifier' => 'creating',
                            'action'            => 'creating - User Navigation Access ' . $navigation['id'] . ' to ' . $navigation['status'] . ' for user_id ' . $request->get('id')
                        ]);
                    }
                }

                // User Access Matrix Navigation Permissions
                $inherit_nav_action_ids = !empty($request->get('user_nav_actions')['inherit']) ? array_column($request->get('user_nav_actions')['inherit'], 'id') : [];
                $allowed_nav_action_ids = !empty($request->get('user_nav_actions')['allowed']) ? array_column($request->get('user_nav_actions')['allowed'], 'id') : [];
                $denied_nav_action_ids = !empty($request->get('user_nav_actions')['denied']) ? array_column($request->get('user_nav_actions')['denied'], 'id') : [];
                $not_added_navigation_actions = [];

                if(!empty($inherit_nav_action_ids)){
                    if(!empty($this->notAddedUserAccessMatrixNavigationPermissions($inherit_nav_action_ids,$request->get('user_nav_actions')['inherit'],$request->get('id'),'inherit'))){
                        $not_added_navigation_actions = array_merge($not_added_navigation_actions,$this->notAddedUserAccessMatrixNavigationPermissions($inherit_nav_action_ids,$request->get('user_nav_actions')['inherit'],$request->get('id'),'inherit'));
                    }
                    $this->updateUserAccessMatrixNavigationActions($inherit_nav_action_ids,$request->get('id'),'inherit');
                }

                if(!empty($allowed_nav_action_ids)){
                    if(!empty($this->notAddedUserAccessMatrixNavigationPermissions($allowed_nav_action_ids,$request->get('user_nav_actions')['allowed'],$request->get('id'),'allowed'))){
                        $not_added_navigation_actions = array_merge($not_added_navigation_actions,$this->notAddedUserAccessMatrixNavigationPermissions($allowed_nav_action_ids,$request->get('user_nav_actions')['allowed'],$request->get('id'),'allowed'));
                    }
                    $this->updateUserAccessMatrixNavigationActions($allowed_nav_action_ids,$request->get('id'),'allowed');
                }

                if(!empty($denied_nav_action_ids)){
                    if(!empty($this->notAddedUserAccessMatrixNavigationPermissions($denied_nav_action_ids,$request->get('user_nav_actions')['denied'],$request->get('id'),'denied'))){
                        $not_added_navigation_actions = array_merge($not_added_navigation_actions,$this->notAddedUserAccessMatrixNavigationPermissions($denied_nav_action_ids,$request->get('user_nav_actions')['denied'],$request->get('id'),'denied'));
                    }
                    $this->updateUserAccessMatrixNavigationActions($denied_nav_action_ids,$request->get('id'),'denied');
                }

                if(!empty($not_added_navigation_actions)){
                    foreach($not_added_navigation_actions as $navigation_action){
                        $this->nav_permission_overrides->create(['user_id' => $request->get('id'), 'permission_id' => $navigation_action['id'], 'status' => $navigation_action['status']]);

                        ModelFactory::getInstance('UserActivityLog')->create([
                            'user_id'           => auth()->user()->id,
                            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                            'action_identifier' => 'creating',
                            'action'            => 'creating - User Navigation Permission Access ' . $navigation_action['id'] . ' to ' . $navigation_action['status'] . ' for user_id ' . $request->get('id')
                        ]);
                    }
                }

                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                    'action_identifier' => '',
                    'action'            => 'done processing User Access for user_id ' . $request->get('id')
                ]);
            }

            return response()->json(['success'=>true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=', $request->get('type') . '-access-matrix')->value('id'),
                'action_identifier' => '',
                'action'            => 'error processing ' . ucfirst($request->get('type')) . ' Access for user_' . ($request->get('id') == 'role' ? 'group_id' : 'id') . $request->get('id')
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Get Navigations with actions,children and children action
     * @return Array
     */
    public function getNavigation(){
        return ModelFactory::getInstance('Navigation')
            ->with('action','children','children.action')
            ->where('parent_id','=',0)
            ->get()
            ->toArray();
    }

    /**
     * Update User Access Matrix Navigations
     * @param  [Array] $ids
     * @param  [int] $user_id
     * @param  [String] $status
     * @return None
     */
    public function updateUserAccessMatrixNavigations($ids,$user_id,$status){
        if(!empty($ids)){
            $this->nav_overrides->where('user_id','=',$user_id)->whereIn('navigation_id',$ids)->update(['status' => $status]);

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'updating - User Navigation Access ' . implode(',', $ids) . ' to ' . $status . ' for user_id ' . $user_id
            ]);
        }
    }

    /**
     * Get Not Added User Access Matrix Navigations
     * @param  [Array] $ids
     * @param  [Array] $compare_array
     * @param  [int] $user_id
     * @param  [String] $status
     * @return Array
     */
    public function notAddedUserAccessMatrixNavigations($ids,$compare_array,$user_id,$status){
        $db_navs = $this->nav_overrides->withTrashed()->where('user_id','=',$user_id)->whereIn('navigation_id',$ids)->where('status','=',$status)->lists('navigation_id')->toArray();
        return array_filter($compare_array, function($arrayValue) use($db_navs) {
            if(!in_array($arrayValue['id'], $db_navs)){
                return $arrayValue;
            }
        });
    }

    /**
     * Update User Access Matrix Navigation Actions
     * @param  [Array] $ids
     * @param  [int] $user_id
     * @param  [String] $status
     * @return None
     */
    public function updateUserAccessMatrixNavigationActions($ids,$user_id,$status){
        if(!empty($ids)){
            $this->nav_permission_overrides->where('user_id','=',$user_id)->whereIn('permission_id',$ids)->update(['status' => $status]);
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-access-matrix')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'updating - User Navigation Permission Access ' . implode(',', $ids) . ' to ' . $status . ' for user_id ' . $user_id
            ]);
        }
    }

    /**
     * Get Not Added User Access Matrix Navigation Permissions
     * @param  [Array] $ids
     * @param  [Array] $compare_array
     * @param  [int] $user_id
     * @param  [String] $status
     * @return Array
     */
    public function notAddedUserAccessMatrixNavigationPermissions($ids,$compare_array,$user_id,$status){
        $db_navs = $this->nav_permission_overrides->withTrashed()->where('user_id','=',$user_id)->whereIn('permission_id',$ids)->where('status','=',$status)->lists('permission_id')->toArray();
        return array_filter($compare_array, function($arrayValue) use($db_navs) {
            if(!in_array($arrayValue['id'], $db_navs)){
                return $arrayValue;
            }
        });
    }
}