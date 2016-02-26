{!!Html::breadcrumb(['Sales & Collection','Posting'])!!}
{!!Html::pageheader('Sales & Collection Posting')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6 col-xs-12">
						{!!Html::select('salesman','Salesman', $salesman)!!}
						{!!Html::select('company_code','Company Code', $companyCode)!!}
						{!!Html::input('text','customer_name','Customer Name')!!}						
						{!!Html::input('text','invoice_number','Invoice #')!!}
						{!!Html::input('text','or_number','OR #')!!}
					</div>					
					<div class="pull-right col-sm-6 col-xs-12">	
						{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
						{!!Html::datepicker('collection_date','Collection Date','true')!!}																									 			
						{!!Html::datepicker('posting_date','Posting Date','true')!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
							<td>[[record.activity_code]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.customer_code]]</td>
							<td>[[record.customer_name]]</td>
							<td>[[record.remarks]]</td>
							<td>[[record.invoice_number | uppercase]]</td>
							<td>
								<span ng-bind="formatNumber(record.total_invoice_net_amount)"></span>
							</td>
							<td>
								<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td>
								<span ng-bind="formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td>[[record.or_number | uppercase]]</td>
							<td>
								<span ng-bind="formatNumber(record.or_amount)"></span>
							</td>
							<td>
								<span ng-bind="formatDate(record.or_date) | date:'MM/dd/yyyy'"></span>
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
