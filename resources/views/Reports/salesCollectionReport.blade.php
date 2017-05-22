{!!Html::breadcrumb(['Sales & Collection','Reports'])!!}
{!!Html::pageheader('Sales & Collection Report')!!}

<div class="row">
	<div class="col-sm-12">
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
						{!!Html::datepicker('posting_date','Previous Invoice Date','true')!!}

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
					<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
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
						<td rowspan="[[record.rowspan]]" ng-if="record.show">
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
						<td rowspan="[[record.rowspan]]" ng-if="record.show">
							@if($navigationActions['show_invoice_no_column'] && $navigationActions['edit_invoice_no_column'])
								<a href="" class="editable-click" ng-click="editColumn('text',record.sales_order_table,'invoice_number',record.sales_order_header_id,record.invoice_number,$index,'Invoice Number','invoice_number')" ng-if="record.closed_period == 0">
		    						[[ record.invoice_number | uppercase ]]
		  						</a>
		  						<span ng-if="record.closed_period == 1">[[ record.invoice_number | uppercase ]]</span>
		  					@endif
		  					@if($navigationActions['show_invoice_no_column'] && !$navigationActions['edit_invoice_no_column'])
		  						[[ record.invoice_number | uppercase ]]
		  					@endif
						</td>
						<td rowspan="[[record.rowspan]]" ng-if="record.show">
							@if($navigationActions['show_invoice_date_column'] && $navigationActions['edit_invoice_date_column'])
								<a href="" class="editable-click" ng-click="editColumn('date',record.invoice_date_table,record.invoice_date_col,record.invoice_date_id,record.invoice_date,$index,'Invoice Date','invoice_date')" ng-if="record.closed_period == 0">
		    						<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
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
						<td rowspan="[[record.rowspan]]" ng-if="record.show">
							@if($navigationActions['show_cm_number_column'] && $navigationActions['edit_cm_number_column'])
								<a href="" class="editable-click" ng-click="editColumn('text','txn_sales_order_header_discount','ref_no',record.reference_num,record.ref_no,$index,'CM Number','ref_no')" ng-if="record.closed_period == 0">
		    						[[ record.ref_no | uppercase ]]
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
						<td rowspan="[[record.rowspan]]" ng-if="record.show">
							@if($navigationActions['show_return_slip_no_column'] && $navigationActions['edit_return_slip_no_column'])
								<a href="" class="editable-click" ng-click="editColumn('text','txn_return_header','return_slip_num',record.return_header_id,record.return_slip_num,$index,'Return Slip Number','return_slip_num')" ng-if="record.closed_period == 0">
		    						[[record.return_slip_num | uppercase]]
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
						<td>
							@if($navigationActions['show_collection_date_column'] && $navigationActions['edit_collection_date_column'])
								<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_header','or_date',record.collection_header_id,record.or_date,$index,'Collection Date','or_date')" ng-if="record.closed_period == 0">
		    						<span ng-bind="record.or_date_formatted = (formatDate(record.or_date) | date:'MM/dd/yyyy')"></span>
		  						</a>						
		  						<span ng-if="record.closed_period == 1" ng-bind="record.or_date_formatted = (formatDate(record.or_date) | date:'MM/dd/yyyy')"></span>
		  					@endif
		  					@if($navigationActions['show_collection_date_column'] && !$navigationActions['edit_collection_date_column'])
		  						<span ng-bind="record.or_date_formatted = (formatDate(record.or_date) | date:'MM/dd/yyyy')"></span>
		  					@endif
						</td>
						<td>
							@if($navigationActions['show_or_number_column'] && $navigationActions['edit_or_number_column'])
								<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_header','or_number',record.collection_header_id,record.or_number,$index,'OR Number','or_number')" ng-if="record.closed_period == 0">
		    						[[record.or_number | uppercase]]
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
						<td>
							@if($navigationActions['show_bank_name_column'] && $navigationActions['edit_bank_name_column'])
								<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','bank',record.collection_detail_id,record.bank,$index,'Bank Name','bank')" ng-if="record.closed_period == 0">
		    						[[record.bank | uppercase]]
		  						</a>
		  						<span ng-if="record.closed_period == 1">[[record.bank | uppercase]]</span>
		  					@endif
		  					@if($navigationActions['show_bank_name_column'] && !$navigationActions['edit_bank_name_column'])
		  						[[record.bank | uppercase]]
		  					@endif
						</td>
						<td>
							@if($navigationActions['show_check_no_column'] && $navigationActions['edit_check_no_column'])
								<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','check_number',record.collection_detail_id,record.check_number,$index,'Check No','check_number')" ng-if="record.closed_period == 0">
		    						[[record.check_number]]
		  						</a>
		  						<span ng-if="record.closed_period == 1">[[record.check_number]]</span>
	  						@endif
		  					@if($navigationActions['show_check_no_column'] && !$navigationActions['edit_check_no_column'])
		  						[[record.check_number]]
		  					@endif
						</td>
						<td>
							@if($navigationActions['show_check_date_column'] && $navigationActions['edit_check_date_column'])
								<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_detail','check_date',record.collection_detail_id,record.check_date,$index,'Check Date','check_date')" ng-if="record.closed_period == 0">
		    						<span ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
		  						</a>						
		  						<span ng-if="record.closed_period == 1"  ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
		  					@endif
		  					@if($navigationActions['show_check_date_column'] && $navigationActions['edit_check_date_column'])
		  						<span ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
		  					@endif	
						</td>
						<td>
							@if($navigationActions['show_cm_no_column'] && $navigationActions['edit_cm_no_column'])
								<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','cm_number',record.collection_detail_id,record.cm_number,$index,'CM No','cm_number')" ng-if="record.closed_period == 0">
		    						[[record.cm_number | uppercase]]
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
					</tr>
					</tbody>
					{!!Html::tfooter(true,28)!!}
				{!!Html::tclose(false)!!}
			@endif
		</div>		
		</div>		
	</div>
</div>
