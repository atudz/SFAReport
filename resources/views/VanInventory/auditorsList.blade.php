{!!Html::breadcrumb(['Van Inventory','Auditors List'])!!}
{!!Html::pageheader('Auditors List')!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($navigationActions['show_filter'])
                    {!!Html::fopen('Toggle Filter')!!}
                        <div class="col-md-6">
                            {!!Html::select('auditor_id','Auditor', $auditors)!!}
                            {!!Html::select('salesman_code','Salesman', $salesman,'All',[])!!}
                            {!!Html::select('area_code','Area', $areas)!!}
                        </div>
                        <div class="col-md-6">
                            {!!Html::select('type','Type',['canned' => 'Canned & Mixes', 'frozen' => 'Frozen & Kassel'])!!}
                            {!!Html::datepicker('period','Period <span class="required">*</span>','true')!!}
                        </div>
                    {!!Html::fclose()!!}
                @endif

                @if($navigationActions['show_table'])
                    {!!Html::topen([
                        'show_download'   => $navigationActions['show_download'],
                        'show_print'      => $navigationActions['show_print'],
                        'show_add_button' => $navigationActions['show_add_button'],
                        'add_link'        => 'auditors.list.add',
                        'show_search'     => true,
                    ])!!}
                        {!!Html::theader($tableHeaders,[
                            'can_sort' => $navigationActions['can_sort_columns']
                        ])!!}
                        <tbody>
                            <tr ng-repeat="record in records|filter:query track by $index" id=[[$index]] class=[[record.updated]]>
                                <td>[[ record.user.firstname + ' ' + record.user.lastname ]]</td>
                                <td>[[ (record.period_from | date:'longDate') + ' - ' + (record.period_to | date:'longDate') ]]</td>
                                <td>[[ record.type | uppercase ]]</td>
                                <td>[[ record.salesman.salesman_name ]]</td>
                                <td>[[ record.area.area_name ]]</td>
                                <td>
                                    @if($navigationActions['show_edit_button'])
                                        <a href="#auditors.list.edit/[[record.id]]" uib-tooltip="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                                    @endif

                                    @if($navigationActions['show_delete_button'] && $navigationActions['can_delete'])
                                        <a style="cursor:pointer" ng-click="remove(record.id,$index)"><i class="fa fa-times fa-lg" uib-tooltip="Delete"></i></a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        {!!Html::tfooter(true,6)!!}
                    {!!Html::tclose()!!}
                @endif
            </div>
        </div>
    </div>
</div>