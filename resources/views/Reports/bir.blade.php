{!!Html::breadcrumb(['BIR'])!!}
{!!Html::pageheader('BIR')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-6">
						{!!Html::select('salesman','Salesman', $salesman)!!}
						{!!Html::select('area','Area', $area)!!}									
						{!!Html::input('text','reference','Reference #')!!}								
					</div>					
					<div class="col-md-6">	
						{!!Html::datepicker('document_date','Document Date','true')!!}
						{!!Html::input('text','customer_name','Customer Name')!!}						
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
							<td>
								<span ng-bind="record.document_date_formatted = (formatDate(record.document_date) | date:'MM/dd/yyyy')"></span>
							</td>						
							<td>[[record.name]]</td>
							<td>[[record.customer_address]]</td>
							<td>[[record.depot]]</td>
							<td>[[record.reference | uppercase]]</td>
							<td></td>
							<td></td>
							<td>
								<span ng-bind="record.sales_formatted = formatNumber(record.sales,record.negate)"></span>
							</td>
							<td></td>							
							<td>
								<span ng-bind="record.total_sales_formatted = formatNumber(record.total_sales,record.negate)"></span>
							</td>
							<td>
								<span ng-bind="record.tax_amount_formatted = formatNumber(record.tax_amount,record.negate)"></span>
							</td>
							<td>
								<span ng-bind="record.total_invoice_amount_formatted = formatNumber(record.total_invoice_amount,record.negate)"></span>
							</td>
							<td>
								<span ng-bind="record.local_sales_formatted = formatNumber(record.local_sales,record.negate)"></span>
							</td>
							<td></td>
							<td>
								<span ng-bind="record.term_cash_formatted = formatNumber(record.term_cash,record.negate)"></span>
							</td>
							<td></td>
							<td>[[record.sales_group]]</td>
							<td>[[record.assignment]]</td>
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
							<td class="bold">
								<span ng-bind="summary.sales_formatted = formatNumber(summary.sales,summary.negate)"></span>
							</td>
							<td></td>							
							<td class="bold">
								<span ng-bind="summary.total_sales_formatted = formatNumber(summary.total_sales,summary.negate)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.tax_amount_formatted = formatNumber(summary.tax_amount,summary.negate)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.total_invoice_amount_formatted = formatNumber(summary.total_invoice_amount,summary.negate)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.local_sales_formatted = formatNumber(summary.local_sales,summary.negate)"></span>
							</td>
							<td></td>
							<td class="bold">
								<span ng-bind="summary.term_cash_formatted = formatNumber(summary.term_cash,summary.negate)"></span>
							</td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						
					</tbody>
					{!!Html::tfooter(true,18)!!}
				{!!Html::tclose()!!}				
			</div>			
		</div>
	</div>
</div>
