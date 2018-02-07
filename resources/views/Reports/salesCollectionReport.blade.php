{!!Html::breadcrumb(['Sales & Collection','Reports'])!!}
{!!Html::pageheader('Sales & Collection Report')!!}

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
		<div class="panel-body">
			<div ng-if="!showMassEdit">
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
							{!!Html::datepicker('posting_date','Previous Invoice Date','true')!!}

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
							'show_mass_edit_button' => $navigationActions['show_mass_edit_button']
						])!!}
						<tbody>
						<tr ng-repeat="record in records|filter:query" id="records-[[$index]]" class="[[record.has_delete_remarks]]">
							@if($navigationActions['show_mass_edit_button'])
								<td>
									<input id="mass-edit-checkbox-[[$index]]" type="checkbox" style="margin: 0 auto; display: block;" ng-if="record.closed_period == 0" ng-model="record.selected_checkbox" ng-checked="record.selected_checkbox" ng-click="checkRecord($index,record.selected_checkbox)">
								</td>
							@endif
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_customer_code_column'])
									[[record.customer_code]]
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_customer_name_column'])
									[[record.customer_name]]
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_customer_name_column'])
									[[record.customer_address]]
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show" id="records-[[$index]]-remarks_updated" class="[[record.remarks_updated]]">
								@if($navigationActions['show_remarks_column'] && $navigationActions['edit_remarks_column'])
									<a href="" class="editable-click" ng-click="editColumn('text','txn_evaluated_objective','remarks',record.evaluated_objective_id,record.remarks,$index,'Remarks','','','','','remarks_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.remarks.trim() != '' || record.remarks != null">[[ record.remarks ]]</span>
			    						<span ng-if="record.remarks.trim() == '' || record.remarks == null">Edit Remarks</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1">[[ record.remarks ]]</span>
			  					@endif
			  					@if($navigationActions['show_remarks_column'] && !$navigationActions['edit_remarks_column'])
			  						[[ record.remarks ]]
			  					@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show" id="records-[[$index]]-invoice_number_updated" class="[[record.invoice_number_updated]]">
								@if($navigationActions['show_invoice_no_column'] && $navigationActions['edit_invoice_no_column'])
									<a href="" class="editable-click" ng-click="editColumn('text',record.sales_order_table,'invoice_number',record.sales_order_header_id,record.invoice_number,$index,'Invoice Number','invoice_number','','','','invoice_number_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.invoice_number.trim() != '' || record.invoice_number != null">[[ record.invoice_number | uppercase ]]</span>
			    						<span ng-if="record.invoice_number.trim() == '' || record.invoice_number == null">Edit Invoice Number</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1">[[ record.invoice_number | uppercase ]]</span>
			  					@endif
			  					@if($navigationActions['show_invoice_no_column'] && !$navigationActions['edit_invoice_no_column'])
			  						[[ record.invoice_number | uppercase ]]
			  					@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show" id="records-[[$index]]-invoice_date_updated" class="[[record.invoice_date_updated]]">
								@if($navigationActions['show_invoice_date_column'] && $navigationActions['edit_invoice_date_column'])
									<a href="" class="editable-click" ng-click="editColumn('date',record.invoice_date_table,record.invoice_date_col,record.invoice_date_id,record.invoice_date,$index,'Invoice Date','invoice_date','','','','invoice_date_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.invoice_date.trim() != '' || record.invoice_date != null" ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
			    						<span ng-if="record.invoice_date.trim() == '' || record.invoice_date == null">Edit Invoice Date</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1" ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
			  					@endif
			  					@if($navigationActions['show_invoice_date_column'] && !$navigationActions['edit_invoice_date_column'])
			  						<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
			  					@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_invoice_gross_amount_column'])
									<span ng-bind="record.so_total_served_formatted = negate(record.so_total_served)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_invoice_discount_amount_per_item_column'])
									<span ng-bind="record.so_total_item_discount_formatted = negate(record.so_total_item_discount)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_invoice_discount_amount_collective_column'])
									<span ng-bind="record.so_total_collective_discount_formatted = negate(record.so_total_collective_discount)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_invoice_net_amount_column'])
									<span ng-bind="record.total_invoice_amount_formatted = negate(record.total_invoice_amount)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show" id="records-[[$index]]-ref_no_updated" class="[[record.ref_no_updated]]">
								@if($navigationActions['show_cm_number_column'] && $navigationActions['edit_cm_number_column'])
									<a href="" class="editable-click" ng-click="editColumn('text','txn_sales_order_header_discount','ref_no',record.reference_num,record.ref_no,$index,'CM Number','ref_no','','','','ref_no_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.ref_no.trim() != '' || record.ref_no != null">[[ record.ref_no | uppercase ]]</span>
			    						<span ng-if="record.ref_no.trim() == '' || record.ref_no == null">Edit CM Number</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1">[[ record.ref_no | uppercase ]]</span>
			  					@endif
			  					@if($navigationActions['show_cm_number_column'] && !$navigationActions['edit_cm_number_column'])
			  						[[ record.ref_no | uppercase ]]
			  					@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_other_deduction_amount_column'])
									<span ng-bind="record.other_deduction_amount_formatted = negate(record.other_deduction_amount)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show" id="records-[[$index]]-return_slip_num_updated" class="[[record.return_slip_num_updated]]">
								@if($navigationActions['show_return_slip_no_column'] && $navigationActions['edit_return_slip_no_column'])
									<a href="" class="editable-click" ng-click="editColumn('text','txn_return_header','return_slip_num',record.return_header_id,record.return_slip_num,$index,'Return Slip Number','return_slip_num','','','','return_slip_num_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.return_slip_num.trim() != '' || record.return_slip_num != null">[[ record.return_slip_num | uppercase ]]</span>
			    						<span ng-if="record.return_slip_num.trim() == '' || record.return_slip_num == null">Edit Return Slip Number</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1">[[ record.return_slip_num | uppercase ]]</span>
		  						@endif
			  					@if($navigationActions['show_return_slip_no_column'] && !$navigationActions['edit_return_slip_no_column'])
			  						[[record.return_slip_num | uppercase]]
			  					@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_return_amount_column'])
									<span ng-bind="record.RTN_total_gross_formatted = negate(record.RTN_total_gross)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_return_discount_amount_column'])
									<span ng-bind="record.RTN_total_collective_discount_formatted = negate(record.RTN_total_collective_discount)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_return_net_amount_column'])
									<span ng-bind="record.RTN_net_amount_formatted = negate(record.RTN_net_amount)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_invoice_collectible_amount_column'])
									<span ng-bind="record.total_invoice_net_amount_formatted = negate(record.total_invoice_net_amount)"></span>
								@endif
							</td>
							<td id="records-[[$index]]-or_date_updated" class="[[record.or_date_updated]]">
								@if($navigationActions['show_collection_date_column'] && $navigationActions['edit_collection_date_column'])
									<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_header','or_date',record.collection_header_id,record.or_date,$index,'Collection Date','or_date','','','','or_date_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.or_date.trim() != '' || record.or_date != null" ng-bind="record.or_date_formatted = (formatDate(record.or_date) | date:'MM/dd/yyyy')"></span>
			    						<span ng-if="record.or_date.trim() == '' || record.or_date == null">Edit Collection Date</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1" ng-bind="record.or_date_formatted = (formatDate(record.or_date) | date:'MM/dd/yyyy')"></span>
			  					@endif
			  					@if($navigationActions['show_collection_date_column'] && !$navigationActions['edit_collection_date_column'])
			  						<span ng-bind="record.or_date_formatted = (formatDate(record.or_date) | date:'MM/dd/yyyy')"></span>
			  					@endif
							</td>
							<td id="records-[[$index]]-or_number_updated" class="[[record.or_number_updated]]">
								@if($navigationActions['show_or_number_column'] && $navigationActions['edit_or_number_column'])
									<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_header','or_number',record.collection_header_id,record.or_number,$index,'OR Number','or_number','','','','or_number_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.or_number.trim() != '' || record.or_number != null">[[record.or_number | uppercase]]</span>
			    						<span ng-if="record.or_number.trim() == '' || record.or_number == null">Edit OR Number</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1">[[record.or_number | uppercase]]</span>
			  					@endif
			  					@if($navigationActions['show_or_number_column'] && !$navigationActions['edit_or_number_column'])
			  						[[record.or_number | uppercase]]
			  					@endif
							</td>
							<td>
								@if($navigationActions['show_cash_column'])
									<span ng-bind="record.cash_amount_formatted = negate(record.cash_amount)"></span>
									<!-- <a href="" class="editable-click" ng-click="editColumn('number','txn_collection_detail','payment_amount',record.collection_detail_id,record.cash_amount,$index,'Cash','cash_amount','','','0.01')">
										<span ng-bind="formatNumber(record.cash_amount)"></span>
			  						</a> -->
		  						@endif
							</td>
							<td>
								@if($navigationActions['show_check_amount_column'])
									<span ng-bind="record.check_amount_formatted = negate(record.check_amount)"></span>
									<!-- <a href="" class="editable-click" ng-click="editColumn('number','txn_collection_detail','payment_amount',record.collection_detail_id,record.check_amount,$index,'Cash','check_amount','','','0.01')">
										<span ng-bind="formatNumber(record.check_amount)"></span>
									</a> -->
								@endif
							</td>
							<td id="records-[[$index]]-bank_updated" class="[[record.bank_updated]]">
								@if($navigationActions['show_bank_name_column'] && $navigationActions['edit_bank_name_column'])
									<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','bank',record.collection_detail_id,record.bank,$index,'Bank Name','bank','','','','bank_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.bank.trim() != '' || record.bank != null">[[record.bank | uppercase]]</span>
			    						<span ng-if="record.bank.trim() == '' || record.bank == null">Edit Bank Name</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1">[[record.bank | uppercase]]</span>
			  					@endif
			  					@if($navigationActions['show_bank_name_column'] && !$navigationActions['edit_bank_name_column'])
			  						[[record.bank | uppercase]]
			  					@endif
							</td>
							<td id="records-[[$index]]-check_number_updated" class="[[record.check_number_updated]]">
								@if($navigationActions['show_check_no_column'] && $navigationActions['edit_check_no_column'])
									<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','check_number',record.collection_detail_id,record.check_number,$index,'Check No','check_number','','','','check_number_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.check_number.trim() != '' || record.check_number != null">[[record.check_number]]</span>
			    						<span ng-if="record.check_number.trim() == '' || record.check_number == null">Edit Check No.</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1">[[record.check_number]]</span>
		  						@endif
			  					@if($navigationActions['show_check_no_column'] && !$navigationActions['edit_check_no_column'])
			  						[[record.check_number]]
			  					@endif
							</td>
							<td id="records-[[$index]]-check_date_updated" class="[[record.check_date_updated]]">
								@if($navigationActions['show_check_date_column'] && $navigationActions['edit_check_date_column'])
									<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_detail','check_date',record.collection_detail_id,record.check_date,$index,'Check Date','check_date','','','','check_date_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.check_date.trim() != '' || record.check_date != null" ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
			    						<span ng-if="record.check_date.trim() == '' || record.check_date == null">Edit Check Date</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1"  ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
			  					@endif
			  					@if($navigationActions['show_check_date_column'] && !$navigationActions['edit_check_date_column'])
			  						<span ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
			  					@endif
							</td>
							<td id="records-[[$index]]-cm_number_updated" class="[[record.cm_number_updated]]">
								@if($navigationActions['show_cm_no_column'] && $navigationActions['edit_cm_no_column'])
									<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','cm_number',record.collection_detail_id,record.cm_number,$index,'CM No','cm_number','','','','cm_number_updated','report',('records-' + $index))" ng-if="record.closed_period == 0">
			    						<span ng-if="record.cm_number.trim() != '' || record.cm_number != null">[[record.cm_number | uppercase]]</span>
			    						<span ng-if="record.cm_number.trim() == '' || record.cm_number == null">Edit CM No.</span>
			  						</a>
			  						<span ng-if="record.closed_period == 1">[[record.cm_number | uppercase]]</span>
			  					@endif
			  					@if($navigationActions['show_cm_no_column'] && $navigationActions['edit_cm_no_column'])
			  						[[record.cm_number | uppercase]]
			  					@endif
							</td>

							<td>
								@if($navigationActions['show_cm_date_column'])
									<span ng-bind="record.cm_date_formatted = (formatDate(record.cm_date) | date:'MM/dd/yyyy')"></span>
								@endif
							</td>
							<td>
								@if($navigationActions['show_cm_amount_column'])
									<span ng-bind="record.credit_amount_formatted = negate(record.credit_amount)"></span>
								@endif
							</td>
							<td rowspan="[[record.rowspan]]" ng-if="record.show">
								@if($navigationActions['show_total_collected_amount_column'])
									<span ng-bind="record.total_collected_amount_formatted = formatNumber(record.total_collected_amount)"></span>
								@endif
							</td>
							<td id="records-[[$index]]-delete_remarks_updated" class="[[record.delete_remarks_updated]]">
								@if($navigationActions['show_delete_remarks_column'] && $navigationActions['edit_delete_remarks_column'])
									<a href="" class="editable-click" ng-click="editColumn('text',record.delete_remarks_table,'delete_remarks',record.sales_order_header_id,record.delete_remarks,$index,'Remarks','','','','','delete_remarks_updated','report',('records-' + $index))">
			    						<span ng-if="record.delete_remarks.trim() != '' || record.delete_remarks != null">[[ record.delete_remarks ]]</span>
			    						<span ng-if="record.delete_remarks.trim() == '' || record.delete_remarks == null">Edit Delete Remarks</span>
			  						</a>
			  					@endif
			  					@if($navigationActions['show_delete_remarks_column'] && !$navigationActions['edit_delete_remarks_column'])
			  						[[ record.delete_remarks ]]
			  					@endif
							</td>
						</tr>

						<!-- Summary -->
						<tr id="total_summary">
							<td class="bold">Total</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="bold">
								<span ng-bind="summary.so_total_served = negate(summary.so_total_served)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.so_total_item_discount = negate(summary.so_total_item_discount)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.so_total_collective_discount = negate(summary.so_total_collective_discount)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.total_invoice_amount = negate(summary.total_invoice_amount)"></span>
							</td>
							<td></td>
							<td class="bold">
								<span ng-bind="summary.other_deduction_amount = negate(summary.other_deduction_amount)"></span>
							</td>
							<td></td>
							<td class="bold">
								<span ng-bind="summary.RTN_total_gross = negate(summary.RTN_total_gross)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.RTN_total_collective_discount = negate(summary.RTN_total_collective_discount)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.RTN_net_amount = negate(summary.RTN_net_amount)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.total_invoice_net_amount = negate(summary.total_invoice_net_amount)"></span>
							</td>
							<td></td>
							<td></td>
							<td class="bold">
								<span ng-bind="summary.cash_amount = negate(summary.cash_amount)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.check_amount = negate(summary.check_amount)"></span>
							</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="bold">
								<span ng-bind="summary.credit_amount = negate(summary.credit_amount)"></span>
							</td>
							<td class="bold">
								<span ng-bind="summary.total_collected_amount = negate(summary.total_collected_amount)"></span>
							</td>
							<td></td>
							<td></td>
						</tr>
						</tbody>
						{!!Html::tfooter(true,count($tableHeaders)+1)!!}
					{!!Html::tclose(false)!!}
				@endif
			</div>
		</div>
		</div>
	</div>
</div>
