{!!Html::breadcrumb(['Sales & Collection','Reports'])!!}
{!!Html::pageheader('Sales & Collection Report')!!}

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
		<div class="panel-body">		
			<!-- Filter -->			
			{!!Html::fopen('Toggle Filter')!!}
				<div class="pull-left col-sm-6">
					{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
					{!!Html::datepicker('collection_date','Collection Date','true')!!}
					{!!Html::input('text','invoice_number','Invoice #')!!}
					{!!Html::input('text','or_number','OR #')!!}
				</div>					
				<div class="pull-right col-sm-6">	
					{!!Html::select('customer_code','Customer Code', $customerCode)!!}
					{!!Html::select('salesman','Salesman', $salesman)!!}							 			
					{!!Html::datepicker('posting_date','Posting Date','true')!!}
				</div>			
			{!!Html::fclose()!!}
			<!-- End Filter -->
			
			{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
				<tbody>
				<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
					<td>[[record.customer_code]]</td>
					<td>[[record.customer_name]]</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('text','txn_evaluated_objective','remarks',record.evaluated_objective_id,record.remarks,$index,'Remarks')">
    						[[ record.remarks ]]
  						</a>
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('text','txn_sales_order_header','invoice_number',record.sales_order_header_id,record.invoice_number,$index,'Invoice Number','invoice_number')">
    						[[ record.invoice_number ]]
  						</a>
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('date','txn_sales_order_header','so_date',record.sales_order_header_id,record.invoice_date,$index,'Invoice Date','invoice_date')">
    						<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>
  						</a>						
					</td>
					<td>
						<span ng-bind="formatNumber(record.so_total_served)"></span>
					</td>
					<td>[[record.so_total_item_discount]]</td>
					<td>[[record.so_total_collective_discount]]</td>
					<td>
						<span ng-bind="formatNumber(record.total_invoice_amount)"></span>
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','cm_number',record.collection_detail_id,record.cm_number,$index,'CM Number','cm_number')">
    						[[ record.cm_number ]]
  						</a>
					</td>
					<td>[[record.other_deduction_amount]]</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('text','txn_return_header','return_slip_num',record.return_header_id,record.return_slip_num,$index,'Return Slip Number','return_slip_num')">
    						[[record.return_slip_num]]
  						</a>
					</td>
					<td>
						<span ng-bind="formatNumber(record.RTN_total_gross)"></span>
					</td>
					<td>[[record.RTN_total_collective_discount]]</td>
					<td>
						<span ng-bind="formatNumber(record.RTN_net_amount)"></span>
					</td>
					<td>
						<span ng-bind="formatNumber(record.total_invoice_net_amount)"></span>
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_header','or_date',record.collection_header_id,record.or_date,$index,'Collection Date','or_date')">
    						<span ng-bind="formatDate(record.or_date) | date:'MM/dd/yyyy'"></span>
  						</a>						
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_header','or_number',record.collection_header_id,record.or_number,$index,'OR Number','or_number')">
    						[[record.or_number]]
  						</a>
					</td>
					<td>
						<span ng-bind="formatNumber(record.cash_amount)"></span>
					</td>
					<td>
						<span ng-bind="formatNumber(record.check_amount)"></span>
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','bank',record.collection_detail_id,record.bank,$index,'Bank Name','bank')">
    						[[record.bank]]
  						</a>
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','check_number',record.collection_detail_id,record.check_number,$index,'Check No','check_number')">
    						[[record.check_number]]
  						</a>
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_detail','check_date',record.collection_detail_id,record.check_date,$index,'Check Date','check_date')">
    						<span ng-bind="formatDate(record.check_date) | date:'MM/dd/yyyy'"></span>
  						</a>						
					</td>
					<td>
						<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','cm_number',record.collection_detail_id,record.cm_number,$index,'CM No','cm_number')">
    						[[record.cm_number]]
  						</a>
					</td>
					<td>
						<span ng-bind="formatDate(record.cm_date) | date:'MM/dd/yyyy'"></span>
					</td>
					<td>
						<span ng-bind="formatNumber(record.credit_amount)"></span>
					</td>
					<td>
						<span ng-bind="formatNumber(record.total_collected_amount)"></span>
					</td>									
				</tr>
				
				<!-- Summary -->
				<tr id="total_summary">
					<th>Total</th>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<th>
						<span ng-bind="formatNumber(summary.so_total_served)"></span>
					</th>
					<td></td>
					<th>
						<span ng-bind="formatNumber(summary.so_total_collective_discount)"></span>
					</th>
					<th>
						<span ng-bind="formatNumber(summary.total_invoice_amount)"></span>
					</th>
					<td></td>
					<td></td>
					<td></td>
					<th>
						<span ng-bind="formatNumber(summary.RTN_total_gross)"></span>
					</th>
					<th>
						<span ng-bind="formatNumber(summary.RTN_total_collective_discount)"></span>
					</th>
					<th>
						<span ng-bind="formatNumber(summary.RTN_net_amount)"></span>
					</th>
					<th>
						<span ng-bind="formatNumber(summary.total_invoice_net_amount)"></span>
					</th>
					<td></td>
					<td></td>
					<th>
						<span ng-bind="formatNumber(summary.cash_amount)"></span>
					</th>
					<th>
						<span ng-bind="formatNumber(summary.check_amount)"></span>
					</th>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<th>
						<span ng-bind="formatNumber(summary.total_collected_amount)"></span>
					</th>									
				</tr>
				</tbody>
				{!!Html::tfooter(true,27)!!}
			{!!Html::tclose()!!}
	
		</div>		
		</div>		
	</div>
</div>
