{!!Html::breadcrumb(['Unpaid Invoice'])!!}
{!!Html::pageheader('Unpaid Invoice')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">
							@if($isSalesman)
								{!!Html::select('salesman','Salesman', $salesman,'')!!}
							@else
								{!!Html::select('salesman','Salesman', $salesman)!!}
							@endif
							{!!Html::select('company_code','Company Code', $companyCode)!!}
							{!!Html::select('customer','Customer', $customers)!!}
						</div>
						<div class="col-md-6">
							{!!Html::datepicker('invoice_date','Invoice Date','true',false,$from,$to)!!}
							{!!Html::input('text','invoice_number','Invoice #')!!}
						</div>
					{!!Html::fclose()!!}
					<!-- End Filter -->
				@endif

				@if($navigationActions['show_table'])
					{!!Html::topen([
						'show_download'   => $navigationActions['show_download'],
						'show_print'      => $navigationActions['show_print'],
						'show_search'     => $navigationActions['show_search_field'],
					])!!}
					{!!Html::theader($tableHeaders,[
						'can_sort' => $navigationActions['can_sort_columns']
					])!!}
						<tbody>
							<tr ng-repeat="record in records|filter:query" id="records-[[$index]]" ng-class="[record.updated,record.has_delete_remarks]">
								<td>[[record.salesman_name]]</td>
								<td>[[record.area_name]]</td>
								<td>[[record.customer_code]]</td>
								<td>[[record.customer_name]]</td>
								<td>[[record.customer_address]]</td>
								<td>[[record.remarks]]</td>
								<td>[[record.invoice_number | uppercase]]</td>
								<td>
									<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td>
									<span ng-bind="record.original_amount_formatted = negate(record.original_amount)"></span>
								</td>
								<td>
									<span ng-bind="record.balance_amount_formatted = negate(record.balance_amount)"></span>
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
								<td></td>
								<th>
									<span ng-bind="summary.original_amount_formatted = negate(summary.original_amount)"></span>
								</th>
								<th>
									<span ng-bind="summary.balance_amount_formatted = negate(summary.balance_amount)"></span>
								</th>
								<td></td>
							</tr>
						</tbody>

						{!!Html::tfooter(true,count($tableHeaders)+1)!!}
					{!!Html::tclose()!!}
				@endif
			</div>
		</div>
	</div>
</div>
