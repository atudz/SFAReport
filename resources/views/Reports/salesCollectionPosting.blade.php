{!!Html::breadcrumb(['Sales & Collection','Posting'])!!}
{!!Html::pageheader('Sales & Collection Posting')!!}

<div class="row" data-ng-controller="SalesCollectionPosting">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
						{!!Html::datepicker('collection_date','Collection Date','true')!!}
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
							<td>[[record.activity_code]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.customer_code]]</td>
							<td>[[record.customer_name]]</td>
							<td>[[record.remarks]]</td>
							<td>[[record.invoice_number]]</td>
							<td>[[record.total_invoice_net_amount]]</td>
							<td>[[record.invoice_date]]</td>
							<td>[[record.invoice_posting_date]]</td>
							<td>[[record.or_number]]</td>
							<td>[[record.or_amount]]</td>
							<td>[[record.check_date]]</td>
							<td>[[record.collection_posting_date]]</td>									
						</tr>					
					</tbody>
				{!!Html::tclose()!!}				
				
			</div>			
		</div>
	</div>
</div>
