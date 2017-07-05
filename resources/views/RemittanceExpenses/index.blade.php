{!!Html::breadcrumb(['Remittance/Expense Report'])!!}
{!!Html::pageheader('Remittance/Expense Report')!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($navigationActions['show_filter'])
                    {!!Html::fopen('Toggle Filter')!!}
                        <div class="col-md-6">
                            {!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman, 'Select Salesman',['onchange'=>'setSalesmanDetails(this,"jr_salesman")'])!!}
                            {!!Html::select('jr_salesman','Jr Salesman', $jrSalesmans, 'No Jr. Salesman',['disabled'=>1])!!}
                        </div>
                        <div class="col-md-6">
                            {!!Html::datepicker('date','Date <span class="required">*</span>','true')!!}
                        </div>
                    {!!Html::fclose()!!}
                @endif

                @if($navigationActions['show_table'])
                    {!!Html::topen([
                        'show_add_button' => true,
                        'add_link'        => 'remittance.expenses.report.add',
                        'show_search'     => true
                    ])!!}
                        {!!Html::theader($tableHeaders,[])!!}
                        <tbody>
                            <tr ng-repeat="record in records|filter:query track by $index" id=[[$index]]>
                                <td>[[ record.id ]]</td>
                                <td>[[ record.sr_salesman.salesman_name ]]</td>
                                <td>[[ record.jr_salesman.jr_salesman_name ]]</td>
                                <td><span class="pull-right">P [[ record.cash_amount | number:2 ]]</span></td>
                                <td><span class="pull-right">P [[ record.check_amount | number:2 ]]</span></td>
                                <td class="text-center">[[ (record.date_from | date:'longDate') + ' - ' + (record.date_to | date:'longDate') ]]</td>
                                <td>
                                    @if($navigationActions['show_edit_button'])
                                        <a href="#remittance.expenses.report.edit/[[record.id]]" uib-tooltip="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                                    @endif

                                    @if($navigationActions['show_delete_button'] && $navigationActions['can_delete'])
                                        <a style="cursor:pointer" ng-click="remove($index,record.id)"><i class="fa fa-times fa-lg" uib-tooltip="Delete"></i></a>
                                    @endif

                                    @if($navigationActions['show_print'] && $navigationActions['show_download'])
                                        <a style="cursor:pointer" href="/controller/remittance-expenses-report/[[record.id]]?download=pdf"><i class="fa fa-file-pdf-o fa-lg" uib-tooltip="Print to PDF"></i></a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                        {!!Html::tfooter(true,7)!!}
                    {!!Html::tclose()!!}
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function setSalesmanDetails(el,target_el)
    {
        var jrSalesman = [];
        @foreach($jrSalesmans as $k => $val)
            jrSalesman.push('{{ $k }}');
        @endforeach

        var sel = $(el).val();
        if(-1 !== $.inArray(sel,jrSalesman)) {
            $('select[name=' + target_el + ']').val(sel);
        } else {
            $('select[name=' + target_el + ']').val('');
        }
    }
</script>