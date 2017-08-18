{!!Html::breadcrumb(['SFI Transaction Data'])!!}
{!!Html::pageheader('SFI Transaction Data')!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($navigationActions['show_filter'])
                    {!!Html::fopen('Toggle Filter')!!}
                        <div class="col-md-6">
                            {!!Html::select('salesman_code','Salesman', $salesman,'',['onchange'=>'setSalesmanDetails(this,"jr_salesman")'])!!}
                            {!!Html::select('jr_salesman','Jr Salesman', $jrSalesmans, 'No Jr. Salesman',['disabled'=>1])!!}
                            {!!Html::select('area_code','Area', $areas)!!}
                            {!!Html::select('customer_code','Customer Name', $customers)!!}
                            {!!Html::select('company_code','Company Code', $companyCode,'All')!!}
                        </div>
                        <div class="col-md-6">
                            {!!Html::datepicker('so_date','Invoice Date/Return Date','true')!!}
                            {!!Html::datepicker('posting_date','Posting Date',false)!!}
                            {!!Html::input('text','invoice_number','Invoice Number')!!}
                        </div>
                    {!!Html::fclose()!!}
                @endif

                @if($navigationActions['show_table'])
                    {!!Html::topen([
                        'show_download'      => $navigationActions['show_download'],
                        'show_tab_delimited' => $navigationActions['show_tab_delimited'],
                        'show_convert_sfi'   => $navigationActions['show_convert_sfi'],
                        'show_search'        => true,
                    ])!!}
                        {!!Html::theader($tableHeaders)!!}
                            <tbody>
                                <tr ng-repeat="record in records|filter:query" id=[[$index]]>
                                    <td>[[record.so_number]]</td>
                                    <td>[[record.reference_num]]</td>
                                    <td>[[record.sales.activity_salesman.activity_code]]</td>
                                    <td>[[record.sales.customer_code]]</td>
                                    <td>[[record.sales.customer.customer_name]]</td>
                                    <td>[[record.sales.customer.customer_address]]</td>
                                    <td>[[record.sales.activity_salesman.evaluated_objective[0].remarks]]</td>
                                    <td>[[record.sales.van_code]]</td>
                                    <td>[[record.sales.device_code]]</td>
                                    <td>[[record.sales.salesman_code]]</td>
                                    <td>[[record.sales.salesman.salesman_name]]</td>
                                    <td>[[record.sales.customer.area.area]]</td>
                                    <td>[[record.sales.invoice_number]]</td>
                                    <td>[[formatDate(record.sales.invoice_date) | date:'MM/dd/yyyy']]</td>
                                    <td>[[formatDate(record.sales.invoice_posting_date) | date:'MM/dd/yyyy']]</td>
                                    <td>[[record.gross_served_amount]]</td>
                                    <td>[[record.vat_amount]]</td>
                                    <td>[[record.discount_rate]]%</td>
                                    <td>[[record.discount_amount]]</td>
                                    <td>[[record.sales.sales_order_header_discount.hasOwnProperty('served_deduction_rate') ? record.sales.sales_order_header_discount.served_deduction_rate : 0]]%</td>
                                    <td>[[record.collective_discount_amount]]</td>
                                    <td>[[record.sales.sales_order_header_discount.discount_reference_num]]</td>
                                    <td>[[record.sales.sales_order_header_discount.remarks]]</td>
                                    <td>[[record.total_sales]]</td>
                                    <td>[[record.app_item_master.segment_code]]</td>
                                    <td>[[record.app_item_master.segment.abbreviation]]</td>
                                    <td>DR</td>
                                    <td>[[record.sales.company_code]]</td>
                                    <td>[[record.sales.van_code + '-' + record.sales.salesman.salesman_name | uppercase]]</td>
                                    <td ng-if="record.sales.company_code_after.substr(0, 1) == 1">110000</td>
                                    <td ng-if="record.sales.company_code_after.substr(0, 1) == 2">110010</td>
                                    <td ng-if="record.sales.company_code == '1000'">01</td>
                                    <td ng-if="record.sales.company_code == '2000'">OX</td>
                                    <td>[[record.sales.customer.area.profit_center.profit_center]]</td>
                                    <td>[[record.app_item_master.segment.abbreviation + '-' + record.sales.customer.customer_name | uppercase]]</td>
                                </tr>
                            </tbody>
                        {!!Html::tfooter(true,count($tableHeaders))!!}
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
