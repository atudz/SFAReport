{!!Html::breadcrumb(['User Management','Summary of Incident Report'])!!}
{!!Html::pageheader('Summary of Incident Report')!!}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- Filter -->
                {!!Html::fopen('Toggle Filter')!!}
                <div class="col-md-6">
                    {!!Html::select('name','Full Name', $name,'', ['ng-model' => 'params.name'])!!}
                    {!!Html::select('branch','Branch:', $branch, '', ['ng-model' => 'params.branch'])!!}
                    {!!Html::input('text','incident_no','Incident #:','', ['ng-model' => 'params.incident_no'])!!}
                </div>
                <div class="col-md-6">
                    {!!Html::datepicker('date_range','Date Range','true')!!}
                </div>
                {!!Html::fclose()!!}
                {!!Html::topen(['no_download'=>$isGuest2,'no_loading'=>true])!!}
                {!!Html::theader($tableHeaders)!!}
                <tbody>
                <tr ng-repeat="record in records |filter:query" ng-if="records.length != 0">
                    <td class="bold">[[ record.id ]]</td>
                    <td class="bold">[[ record.comment | limitTo: 20 ]] [[ record.comment.length > 20 ? '...' : '' ]]</td>
                    <td class="bold">[[ record.status ]]</td>
                    <td class="bold">[[ record.users.firstname ]] [[ record.users.lastname ]]</td>
                    <td> <a href="#status.reply" uib-tooltip="send mail" class="text-info"><i class="fa fa-paper-plane"></i></a> </td>
                </tr>
                <tr ng-if="records.length == 0">
                    <td class="bold">No records found.</td>
                    <td class="bold"></td>
                    <td class="bold"></td>
                    <td class="bold"></td>
                </tr>
                </tbody>
                {!!Html::tfooter(true,7)!!}
                {!!Html::tclose(false)!!}
            </div>
        </div>
    </div>
</div>
