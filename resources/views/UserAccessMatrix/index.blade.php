{!!Html::breadcrumb(['User Management',$pageTitle])!!}
{!!Html::pageheader($pageTitle)!!}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($navigationActions['can_view_permission'])
                    {!!Html::fopen('Toggle Filter')!!}
                        @if(array_key_exists('can_edit_role_permission', $navigationActions) && $navigationActions['can_edit_role_permission'])
                            <div class="col-md-6">
                                {!!Html::select('user_group_id','Role', $roles,'',[])!!}
                            </div>
                        @endif

                        @if(array_key_exists('can_edit_user_role_permission', $navigationActions) && $navigationActions['can_edit_user_role_permission'])
                            <div class="col-md-6">
                                {{-- {!!Html::select('location_assignment_code','Branch', $areas,'',['placeholder' => 'Select Branch','disabled' => 'disabled'])!!} --}}
                                {!!Html::select('user_id','Users', $users,'',['placeholder' => 'Select User'])!!}
                            </div>
                        @endif
                    {!!Html::fclose()!!}
                @endif
            </div>

            <div class="panel-body">
                <div class="col-sm-12" ng-repeat="navigation in navigations track by $index" ng-init="parent_index = $index">
                    <h4 class="parent-navigation">
                        [[ navigation.name ]]
                        <span class="pull-right user-access-matrix-label" ng-if="savePermissionData.type == 'user'">Inherit</span>
                        <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'user'" ng-checked="navigation.status == 'inherit'" ng-click="parentChange(parent_index,'inherit')">
                        <span class="pull-right user-access-matrix-label">Deny</span>
                        <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'role'" ng-checked="navigation.status == false" ng-click="parentChange(parent_index,false)">
                        <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'user'" ng-checked="navigation.status == 'denied'" ng-click="parentChange(parent_index,'denied')">
                        <span class="pull-right user-access-matrix-label">Allow</span>
                        <input type="radio" class="pull-right user-access-matrix-checkbox allow" ng-if="savePermissionData.type == 'role'" ng-checked="navigation.status == true" ng-click="parentChange(parent_index,true)">
                        <input type="radio" class="pull-right user-access-matrix-checkbox allow" ng-if="savePermissionData.type == 'user'" ng-checked="navigation.status == 'allowed'" ng-click="parentChange(parent_index,'allowed')">
                    </h4>

                    <h5 ng-if="navigation.children.length > 0" ng-click="hideSubMenu(navigation.id)">&emsp;<strong>Sub Menus</strong>&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></h5>
                    <div class="navigation-[[navigation.id]]" ng-repeat="child in navigation.children track by $index" ng-init="child_index = $index">
                        <h5 ng-if="navigation.children.length > 0" class="child-navigation">
                            &emsp;&emsp;[[ child.name ]]
                            <span class="pull-right user-access-matrix-label" ng-if="savePermissionData.type == 'user'">Inherit</span>
                            <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'user'" ng-checked="child.status == 'inherit'" ng-click="childChange(parent_index,child_index,'inherit')">
                            <span class="pull-right user-access-matrix-label">Deny</span>
                            <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'role'" ng-checked="child.status == false" ng-click="childChange(parent_index,child_index,false)">
                            <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'user'" ng-checked="child.status == 'denied'" ng-click="childChange(parent_index,child_index,'denied')">
                            <span class="pull-right user-access-matrix-label">Allow</span>
                            <input type="radio" class="pull-right user-access-matrix-checkbox allow" ng-if="savePermissionData.type == 'role'" ng-checked="child.status == true" ng-click="childChange(parent_index,child_index,true)">
                            <input type="radio" class="pull-right user-access-matrix-checkbox allow" ng-if="savePermissionData.type == 'user'" ng-checked="child.status == 'allowed'" ng-click="childChange(parent_index,child_index,'allowed')">
                        </h5>

                        <h6 ng-if="child.action.length > 0" ng-click="hideAction(child.id)">&emsp;&emsp;&emsp;&emsp;<strong>Actions</strong>&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                        <h6 class="navigation-[[child.id]]-action" ng-if="child.action.length > 0" ng-repeat="child_action in child.action track by $index" ng-init="child_action_index = $index">
                            &emsp;&emsp;&emsp;&emsp;&emsp;[[ child_action.description ]]
                            <span class="pull-right user-access-matrix-label" ng-if="savePermissionData.type == 'user'">Inherit</span>
                            <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'user'" ng-checked="child_action.status == 'inherit'" ng-click="childActionChange(parent_index,child_index,child_action_index,'inherit')">
                            <span class="pull-right user-access-matrix-label">Deny</span>
                            <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'role'" ng-checked="child_action.status == false" ng-click="childActionChange(parent_index,child_index,child_action_index,false)">
                            <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'user'" ng-checked="child_action.status == 'denied'" ng-click="childActionChange(parent_index,child_index,child_action_index,'denied')">
                            <span class="pull-right user-access-matrix-label">Allow</span>
                            <input type="radio" class="pull-right user-access-matrix-checkbox allow" ng-if="savePermissionData.type == 'role'" ng-checked="child_action.status == true" ng-click="childActionChange(parent_index,child_index,child_action_index,true)">
                            <input type="radio" class="pull-right user-access-matrix-checkbox allow" ng-if="savePermissionData.type == 'user'" ng-checked="child_action.status == 'allowed'" ng-click="childActionChange(parent_index,child_index,child_action_index,'allowed')">
                        </h6>
                    </div>

                    <h5 ng-if="navigation.action.length > 0" ng-click="hideAction(navigation.id)">&emsp;<strong>Actions</strong>&nbsp;<i class="fa fa-caret-down" aria-hidden="true"></i></h5>
                    <h6 class="navigation-[[navigation.id]]-action" ng-if="navigation.action.length > 0" ng-repeat="navigation_action in navigation.action track by $index" ng-init="parent_action_index = $index">
                        &emsp;&emsp;[[ navigation_action.description ]]
                        <span class="pull-right user-access-matrix-label" ng-if="savePermissionData.type == 'user'">Inherit</span>
                        <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'user'" ng-checked="navigation_action.status == 'inherit'" ng-click="parentActionChange(parent_index,parent_action_index,'inherit')">
                        <span class="pull-right user-access-matrix-label">Deny</span>
                        <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'role'" ng-checked="navigation_action.status == false" ng-click="parentActionChange(parent_index,parent_action_index,false)">
                        <input type="radio" class="pull-right user-access-matrix-checkbox deny" ng-if="savePermissionData.type == 'user'" ng-checked="navigation_action.status == 'denied'" ng-click="parentActionChange(parent_index,parent_action_index,'denied')">
                        <span class="pull-right user-access-matrix-label">Allow</span>
                        <input type="radio" class="pull-right user-access-matrix-checkbox allow" ng-if="savePermissionData.type == 'role'" ng-checked="navigation_action.status == true" ng-click="parentActionChange(parent_index,parent_action_index,true)">
                        <input type="radio" class="pull-right user-access-matrix-checkbox allow" ng-if="savePermissionData.type == 'user'" ng-checked="navigation_action.status == 'allowed'" ng-click="parentActionChange(parent_index,parent_action_index,'allowed')">
                    </h6>
                    <hr>
                </div>
            </div>

            @if($navigationActions['can_view_permission'])
                <div class="rs-mini-toolbar" ng-if="navigations.length > 0">
                    <div class="rs-toolbar-savebtn">
                        <a class="button-primary revgreen disabled" ng-click="savePermission()" id="button_save_slide-tb" original-title="" style="display: block; cursor:pointer;"><i class="fa fa-floppy-o" style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>Save</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>