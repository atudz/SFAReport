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
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
							<td>
								<span ng-bind="formatDate(record.document_date) | date:'MM/dd/yyyy'"></span>
							</td>						
							<td>[[record.name]]</td>
							<td>[[record.customer_address]]</td>
							<td>[[record.depot]]</td>
							<td>[[record.reference | uppercase]]</td>
							<td></td>
							<td></td>
							<td>
								<span ng-bind="formatNumber(record.sales,record.negate)"></span>
							</td>
							<td></td>							
							<td>
								<span ng-bind="formatNumber(record.total_sales,record.negate)"></span>
							</td>
							<td>
								<span ng-bind="formatNumber(record.tax_amount,record.negate)"></span>
							</td>
							<td>
								<span ng-bind="formatNumber(record.total_invoice_amount,record.negate)"></span>
							</td>
							<td>
								<span ng-bind="formatNumber(record.local_sales,record.negate)"></span>
							</td>
							<td></td>
							<td>
								<span ng-bind="formatNumber(record.term_cash,record.negate)"></span>
							</td>
							<td></td>
							<td>[[record.sales_group]]</td>
							<td>[[record.assignment]]</td>
						</tr>
						
					</tbody>
					{!!Html::tfooter(true,18)!!}
				{!!Html::tclose()!!}				
			</div>			
		</div>
	</div>
</div>
