{!!Html::breadcrumb(['Support Page','Summary of Incident Report'])!!}
{!!Html::pageheader('Summary of Incident Report')!!}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($navigationActions['show_filter'])
                    <!-- Filter -->
                    {!!Html::fopen('Toggle Filter')!!}
                    <div class="col-md-6">
                        {!!Html::select('name','Reported By:', $name,'All')!!}
                        {!!Html::select('branch','Branch:', $branch, 'All')!!}
                        {!!Html::input('text','incident_no','Incident #:','')!!}
                        {!!Html::input('text','subject','Subject:','')!!}
                    </div>
                    <div class="col-md-6">
                        {!!Html::input('text','action','Action:','')!!}
                        {!!Html::input('text','status','Status:','')!!}
                        {!!Html::datepicker('date_range','Date Range:','true')!!}
                    </div>
                    {!!Html::fclose()!!}
                @endif

                @if($navigationActions['show_table'])
                    {!!Html::topen([
                        'show_download' => $navigationActions['show_download'],
                        'show_print'    => $navigationActions['show_print'],
                        'show_search'   => $navigationActions['show_search_field'],
                    ])!!}
                        {!!Html::theader($tableHeaders,$navigationActions['can_sort_columns'])!!}
                            <tbody>
                                <tr ng-repeat="record in records |filter:query | orderBy:propertyName:reverse" ng-if="records.length != 0">
                                    <td>[[ record.id | number ]]</td>
                                    <td>[[ record.created_at ]]</td>
                                    <td>[[ record.subject ]]</td>
                                    <td>[[ record.message | limitTo: 20 ]] [[ record.message.length > 40 ? '...' : '' ]]</td>
                                    <td>[[ record.full_name ]]</td>
                                    <td>[[ record.areas[0].area_name ]]</td>
                                    <td>[[ record.status ]]</td>
                                    <td class="bold">[[ record.action ]]</td>
                                </tr>
                            </tbody>
                        {!!Html::tfooter(true,8)!!}
                    {!!Html::tclose(false)!!}
                @endif
            </div>
        </div>
    </div>
</div>
