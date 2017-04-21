{!!Html::breadcrumb(['BIR'])!!}
{!!Html::pageheader('BIR')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
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
				@endif

				@if($navigationActions['show_table'])
					{!!Html::topen([
						'show_download' => $navigationActions['show_download'],
						'show_print'    => $navigationActions['show_print'],
						'show_search'   => $navigationActions['show_search_field'],
					])!!}
						{!!Html::theader($tableHeaders,$navigationActions['can_sort_columns'])!!}
						<tbody>
						<tbody ng-repeat="item in items">
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
										<span ng-bind="record.sales_formatted = negate(record.sales)"></span>
									</td>
									<td></td>							
									<td>
										<span ng-bind="record.total_sales_formatted = negate(record.total_sales)"></span>
									</td>
									<td>
										<span ng-bind="record.tax_amount_formatted = negate(record.tax_amount)"></span>
									</td>
									<td>
										<span ng-bind="record.total_invoice_amount_formatted = negate(record.total_invoice_amount)"></span>
									</td>
									<td>
										<span ng-bind="record.local_sales_formatted = negate(record.local_sales)"></span>
									</td>
									<td></td>
									<td>
										<span ng-bind="record.term_cash_formatted = negate(record.term_cash)"></span>
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
										<span ng-bind="summary.sales_formatted = negate(summary.sales)"></span>
									</td>
									<td></td>							
									<td class="bold">
										<span ng-bind="summary.total_sales_formatted = negate(summary.total_sales)"></span>
									</td>
									<td class="bold">
										<span ng-bind="summary.tax_amount_formatted = negate(summary.tax_amount)"></span>
									</td>
									<td class="bold">
										<span ng-bind="summary.total_invoice_amount_formatted = negate(summary.total_invoice_amount)"></span>
									</td>
									<td class="bold">
										<span ng-bind="summary.local_sales_formatted = negate(summary.local_sales)"></span>
									</td>
									<td></td>
									<td class="bold">
										<span ng-bind="summary.term_cash_formatted = negate(summary.term_cash)"></span>
									</td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								
							</tbody>
						{!!Html::tfooter(true,18)!!}
					{!!Html::tclose()!!}				
				@endif
			</div>			
		</div>
	</div>
</div>
