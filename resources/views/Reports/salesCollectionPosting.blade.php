{!!Html::breadcrumb(['Sales & Collection','Posting'])!!}
{!!Html::pageheader('Sales & Collection Posting')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">
							{!!Html::select('salesman','Salesman', $salesman,'')!!}
							{!!Html::select('company_code','Company Code', $companyCode,'')!!}
							{!!Html::input('text','customer_name','Customer Name')!!}
							{!!Html::input('text','invoice_number','Invoice #')!!}
							{!!Html::input('text','or_number','OR #')!!}
						</div>
						<div class="col-md-6">
							{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
							{!!Html::datepicker('collection_date','Collection Date','true')!!}
							{!!Html::datepicker('posting_date','Posting Date','true')!!}
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
					{!!Html::theader($tableHeaders)!!}
						<tbody>
							<tr ng-repeat="record in records|filter:query" id="records-records-[[$index]]" ng-class="[record.updated]">
								<td>[[record.activity_code]]</td>
								<td>[[record.salesman_name]]</td>
								<td>[[record.customer_code]]</td>
								<td>[[record.customer_name]]</td>
								<td>[[record.remarks]]</td>
								<td>[[record.invoice_number | uppercase]]</td>
								<td>
									<span ng-bind="record.total_invoice_net_amount_formatted = negate(record.total_invoice_net_amount)"></span>
								</td>
								<td>
									<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td>
									<span ng-bind="record.invoice_posting_date_formatted = (formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td>[[record.or_number | uppercase]]</td>
								<td>
									<span ng-bind="record.or_amount_formatted = negate(record.or_amount)"></span>
								</td>
								<td>
									<span ng-bind="record.or_date_formatted = (formatDate(record.or_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td>
									<span ng-bind="record.collection_posting_date_formatted = (formatDate(record.collection_posting_date) | date:'MM/dd/yyyy')"></span>
								</td>	
								<td id="records-[[$index]]-delete_remarks_updated">
									@if($navigationActions['show_delete_remarks_column'] && !$navigationActions['edit_delete_remarks_column'])
				  						[[ record.delete_remarks ]]
				  					@endif
								</td>
															
							</tr>
						</tbody>
						{!!Html::tfooter(true,count($tableHeaders)+1)!!}
					{!!Html::tclose(false)!!}
				@endif
			</div>
		</div>
	</div>
</div>
