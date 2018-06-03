{!!Html::breadcrumb(['GL Accounts'])!!}
{!!Html::pageheader('GL Accounts')!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                	{!!Html::topen([
                        'show_add_button' => true,
                        'add_link'        => 'gl.accounts.add',
                        'show_search'     => true,
                        'no_download' => true,
                    ])!!}
                        {!!Html::theader($tableHeaders)!!}
                            <tbody>
                                <tr ng-repeat="record in records|filter:query track by $index" id=[[$index]]>
                                    <td>[[record.code]]</td>
                                    <td>[[record.description]]</td>
                                    <td>
                                        <a href="#gl.accounts.edit/[[record.id]]" uib-tooltip="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                                        <a style="cursor:pointer" ng-click="remove(record.id,$index)"><i class="fa fa-times fa-lg" uib-tooltip="Delete"></i></a>                                        
                                    </td>
                                </tr>
                            </tbody>
                        {!!Html::tfooter(true,count($tableHeaders))!!}
                    {!!Html::tclose()!!}                
            </div>
        </div>
    </div>
</div>