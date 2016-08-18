{!!Html::breadcrumb(['User Management','Summary of Incident Report'])!!}
{!!Html::pageheader('Summary of Incident Report')!!}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- Filter -->
                {!!Html::fopen('Toggle Filter')!!}
                <div class="col-md-6">
                    {!!Html::error('error','error_filter_contact')!!}
                    {!!Html::select('name','Full Name:', $name,'All')!!}
                    {!!Html::select('branch','Branch:', $branch, 'All')!!}
                    {!!Html::input('text','incident_no','Incident #:','')!!}
                </div>
                <div class="col-md-6">
                    {!!Html::datepicker('date_range','Date Range:','true')!!}
                </div>
                {!!Html::fclose()!!}
                {!!Html::topen(['no_download'=>$isGuest2,'no_loading'=>true])!!}
                {!!Html::theader($tableHeaders)!!}
                <tbody>
                <tr ng-repeat="record in records |filter:query" ng-if="records.length != 0">
                    <td class="bold">[[ record.id ]]</td>
                    <td class="bold">[[ record.message | limitTo: 20 ]] [[ record.message.length > 40 ? '...' : '' ]]</td>
                    <td class="bold">[[ record.status ]]</td>
                    <td class="bold">[[ record.full_name ]]</td>
                </tr>
                </tbody>
                {!!Html::tfooter(true,7)!!}
                {!!Html::tclose(false)!!}
            </div>
        </div>
    </div>
</div>
