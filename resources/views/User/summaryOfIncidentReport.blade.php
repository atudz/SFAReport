{!!Html::breadcrumb(['Support Page','Summary of Incident Report'])!!}
{!!Html::pageheader('Summary of Incident Report')!!}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- Filter -->
                {!!Html::fopen('Toggle Filter')!!}
                <div class="col-md-6">

                    {!!Html::error('error','error_filter_contact')!!}
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
                {!!Html::topen(['no_download'=>$isGuest2,'no_loading'=>true])!!}
                {!!Html::theader($tableHeaders)!!}
                <tbody>
                <tr ng-repeat="record in records |filter:query | orderBy:propertyName:reverse" ng-if="records.length != 0">
                    <td class="bold">[[ record.id | number ]]</td>
                    <td class="bold">[[ record.subject ]]</td>
                    <td class="bold">[[ record.message | limitTo: 20 ]] [[ record.message.length > 40 ? '...' : '' ]]</td>
                    <td class="bold">[[ record.action ]]</td>
                    <td class="bold">[[ record.status ]]</td>
                    <td class="bold">[[ record.full_name ]]</td>
                    <td class="bold">[[ record.areas[0].area_name ]]</td>
                    <td class="bold">[[ record.created_at ]]</td>
                </tr>
                </tbody>
                {!!Html::tfooter(true,8)!!}
                {!!Html::tclose(false)!!}
            </div>
        </div>
    </div>
</div>
