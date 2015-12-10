{!!Html::breadcrumb(['Sales & Collection','Reports'])!!}
{!!Html::pageheader('Sales & Collection Report')!!}

<div class="row" data-ng-controller="SalesCollectionReport">
	<div class="col-sm-12">
		<div class="panel panel-default">
		<div class="panel-body">		
			<!-- Filter -->			
			{!!Html::fopen('Toggle Filter')!!}
				<div class="pull-left col-sm-6">
					{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
					{!!Html::datepicker('collection_date','Collection Date','true')!!}
				</div>					
				<div class="pull-right col-sm-6">	
					{!!Html::select('customer_code','Customer Code', ['Name1','Name2'])!!}
					{!!Html::select('salesman','Salesman', ['Name1','Name2'])!!}							 			
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
					<td>[[record.invoice_date]]</td>
					<td>[[record.so_total_served]]</td>
					<td>[[record.so_total_item_discount]]</td>
					<td>[[record.so_total_collective_discount]]</td>
					<td>[[record.total_invoice_amount]]</td>
					<td>[[record.cm_number]]</td>
					<td>[[record.other_deduction_slip_number]]</td>
					<td>[[record.return_slip_num]]</td>
					<td>[[record.RTN_total_gross]]</td>
					<td>[[record.RTN_total_collective_discount]]</td>
					<td>[[record.RTN_net_amount]]</td>
					<td>[[record.total_invoice_net_amount]]</td>
					<td>[[record.or_date]]</td>
					<td>[[record.or_number]]</td>
					<td>[[record.cash_amount]]</td>
					<td>[[record.check_amount]]</td>
					<td>[[record.bank]]</td>
					<td>[[record.check_number]]</td>
					<td>[[record.check_date]]</td>
					<td>[[record.cm_number]]</td>
					<td>[[record.cm_date]]</td>
					<td>[[record.credit_amount]]</td>
					<td>[[record.total_collected_amount]]</td>									
				</tr>
				</tbody>
			{!!Html::tclose()!!}
	
		</div>		
		</div>		
	</div>
</div>
