{!!Html::breadcrumb(['Profit Centers'])!!}
{!!Html::pageheader('Profit Centers')!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($navigationActions['show_table'])
                    {!!Html::topen([
                        'show_add_button' => $navigationActions['show_add_button'],
                        'add_link'        => 'profit.centers.add',
                        'show_search'     => true,
                    ])!!}
                        {!!Html::theader($tableHeaders)!!}
                            <tbody>
                                <tr ng-repeat="record in records|filter:query track by $index" id=[[$index]]>
                                    <td>[[record.profit_center]]</td>
                                    <td>[[record.area.area_name]]</td>
                                    <td>
                                        @if($navigationActions['show_edit_button'])
                                            <a href="#profit.centers.edit/[[record.id]]" uib-tooltip="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                                        @endif

                                        @if($navigationActions['show_delete_button'])
                                            <a style="cursor:pointer" ng-click="remove(record.id,$index)"><i class="fa fa-times fa-lg" uib-tooltip="Delete"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        {!!Html::tfooter(true,count($tableHeaders))!!}
                    {!!Html::tclose()!!}
                @endif
            </div>
        </div>
    </div>
</div>