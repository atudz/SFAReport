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
				<tr ng-repeat="record in records|filter:query">
					<td>[[record.customer_code]]</td>
					<td>[[record.customer_name]]</td>
					<td>[[record.remarks]]</td>
					<td>[[record.invoice_number]]</td>
					<td>
						<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>
					</td>
					<td>
						<span ng-bind="formatNumber(record.so_total_served)"></span>
					</td>
					<td>[[record.so_total_item_discount]]</td>
					<td>[[record.so_total_collective_discount]]</td>
					<td>
						<span ng-bind="formatNumber(record.total_invoice_amount)"></span>
					</td>
					<td>[[record.cm_number]]</td>
					<td>[[record.other_deduction_slip_number]]</td>
					<td>[[record.return_slip_num]]</td>
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
						<span ng-bind="formatDate(record.or_date) | date:'MM/dd/yyyy'"></span>
					</td>
					<td>[[record.or_number]]</td>
					<td>
						<span ng-bind="formatNumber(record.cash_amount)"></span>
					</td>
					<td>
						<span ng-bind="formatNumber(record.check_amount)"></span>
					</td>
					<td>[[record.bank]]</td>
					<td>[[record.check_number]]</td>
					<td>
						<span ng-bind="formatDate(record.check_date) | date:'MM/dd/yyyy'"></span>
					</td>
					<td>[[record.cm_number]]</td>
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
				<tr>
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
