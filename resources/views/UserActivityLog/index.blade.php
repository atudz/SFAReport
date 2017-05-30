{!!Html::breadcrumb(['User Management',$pageTitle])!!}
{!!Html::pageheader($pageTitle)!!}

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($navigationActions['show_filter'])
                    {!!Html::fopen('Toggle Filter')!!}
                        <div class="col-md-6">
                            @if($navigationActions['show_filter_user'])
                                {!!Html::select('user_id','Users', $users,'',[])!!}
                            @endif

                            {!!Html::select('navigation_id','Module', $navigations,'',['placeholder' => 'Select Module'])!!}
                        </div>
                        <div class="col-md-6">
                            {!!Html::datepicker('log_date','Date','true')!!}
                        </div>
                    {!!Html::fclose()!!}
                @endif

                @if($navigationActions['show_table'])
                    {!!Html::topen([
                        'show_download' => $navigationActions['show_download'],
                        'show_print'    => $navigationActions['show_print'],
                        'show_search'   => true,
                        'no_loading'    => true,
                        'no_xls'        => true
                    ])!!}
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>User</th>
                                <th>Location/Branch</th>
                                <th>Module</th>
                                <th>Access/Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-if="records.length > 0" ng-repeat="record in records|filter:query" id="[[record.id]]">
                                <td>[[ record.created_at ]]</td>
                                <td>[[ record.user.firstname + ' ' + record.user.lastname ]]</td>
                                <td>[[ record.user.area.area_name ]]</td>
                                <td>[[ record.navigation.name ]]</td>
                                <td>[[ record.user.group.name ]]</td>
                                <td>[[ record.action ]]</td>
                            </tr>
                            <tr ng-if="records.length == 0">
                                <td colspan="6">No Records</td>
                            </tr>
                        </tbody>
                        {!!Html::tfooter(true,6)!!}
                    {!!Html::tclose()!!}
                @endif
            </div>
        </div>
    </div>
</div>