{!!Html::breadcrumb(['Sales Report','Per Material'])!!}
{!!Html::pageheader('Per Material')!!}


<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->			
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">						
							@if($isSalesman)
								{!!Html::select('salesman_code','Salesman', $salesman,'')!!}
							@else
								{!!Html::select('salesman_code','Salesman', $salesman)!!}
							@endif
							{!!Html::select('area','Area', $areas)!!}						
							{!!Html::select('customer','Customer Name', $customers)!!}	
							{!!Html::select('segment','Segment', $segments)!!}													 			
							{!!Html::select('material','Material', $items)!!}
						</div>					
						<div class="col-md-6">	
							{!!Html::datepicker('return_date','Invoice Date/ Return Date',true)!!}						
							{!!Html::datepicker('posting_date','Posting Date',true)!!}
							{!!Html::select('company_code','Company Code', $companyCode)!!}
							{!!Html::input('text','invoice_number','Invoice #')!!}												
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
							<tr ng-repeat="record in records|filter:query" id="[[$index]]" class=[[record.updated]]>
								<td>
									@if($navigationActions['show_so_no_column'])
										[[record.so_number]]
									@endif
								</td>						
								<td>
									@if($navigationActions['show_reference_number_column'])
										[[record.reference_num]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_activity_code_column'])
										[[record.activity_code]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_customer_code_column'])
										[[record.customer_code]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_customer_name_column'])
										[[record.customer_name]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_customer_address_column'])
										[[record.customer_address]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_remarks_column'] && $navigationActions['edit_remarks_column'])
										<a href="" class="editable-click" ng-click="editColumn('text','txn_evaluated_objective','remarks',record.evaluated_objective_id,record.remarks,$index,'Remarks')" ng-if="record.closed_period == 0">
				    						[[ record.remarks ]]
				  						</a>
				  						<span ng-if="record.closed_period == 1">[[ record.remarks ]]</span>
				  					@endif
				  					@if($navigationActions['show_remarks_column'] && !$navigationActions['edit_remarks_column'])
				  						[[ record.remarks ]]
				  					@endif
								</td>
								<td>
									@if($navigationActions['show_van_code_column'])
										[[record.van_code]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_device_code_column'])
										[[record.device_code]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_salesman_code_column'])
										[[record.salesman_code]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_salesman_area_column'])
										[[record.salesman_name]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_area_column'])
										[[record.area]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_invoice_no_or_return_slip_no_column'] && $navigationActions['edit_invoice_no_or_return_slip_no_column'])
										<a href="" class="editable-click" ng-click="editColumn('text',record.invoice_table,record.invoice_number_column,record.invoice_pk_id,record.invoice_number,$index,'Invoice No/Return Slip No','invoice_number')" ng-if="record.closed_period == 0">
			    							[[ record.invoice_number | uppercase]]
			  							</a>
				  						<span ng-if="record.closed_period == 1">[[ record.invoice_number | uppercase]]</span>
			  						@endif
			  						@if($navigationActions['show_invoice_no_or_return_slip_no_column'] && !$navigationActions['edit_invoice_no_or_return_slip_no_column'])
			  							[[ record.invoice_number | uppercase]]
			  						@endif
								</td>
								<td>
									@if($navigationActions['show_invoice_date_or_return_date_column'] && $navigationActions['edit_invoice_date_or_return_date_column'])
										<a href="" class="editable-click" ng-click="editColumn('date',record.invoice_table,record.invoice_date_column,record.invoice_pk_id,record.invoice_date,$index,'Invoice Date/Return Date','invoice_date')" ng-if="record.closed_period == 0">
			    							<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
			  							</a>
				  						<span ng-if="record.closed_period == 1" ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
			  						@endif
			  						@if($navigationActions['show_invoice_date_or_return_date_column'] && !$navigationActions['edit_invoice_date_or_return_date_column'])
			  							<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
			  						@endif
								</td>
								<td>
									@if($navigationActions['show_invoice_or_return_posting_date_column'] && $navigationActions['edit_invoice_or_return_posting_date_column'])
										<a href="" class="editable-click" ng-click="editColumn('date',record.invoice_table,record.invoice_posting_date_column,record.invoice_pk_id,record.invoice_posting_date,$index,'Invoice/Return Posting Date','invoice_posting_date')" ng-if="record.closed_period == 0">
			    							<span ng-bind="record.invoice_posting_date_formatted = (formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy')"></span>
			  							</a>
			  							<span ng-if="record.closed_period == 1" ng-bind="record.invoice_posting_date_formatted = (formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy')"></span>
			  						@endif
			  						@if($navigationActions['show_invoice_or_return_posting_date_column'] && !$navigationActions['edit_invoice_or_return_posting_date_column'])
			  							<span ng-bind="record.invoice_posting_date_formatted = (formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy')"></span>
			  						@endif
								</td>
								<td>
									@if($navigationActions['show_segment_code_column'])
										[[record.segment_code]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_item_code_column'])
										[[record.item_code]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_material_description_column'])
										[[record.description]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_quantity_column'] && $navigationActions['edit_quantity_column'])
										<a href="" class="editable-click" ng-click="editColumn('number',record.quantity_table,record.quantity_column,record.quantity_pk_id,record.quantity,$index,'Quantity','quantity',true)" ng-if="record.closed_period == 0">
			    							[[record.quantity]]
			  							</a>
			  							<span ng-if="record.closed_period == 1">[[record.quantity]]</span>
			  						@endif
			  						@if($navigationActions['show_quantity_column'] && !$navigationActions['edit_quantity_column'])
			  							[[record.quantity]]
			  						@endif
								</td>
								<td>
									@if($navigationActions['show_condition_code_column'] && $navigationActions['edit_condition_code_column'])
										<a href="" class="editable-click" ng-click="editColumn('select',record.condition_code_table,record.condition_code_column,record.condition_code_pk_id,record.condition_code,$index,'Condition Code','condition_code')" ng-if="record.closed_period == 0">
			    							[[record.condition_code]]
			  							</a>
			  							<span ng-if="record.closed_period == 1">[[record.condition_code]]</span>
			  						@endif
			  						@if($navigationActions['show_condition_code_column'] && $navigationActions['edit_condition_code_column'])
			  							[[record.condition_code]]
			  						@endif
								</td>
								<td>
									@if($navigationActions['show_uom_code_column'])
										[[record.uom_code]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_taxable_amount_column'])
										<span ng-bind="record.gross_served_amount_formatted = negate(record.gross_served_amount)"></span>
									@endif
								</td>
								<td>
									@if($navigationActions['show_vat_amount_column'])
										<span ng-bind="record.vat_amount_formatted = negate(record.vat_amount)"></span>
									@endif
								</td>
								<td>
									@if($navigationActions['show_discount_rate_per_item_column'])
										[[record.discount_rate]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_discount_amount_per_item_column'])
										<span ng-bind="record.discount_amount_formatted = negate(record.discount_amount)"></span>
									@endif
								</td>						
								<td>
									@if($navigationActions['show_collective_discount_rate_column'])
										[[record.collective_discount_rate]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_collective_discount_amount_column'])
										<span ng-bind="record.collective_discount_amount_formatted = negate(record.collective_discount_amount)"></span>
									@endif
								</td>
								<td>
									@if($navigationActions['show_reference_no_column'])
										[[record.discount_reference_num]]
									@endif
								</td>
								<td>
									@if($navigationActions['show_remarks_column'])
										[[record.discount_remarks]]
									@endif
								</td>						
								<td>
									@if($navigationActions['show_total_sales_column'])
										<span ng-bind="record.total_invoice_formatted = negate(record.total_invoice)"></span>
									@endif
								</td>
							</tr>
							
							<!-- Total Summary -->
							<tr id="total_summary">
								<th>Total</th>						
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<th>
									<span ng-bind="summary.quantity"></span>
								</th>
								<td></td>
								<td></td>
								<th>
									<span ng-bind="summary.gross_served_amount_formatted = negate(summary.gross_served_amount)"></span>
								</th>
								<th>
									<span ng-bind="summary.vat_amount_formatted = negate(summary.vat_amount)"></span>
								</th>
								<td></td>
								<th>
									<span ng-bind="summary.discount_amount_formatted = negate(summary.discount_amount)"></span>
								</th>
								<td></td>						
								<th>
									<span ng-bind="summary.collective_discount_amount_formatted = negate(summary.collective_discount_amount)"></span>
								</th>
								<td></td>
								<td></td>						
								<th>
									<span ng-bind="summary.total_invoice_formatted = negate(summary.total_invoice)"></span>
								</th>
							</tr>
							
							</tbody>
						{!!Html::tfooter(true,32)!!}					
					{!!Html::tclose()!!}
				@endif
			</div>			
		</div>
	</div>
</div>
