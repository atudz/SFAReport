{!!Html::breadcrumb(['Sales Report','Per Peso'])!!}
{!!Html::pageheader('Per Peso')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::datepicker('posting_date','Posting Date',true)!!}
						{!!Html::datepicker('return_date','Return Date/ Invoice Date',true)!!}
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::select('salesman_code','Salesman', $salesman)!!}
						{!!Html::select('area','Area', $areas)!!}
						{!!Html::select('company_code','Company', $companyCode)!!}													 			
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
					<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
						<td>[[record.so_number]]</td>
						<td>[[record.reference_num]]</td>
						<td>[[record.activity_code]]</td>
						<td>[[record.customer_code]]</td>
						<td>[[record.customer_name]]</td>
						<td>
							<a href="#" editable-text="record.remarks" onbeforesave="update($data)">
    							[[ record.remarks ]]
  							</a>
						</td>
						<td>[[record.van_code]]</td>
						<td>[[record.device_code]]</td>
						<td>[[record.salesman_code]]</td>
						<td>[[record.salesman_name]]</td>
						<td>[[record.area]]</td>
						<td>
							<a href="" class="editable-click" ng-click="editColumn('text','txn_sales_order_header','invoice_number',record.sales_order_header_id,record.invoice_number,$index,'Invoice No/Return Slip No')">
    							[[ record.invoice_number ]]
  							</a>
						</td>
						<td>
							<a href="" class="editable-click" ng-click="editColumn('date','txn_sales_order_header','so_date',record.sales_order_header_id,record.invoice_date,$index,'Invoice Date/Return Date')">
    							<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>
  							</a>
						</td>
						<td>
							<a href="" class="editable-click" ng-click="editColumn('date','txn_sales_order_header','sfa_modified_date',record.sales_order_header_id,record.invoice_posting_date,$index,'Invoice/Return Posting Date')">
    							<span ng-bind="formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy'"></span>
  							</a>
						</td>
						<td>[[record.gross_seved_amount]]</td>
						<td>[[record.vat_amount]]</td>
						<td>[[record.discount_rate]]</td>
						<td>[[record.discount_amount]]</td>
						<td>[[record.collective_discount_rate]]</td>
						<td>[[record.collective_discount_amount]]</td>
						<td>[[record.discount_reference_num]]</td>
						<td>[[record.discount_remarks]]</td>
						<td>[[record.collective_deduction_rate]]</td>
						<td>[[record.collective_deduction_amount]]</td>
						<td>[[record.deduction_reference_num]]</td>
						<td>[[record.deduction_remarks]]</td>
						<td>[[record.total_invoice]]</td>
					</tr>
					</tbody>
					{!!Html::tfooter(true,27)!!}
				{!!Html::tclose()!!}
				
			</div>			
		</div>
	</div>
</div>
