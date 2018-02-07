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
						'show_download'         => $navigationActions['show_download'],
						'show_print'            => $navigationActions['show_print'],
						'show_search'           => $navigationActions['show_search_field'],
						'show_mass_edit_button' => $navigationActions['show_mass_edit_button']
					])!!}
						{!!Html::theader($tableHeaders,[
							'can_sort' 				=> $navigationActions['can_sort_columns'],
							'show_mass_edit_button' => $navigationActions['show_mass_edit_button']
						])!!}
							<tbody>
							<tr ng-repeat="record in records|filter:query" id="records-[[$index]]" ng-class="[record.has_delete_remarks]">
								@if($navigationActions['show_mass_edit_button'])
									<td>
										<input id="mass-edit-checkbox-[[$index]]" type="checkbox" style="margin: 0 auto; display: block;" ng-if="record.closed_period == 0" ng-model="record.selected_checkbox" ng-checked="record.selected_checkbox" ng-click="checkRecord($index,record.selected_checkbox)">
									</td>
								@endif
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
								<td id="records-[[$index]]-remarks_updated" ng-class="[record.remarks_updated]">
									@if($navigationActions['show_remarks_column'] && $navigationActions['edit_remarks_column'])
										<a href="" class="editable-click" ng-click="editColumn('text','txn_evaluated_objective','remarks',record.evaluated_objective_id,record.remarks,$index,'Remarks','','','','','remarks_updated','per-material',('records-' + $index))" ng-if="record.closed_period == 0">
				    						<span ng-if="record.remarks.trim() != '' || record.remarks != null">[[ record.remarks ]]</span>
		    								<span ng-if="record.remarks.trim() == '' || record.remarks == null">Edit Remarks</span>
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
								<td id="records-[[$index]]-invoice_number_updated" ng-class="[record.invoice_number_updated]">
									@if($navigationActions['show_invoice_no_or_return_slip_no_column'] && $navigationActions['edit_invoice_no_or_return_slip_no_column'])
										<a href="" class="editable-click" ng-click="editColumn('text',record.invoice_table,record.invoice_number_column,record.invoice_pk_id,record.invoice_number,$index,'Invoice No/Return Slip No','invoice_number','','','','invoice_number_updated','per-material',('records-' + $index))" ng-if="record.closed_period == 0">
			    							<span ng-if="record.invoice_number.trim() != '' || record.invoice_number != null">[[ record.invoice_number | uppercase ]]</span>
		    								<span ng-if="record.invoice_number.trim() == '' || record.invoice_number == null">Edit Invoice Number</span>
			  							</a>
				  						<span ng-if="record.closed_period == 1">[[ record.invoice_number | uppercase]]</span>
			  						@endif
			  						@if($navigationActions['show_invoice_no_or_return_slip_no_column'] && !$navigationActions['edit_invoice_no_or_return_slip_no_column'])
			  							[[ record.invoice_number | uppercase]]
			  						@endif
								</td>
								<td id="records-[[$index]]-invoice_date_updated" ng-class="[record.invoice_date_updated]">
									@if($navigationActions['show_invoice_date_or_return_date_column'] && $navigationActions['edit_invoice_date_or_return_date_column'])
										<a href="" class="editable-click" ng-click="editColumn('date',record.invoice_table,record.invoice_date_column,record.invoice_pk_id,record.invoice_date,$index,'Invoice Date/Return Date','invoice_date','','','','invoice_date_updated','per-material',('records-' + $index))" ng-if="record.closed_period == 0">
			    							<span ng-if="record.invoice_date.trim() != '' || record.invoice_date != null" ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
		    								<span ng-if="record.invoice_date.trim() == '' || record.invoice_date == null">Edit Invoice Date/Return Date</span>
			  							</a>
				  						<span ng-if="record.closed_period == 1" ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
			  						@endif
			  						@if($navigationActions['show_invoice_date_or_return_date_column'] && !$navigationActions['edit_invoice_date_or_return_date_column'])
			  							<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
			  						@endif
								</td>
								<td id="records-[[$index]]-invoice_posting_date_updated" ng-class="[record.invoice_posting_date_updated]">
									@if($navigationActions['show_invoice_or_return_posting_date_column'] && $navigationActions['edit_invoice_or_return_posting_date_column'])
										<a href="" class="editable-click" ng-click="editColumn('date',record.invoice_table,record.invoice_posting_date_column,record.invoice_pk_id,record.invoice_posting_date,$index,'Invoice/Return Posting Date','invoice_posting_date','','','','invoice_posting_date_updated','per-material',('records-' + $index))" ng-if="record.closed_period == 0">
			    							<span ng-if="record.invoice_posting_date.trim() != '' || record.invoice_posting_date != null" ng-bind="record.invoice_posting_date_formatted = (formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy')"></span>
		    								<span ng-if="record.invoice_posting_date.trim() == '' || record.invoice_posting_date == null">Edit Invoice/Return Posting Date</span>
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
								<td id="records-[[$index]]-quantity_updated" ng-class="[record.quantity_updated]">
									@if($navigationActions['show_quantity_column'] && $navigationActions['edit_quantity_column'])
										<a href="" class="editable-click" ng-click="editColumn('number',record.quantity_table,record.quantity_column,record.quantity_pk_id,record.quantity,$index,'Quantity','quantity',true,'','','quantity_updated','per-material',('records-' + $index))" ng-if="record.closed_period == 0">
			    							<span ng-if="record.quantity.trim() != '' || record.quantity > 0 || record.quantity != null">[[ record.quantity ]]</span>
		    								<span ng-if="record.quantity.trim() == '' || record.quantity == 0 || record.quantity == null">Edit Quantity</span>
			  							</a>
			  							<span ng-if="record.closed_period == 1">[[record.quantity]]</span>
			  						@endif
			  						@if($navigationActions['show_quantity_column'] && !$navigationActions['edit_quantity_column'])
			  							[[record.quantity]]
			  						@endif
								</td>
								<td id="records-[[$index]]-condition_code_updated" ng-class="[record.condition_code_updated]">
									@if($navigationActions['show_condition_code_column'] && $navigationActions['edit_condition_code_column'])
										<a href="" class="editable-click" ng-click="editColumn('select',record.condition_code_table,record.condition_code_column,record.condition_code_pk_id,record.condition_code,$index,'Condition Code','condition_code','','','','condition_code_updated','per-material',('records-' + $index))" ng-if="record.closed_period == 0">
			    							<span ng-if="record.condition_code.trim() != '' || record.condition_code != null">[[record.condition_code]]</span>
		    								<span ng-if="record.condition_code.trim() == '' || record.condition_code == null">Edit Condition Code</span>
			  							</a>
			  							<span ng-if="record.closed_period == 1">[[record.condition_code]]</span>
			  						@endif
			  						@if($navigationActions['show_condition_code_column'] && !$navigationActions['edit_condition_code_column'])
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
								<td id="records-[[$index]]-delete_remarks_updated" class="[[record.delete_remarks_updated]]">
									@if($navigationActions['show_delete_remarks_column'] && $navigationActions['edit_delete_remarks_column'])
										<a href="" class="editable-click" ng-click="editColumn('text',record.invoice_table,'delete_remarks',record.invoice_pk_id,record.delete_remarks,$index,'Remarks','','','','','delete_remarks_updated','per-material',('records-' + $index))">
				    						<span ng-if="record.delete_remarks.trim() != '' || record.delete_remarks != null">[[ record.delete_remarks ]]</span>
				    						<span ng-if="record.delete_remarks.trim() == '' || record.delete_remarks == null">Edit Delete Remarks</span>
				  						</a>
				  					@endif
				  					@if($navigationActions['show_delete_remarks_column'] && !$navigationActions['edit_delete_remarks_column'])
				  						[[ record.delete_remarks ]]
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
