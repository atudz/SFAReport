{!!Html::breadcrumb(['Sales Report','Per Material'])!!}
{!!Html::pageheader('Per Material')!!}


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::datepicker('posting_date','Posting Date',true)!!}
						{!!Html::datepicker('return_date','Return Date/ Invoice Date',true)!!}
						{!!Html::select('company_code','Company', $companyCode)!!}
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::select('salesman_code','Salesman', $salesman)!!}
						{!!Html::select('area','Area', $areas)!!}
						{!!Html::select('customer','Customer', $customers)!!}													 			
						{!!Html::select('material','Material', $items)!!}
						{!!Html::select('segment','Segment', $segments)!!}
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
						<!-- <td>[[record.remarks]]</td> -->
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
						<td>[[record.segment_code]]</td>
						<td>[[record.item_code]]</td>
						<td>[[record.description]]</td>
						<td>
							<a href="" class="editable-click" ng-click="editColumn('text','txn_return_detail','quantity',record.return_detail_id,record.quantity,$index,'Quantity')">
    							[[record.quantity]]
  							</a>
						</td>
						<td>
							<a href="" class="editable-click" ng-click="editColumn('select','txn_return_detail','condition_code',record.return_detail_id,record.condition_code,$index,'Condition Code')">
    							[[record.condition_code]]
  							</a>
						</td>
						<td>[[record.uom_code]]</td>
						<td>
							<span ng-bind="formatNumber(record.gross_seved_amount)"></span>
						</td>
						<td>
							<span ng-bind="formatNumber(record.vat_amount)"></span>
						</td>
						<td>[[record.discount_rate]]</td>
						<td>
							<span ng-bind="formatNumber(record.discount_amount)"></span>
						</td>
						<td>[[record.collective_discount_rate]]</td>
						<td>
							<span ng-bind="formatNumber(record.collective_discount_amount)"></span>
						</td>
						<td>[[record.discount_reference_num]]</td>
						<td>[[record.discount_remarks]]</td>
						<td>[[record.collective_deduction_rate]]</td>
						<td>
							<span ng-bind="formatNumber(record.collective_deduction_amount)"></span>
						</td>
						<td>[[record.deduction_reference_num]]</td>
						<td>[[record.deduction_remarks]]</td>
						<td>
							<span ng-bind="formatNumber(record.total_invoice)"></span>
						</td>
					</tr>
					</tbody>
					{!!Html::tfooter(true,33)!!}					
				{!!Html::tclose()!!}
			</div>			
		</div>
	</div>
</div>
