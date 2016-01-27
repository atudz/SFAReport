{!!Html::breadcrumb(['Sales & Collection','Posting'])!!}
{!!Html::pageheader('Sales & Collection Posting')!!}

<div class="row">
	<div class="col-lg-12">
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
							<td>[[record.activity_code]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.customer_code]]</td>
							<td>[[record.customer_name]]</td>
							<td>[[record.remarks]]</td>
							<td>[[record.invoice_number]]</td>
							<td>[[record.total_invoice_net_amount]]</td>
							<td>
								<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td>
								<span ng-bind="formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td>[[record.or_number]]</td>
							<td>[[record.or_amount]]</td>
							<td>
								<span ng-bind="formatDate(record.check_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td>
								<span ng-bind="formatDate(record.collection_posting_date) | date:'MM/dd/yyyy'"></span>
							</td>									
						</tr>					
					</tbody>
					{!!Html::tfooter(true,14)!!}	
				{!!Html::tclose()!!}				
				
			</div>			
		</div>
	</div>
</div>
