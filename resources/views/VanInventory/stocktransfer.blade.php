{!!Html::breadcrumb(['Van Inventory','Stock Transfer'])!!}
{!!Html::pageheader('Stock Transfer')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">
							{!!Html::select('salesman_code','Salesman', $salesman,$isSalesman ? '' : 'All')!!}						
							{!!Html::select('company_code','Company Code', $companyCode)!!}
							{!!Html::select('area','Area', $areas)!!}												
							{!!Html::select('segment','Segment', $segments)!!}													 																															
						</div>					
						<div class="col-md-6">	
							{!!Html::select('item_code','Material', $items)!!}
							{!!Html::datepicker('transfer_date','Stock Transfer Date',true)!!}
							{!!Html::input('text','stock_transfer_number','Stock Transfer #')!!}						
						</div>			
					{!!Html::fclose()!!}
					<!-- End Filter -->
				@endif

				@if($navigationActions['show_table'])
					{!!Html::topen([
						'show_download'   => $navigationActions['show_download'],
						'show_print'      => $navigationActions['show_print'],
						'show_search'     => $navigationActions['show_search_field'],
						'show_add_button' => $navigationActions['show_add_button'],
						'add_link'        => 'stocktransfer.add'
					])!!}
						{!!Html::theader($tableHeaders,$navigationActions['can_sort_columns'])!!}
						<tbody>
							<tr ng-repeat="record in records|filter:query" id=[[$index]]>
								<td id="[[$index]]-stock_transfer_number_updated" ng-class="[record.stock_transfer_number_updated]">
									@if($navigationActions['show_stock_transfer_number_column'] && $navigationActions['edit_stock_transfer_number_column'])
										<a href="" class="editable-click" ng-click="editColumn('text','txn_stock_transfer_in_header','stock_transfer_number',record.stock_transfer_in_header_id,record.stock_transfer_number,$index,'Stock Transfer No.','stock_transfer_number',false,$parent.$index,'','stock_transfer_number_updated','stock-transfer')" ng-if="record.closed_period == 0">
		    								<span ng-if="record.stock_transfer_number.trim() != '' || record.stock_transfer_number != null">[[record.stock_transfer_number | uppercase]]</span>
	    									<span ng-if="record.stock_transfer_number.trim() == '' || record.stock_transfer_number == null">Edit Stock Transfer No.</span>
		  								</a>
		  								<span ng-if="record.closed_period == 1">[[record.stock_transfer_number | uppercase]]</span>
		  							@endif
		  							@if($navigationActions['show_stock_transfer_number_column'] && !$navigationActions['edit_stock_transfer_number_column'])
		  								[[record.stock_transfer_number | uppercase]]
		  							@endif
								</td>	
								<td id="[[$index]]-transfer_date_updated" ng-class="[record.transfer_date_updated]">
									@if($navigationActions['show_transaction_date_column'] && $navigationActions['edit_transaction_date_column'])
										<a href="" class="editable-click" ng-click="editColumn('date','txn_stock_transfer_in_header','transfer_date',record.stock_transfer_in_header_id,record.transfer_date,$index,'Transaction Date','transfer_date',false,$parent.$index,'','transfer_date_updated','stock-transfer')" ng-if="record.closed_period == 0">
		    								<span ng-if="record.transfer_date.trim() != '' || record.transfer_date != null" ng-bind="record.transaction_date_formatted = (formatDate(record.transfer_date) | date:'MM/dd/yyyy hh:mm a')"></span>
	    									<span ng-if="record.transfer_date.trim() == '' || record.transfer_date == null">Edit Transaction Date</span>
		  								</a>
		  								<span ng-if="record.closed_period == 1" ng-bind="record.transaction_date_formatted = (formatDate(record.transfer_date) | date:'MM/dd/yyyy hh:mm a')"></span>
		  							@endif
		  							@if($navigationActions['show_transaction_date_column'] && !$navigationActions['edit_transaction_date_column'])
		  								<span ng-bind="record.transaction_date_formatted = (formatDate(record.transfer_date) | date:'MM/dd/yyyy hh:mm a')"></span>
		  							@endif	
								</td>
								<td>[[record.salesman_name]]</td>
								<td>[[record.area_name]]</td>
								<td>[[record.dest_van_code]]</td>
								<td>[[record.segment_code]]</td>
								<td>[[record.brand]]</td>
								<td>[[record.item_code]]</td>
								<td>[[record.description]]</td>
								<td>[[record.uom_code]]</td>
								<td id="[[$index]]-quantity_updated" ng-class="[record.quantity_updated]">
									@if($navigationActions['show_quantity_column'] && $navigationActions['edit_quantity_column'])
										<a href="" class="editable-click" ng-click="editColumn('number','txn_stock_transfer_in_detail','quantity',record.stock_transfer_in_detail_id,record.quantity,$index,'Qty','quantity',false,$parent.$index,'','quantity_updated','stock-transfer')" ng-if="record.closed_period == 0">
		    								<span ng-if="record.quantity.trim() != '' || record.quantity > 0 || record.quantity != null">[[ record.quantity ]]</span>
		    								<span ng-if="record.quantity.trim() == '' || record.quantity == 0 || record.quantity == null">Edit Qty</span>
		  								</a>
		  								<span ng-if="record.closed_period == 1">[[record.quantity]]</span>
		  							@endif
		  							@if($navigationActions['show_quantity_column'] && !$navigationActions['edit_quantity_column'])
		  								[[record.quantity]]
		  							@endif
								</td>
							</tr>									
						</tbody>				
						{!!Html::tfooter(true,9)!!}
					{!!Html::tclose()!!}			
				@endif
			</div>			
		</div>
	</div>
</div>
