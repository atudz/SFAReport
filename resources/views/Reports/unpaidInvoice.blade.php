{!!Html::breadcrumb(['Unpaid Invoice'])!!}
{!!Html::pageheader('Unpaid Invoice')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6 col-xs-12">
						{!!Html::select('company_code','Company', $companyCode)!!}
						{!!Html::select('salesman','Salesman', $salesman)!!}											
						{!!Html::select('customer','Customer', $customers)!!}
					</div>					
					<div class="pull-right col-sm-6 col-xs-12">	
						{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
						{!!Html::input('text','invoice_number','Invoice #')!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
							<td>[[record.salesman_name]]</td>						
							<td>[[record.area_name]]</td>
							<td>[[record.customer_code]]</td>
							<td>[[record.customer_name]]</td>
							<td>[[record.remarks]]</td>
							<td>[[record.invoice_number | uppercase]]</td>
							<td>
								<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td>							
								<span ng-bind="formatNumber(record.original_amount)"></span>
							</td>
							<td>
								<span ng-bind="formatNumber(record.balance_amount)"></span>
							</td>
						</tr>
						
						<!-- Summary total -->
						<tr id="total_summary">
							<th>Total</th>						
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<th>
								<span ng-bind="formatNumber(summary.original_amount)"></span>
							</th>
							<th>
								<span ng-bind="formatNumber(summary.balance_amount)"></span>
							</th>
						</tr>					
					</tbody>
				
					{!!Html::tfooter(true,9)!!}
				{!!Html::tclose()!!}				
			</div>			
		</div>
	</div>
</div>
