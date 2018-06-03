{!!Html::breadcrumb(['SFI Transaction Data'])!!}
{!!Html::pageheader('SFI Transaction Data')!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                {!!Html::fopen('Toggle Filter')!!}
                        <div class="col-md-6">
                            {!!Html::select('salesman_code','Salesman', $salesman,'',['onchange'=>'setSalesmanDetails(this,"jr_salesman")'])!!}
                            {!!Html::select('jr_salesman','Jr Salesman', $jrSalesmans, 'No Jr. Salesman',['disabled'=>1])!!}
                            {!!Html::select('area','Area', $areas)!!}
                            {!!Html::select('customer','Customer Name', $customers)!!}
                            {!!Html::select('company_code','Company Code', $companyCode,'All')!!}
                        </div>
                        <div class="col-md-6">
                            {!!Html::datepicker('invoice_date','Invoice Date/Return Date','true')!!}
                            {!!Html::datepicker('posting_date','Posting Date',true)!!}
                            {!!Html::input('text','invoice_number','Invoice Number')!!}
                        </div>
               {!!Html::fclose()!!}

               {!!Html::topen([
                        'show_download'      => true,
                        'show_tab_delimited' => true,
                        'show_convert_sfi'   => true,
                        'show_search'        => true,
                        'no_pdf'			=> true,
               ])!!}
                        {!!Html::theader($tableHeaders)!!}
                            <tbody>
                                <tr ng-repeat="record in records|filter:query" id=[[$index]]>
                                    <td>[[record.so_number]]</td>
                                    <td>[[record.reference_num]]</td>
                                    <td>[[record.activity_code]]</td>
                                    <td>[[record.customer_code]]</td>
                                    <td>[[record.customer_name]]</td>
                                    <td>[[record.customer_address]]</td>
                                    <td>[[record.remarks]]</td>
                                    <td>[[record.van_code]]</td>
                                    <td>[[record.device_code]]</td>
                                    <td>[[record.salesman_code]]</td>
                                    <td>[[record.salesman_name]]</td>
                                    <td>[[record.area]]</td>
                                    <td id="records-[[$index]]-invoice_number_updated" ng-class="[record.invoice_number_updated]">
                                    	[[record.invoice_number]]
                                    </td>
                                    <td id="records-[[$index]]-invoice_date_updated" ng-class="[record.invoice_date_updated]">
                                    	[[formatDate(record.invoice_date) | date:'MM/dd/yyyy']]
                                    </td>
                                    <td id="records-[[$index]]-invoice_posting_date_updated" ng-class="[record.invoice_posting_date_updated]">
                                    	[[formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy']]
                                    </td>
                                    <td>
                                    	<span ng-bind="record.gross_served_amount = negate(record.gross_served_amount)"></span>
                                    </td>
                                    <td>
                                    	<span ng-bind="record.vat_amount = negate(record.vat_amount)"></span>
                                    </td>
                                    <td>[[record.discount_rate]]</td>
                                    <td>
                                    	<span ng-bind="record.discount_amount = negate(record.discount_amount)"></span>
                                    </td>
                                    <td>[[record.collective_discount_rate]]</td>
                                    <td>
                                    	<span ng-bind="record.collective_discount_amount = negate(record.collective_discount_amount)"></span>
                                    </td>
                                    <td>[[record.discount_reference_num]]</td>
                                    <td>[[record.discount_remarks]]</td>
                                    <td>
                                    	<span ng-bind="record.total_invoice = negate(record.total_invoice)"></span>
                                    </td>
                                    <td>[[record.item_code]]</td>
                                    <td>[[record.segment_abbr]]</td>
                                    <td>[[record.document_type]]</td>
                                    <td>[[record.company_code]]</td>
                                    <td>[[record.header_text]]</td>
                                    <td>[[record.gl_account]]</td>
                                    <td>[[record.tax_code]]</td>
                                    <td>[[record.profit_center]]</td>
                                    <td>[[record.detail_text]]</td>                                    
                                </tr>
                            </tbody>
                        {!!Html::tfooter(true,count($tableHeaders))!!}
                 {!!Html::tclose()!!}                
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
