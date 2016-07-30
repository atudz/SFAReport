{!!Html::breadcrumb(['User Management','Summary of Incident Report'])!!}
{!!Html::pageheader('Summary of Incident Report')!!}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- Filter -->
                {!!Html::fopen('Toggle Filter')!!}
                <div class="col-md-6">
                    {!!Html::select('name','name', $name,'')!!}
                    {{--{!!Html::select('branch','Branch:', $branch, '')!!}--}}
                    {!!Html::input('text','branch','Branch:')!!}
                    {!!Html::input('text','incident_no','Incident #:')!!}
                </div>
                <div class="col-md-6">
                    {!!Html::select('role','Role:', $roles, '')!!}
                    {!!Html::datepicker('date_range','Date Range <span class="required">*</span>','true')!!}
                </div>
                {!!Html::fclose()!!}
                        <!-- End Filter -->
                <div class="pull-left">
                    <div class="inner-addon left-addon">
                        <i class="glyphicon glyphicon-search"></i>
                        <input type="text" class="form-control input-sm" placeholder="Search" ng-model="query.$"/>
                    </div>
                </div>
                {!!Html::topen(['no_download'=>$isGuest2,'no_search'=>true,'no_loading'=>true])!!}
                {!!Html::theader($tableHeaders)!!}
                <tbody>
                    <tr ng-repeat="record in records |filter:query">
                        <td class="bold">[[ record.id ]]</td>
                        <td class="bold">[[ record.comment ]]</td>
                        <td class="bold">[[ record.status ]]</td>
                        <td class="bold">[[ record.name ]]</td>
                    </tr>
                </tbody>
                {!!Html::tclose(false)!!}
            </div>
        </div>
    </div>
</div>
