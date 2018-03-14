{!!Html::breadcrumb(['Van Inventory',$title])!!}
{!!Html::pageheader($title)!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">
							{!!Html::select('salesman_code','Salesman', $salesman,'')!!}
							{!!Html::select('audited_by','Audited By:', $auditor, '')!!}
							{!!Html::input('text','invoice_number','Invoice #')!!}
							{!!Html::input('text','stock_transfer_number','Stock Transfer #')!!}
						</div>
						<div class="col-md-6">
							{!!Html::datepicker('transaction_date','Transaction Date <span class="required">*</span>','true')!!}
							{!!Html::input('text','return_slip_num','Return Slip #')!!}
							{!!Html::input('text','reference_number','Replenishment #')!!}
						</div>
					{!!Html::fclose()!!}
					<!-- End Filter -->
				@endif

				@if($navigationActions['show_table'])
					{!!Html::topen([
						'show_download' => $navigationActions['show_download'],
						'show_print'    => $navigationActions['show_print'],
						'show_search'   => $navigationActions['show_search_field'],
						'no_loading'    => true
					])!!}
						{!!Html::theader($tableHeaders)!!}
						<tbody>
						<tbody ng-repeat="item in items">


							<!-- Beginning balance -->
							<tr ng-show="item.first_upload">
								<td class="bold">Beginning Balance</td>
								<td class="bold">
									<span ng-bind="item.replenishment.replenishment_date_formatted = (formatDate(item.replenishment.replenishment_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold">[[item.replenishment.reference_number | uppercase]]</td>
								@foreach($itemCodes as $item)
									<td class="bold" ng-if="checkIfHeaderDisplayed('{{'code_'.$item->item_code}}')">[[item.replenishment.{{'code_'.$item->item_code}}]]</td>
								@endforeach
							</tr>

							<!-- Stock count -->
							<tr ng-repeat="stock in item.stocks|filter:query" ng-show="item.show_stocks" id="stocks-[[$parent.$index]]_[[$index]]">
								<td class="bold"></td>
								<td class="bold" id="stocks-[[$parent.$index + '-' + $index]]-transaction_date_updated" ng-class="[stock.transaction_date_updated]">
									@if($navigationActions['show_transaction_date_column'] && $navigationActions['edit_transaction_date_column'])
										<a href="" class="editable-click" ng-click="editColumn('date','txn_stock_transfer_in_header','transfer_date',stock.stock_transfer_in_header_id,stock.transaction_date,$index,'Transaction Date','transaction_date',false,$parent.$index,'','transaction_date_updated','{{ $slug }}',('stocks-' + $parent.$index + '-' + $index))" ng-if="stock.closed_period == 0">
		    								<span ng-if="stock.transaction_date.trim() != '' || stock.transaction_date != null" ng-bind="stock.transaction_date_formatted = (formatDate(stock.transaction_date) | date:'MM/dd/yyyy')"></span>
	    									<span ng-if="stock.transaction_date.trim() == '' || stock.transaction_date == null">Edit Transaction Date</span>
		  								</a>
		  								<span ng-if="stock.closed_period == 1" ng-bind="stock.transaction_date_formatted = (formatDate(stock.transaction_date) | date:'MM/dd/yyyy')"></span>
		  							@endif
		  							@if($navigationActions['show_transaction_date_column'] && !$navigationActions['edit_transaction_date_column'])
		  								<span ng-bind="stock.transaction_date_formatted = (formatDate(stock.transaction_date) | date:'MM/dd/yyyy')"></span>
		  							@endif
								</td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td id="stocks-[[$parent.$index + '-' + $index]]-stock_transfer_number_updated" class=[[stock.stock_transfer_number_updated]]>
									@if($navigationActions['show_stock_transfer_number_column'] && $navigationActions['edit_stock_transfer_number_column'])
										<a href="" class="editable-click" ng-click="editColumn('text','txn_stock_transfer_in_header','stock_transfer_number',stock.stock_transfer_in_header_id,stock.stock_transfer_number,$index,'Stock Transfer No.','stock_transfer_number',false,$parent.$index,'','stock_transfer_number_updated','{{ $slug }}',('stocks-' + $parent.$index + '-' + $index))" ng-if="stock.closed_period == 0">
		    								<span ng-if="stock.stock_transfer_number.trim() != '' || stock.stock_transfer_number != null">[[stock.stock_transfer_number | uppercase]]</span>
	    									<span ng-if="stock.stock_transfer_number.trim() == '' || stock.stock_transfer_number == null">Edit Stock Transfer No.</span>
		  								</a>
		  								<span ng-if="stock.closed_period == 1">[[stock.stock_transfer_number | uppercase]]</span>
	  								@endif
		  							@if($navigationActions['show_stock_transfer_number_column'] && !$navigationActions['edit_stock_transfer_number_column'])
		  								[[stock.stock_transfer_number | uppercase]]
		  							@endif
								</td>
								<td class="bold"></td>


								@foreach($itemCodes as $item)
									<td class="bold" ng-if="checkIfHeaderDisplayed('{{'code_'.$item->item_code}}')">[[stock.{{'code_'.$item->item_code}}]]</td>
								@endforeach
								<td></td>
							</tr>

							<!-- Record list -->
							<tr ng-repeat="record in item.records|filter:query" id="records-[[$parent.$index + '-' + $index]]" ng-show="item.total" ng-class="[record.updated]">
								<td>[[record.customer_name]]</td>
								<td>
									<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td>[[record.invoice_number | uppercase]]</td>
								<td>[[record.return_slip_num | uppercase]]</td>
								<td></td>
								<td></td>
								@foreach($itemCodes as $item)
									<td ng-if="checkIfHeaderDisplayed('{{'code_'.$item->item_code}}')"> [[record.{{'code_'.$item->item_code}}]]</td>
								@endforeach
								<td id="records-[[$parent.$index + '-' + $index]]-delete_remarks_updated">
									@if($navigationActions['show_delete_remarks_column'] && $navigationActions['edit_delete_remarks_column'])
										<a href="" class="editable-click" ng-click="editColumn('text',record.delete_remarks_table,'delete_remarks',record.delete_remarks_id,record.delete_remarks,$index,'Remarks','delete_remarks',false,$parent.$index,'','delete_remarks_updated','report',('records-' + $parent.$index + '-' + $index))">
				    						<span ng-if="record.delete_remarks.trim() != '' || record.delete_remarks != null">[[ record.delete_remarks ]]</span>
				    						<span ng-if="record.delete_remarks.trim() == '' || record.delete_remarks == null">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
				  						</a>
				  					@endif
				  					@if($navigationActions['show_delete_remarks_column'] && !$navigationActions['edit_delete_remarks_column'])
				  						[[ record.delete_remarks ]]
				  					@endif
				  				</td>
							</tr>

							<!-- Adjustment -->
							<tr style="background-color:#edc4c4;" ng-show="item.showAdjustment">
								<td class="bold">Adjustment</td>
								<td class="bold">
									<span ng-bind="item.adjustment.replenishment_date_formatted = (formatDate(item.adjustment.replenishment_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold">[[item.adjustment.reference_number | uppercase]]</td>
								@foreach($itemCodes as $item)
									<td class="bold" ng-if="checkIfHeaderDisplayed('{{'code_'.$item->item_code}}')">[[item.adjustment.{{'code_'.$item->item_code}}]]</td>
								@endforeach
								<td></td>
							</tr>

							<!-- Stock on Hand -->
							<tr style="background-color: #ccffcc" ng-show="item.showBody">
								<td class="bold">Stock On Hand</td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								@foreach($itemCodes as $item)
									<td class="bold" ng-if="checkIfHeaderDisplayed('{{'code_'.$item->item_code}}')">[[item.stock_on_hand.{{'code_'.$item->item_code}}]]</td>
								@endforeach
								<td></td>
							</tr>

							<!-- Actual Count -->
							<tr style="background-color:#ccccff;" ng-show="item.showReplenishment">
								<td class="bold">Actual Count</td>
								<td class="bold">
									<span ng-bind="item.replenishment.replenishment_date_formatted = (formatDate(item.replenishment.replenishment_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold">[[item.replenishment.reference_number | uppercase]]</td>
								@foreach($itemCodes as $item)
									<td class="bold" ng-if="checkIfHeaderDisplayed('{{'code_'.$item->item_code}}')">[[item.replenishment.{{'code_'.$item->item_code}}]]</td>
								@endforeach
								<td></td>
							</tr>

							<!-- Short over stocks -->
							<tr style="background-color:#edc4c4;" ng-show="item.showReplenishment">
								<td class="bold">Short/Over Stocks</td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								@foreach($itemCodes as $item)
									<td class="bold" ng-if="checkIfHeaderDisplayed('{{'code_'.$item->item_code}}')">[[item.short_over_stocks.{{'code_'.$item->item_code}}]]</td>
								@endforeach
								<td></td>
							</tr>

							<!-- Beginning balance -->
							<tr ng-show="item.showReplenishment">
								<td class="bold">Beginning Balance</td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								<td class="bold"></td>
								@foreach($itemCodes as $item)
									<td class="bold" ng-if="checkIfHeaderDisplayed('{{'code_'.$item->item_code}}')">[[item.replenishment.{{'code_'.$item->item_code}}]]</td>
								@endforeach
								<td></td>
							</tr>

						</tbody>
						<tr id="no_records_div" style="background-color:white;">
							<td colspan="{{ ($navigationActions['show_mass_edit_button'] ? 9 : 8) + count($itemCodes)}}">
									No records found.
							</td>
						</tr>

						</tbody>
					{!!Html::tclose(false)!!}
					<input type="hidden" id="inventory_type" value="{{$type}}">
				@endif
			</div>
		</div>
	</div>
</div>
