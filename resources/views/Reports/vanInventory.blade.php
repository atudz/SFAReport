{!!Html::breadcrumb(['Van Inventory',$title])!!}
{!!Html::pageheader($title)!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::select('salesman_code','Salesman', $salesman,'')!!}
						{!!Html::select('status','Status', $statuses,'')!!}
						{!!Html::input('text','invoice_number','Invoice #')!!}
						{!!Html::input('text','stock_transfer_number','Stock Transfer #')!!}
					</div>					
					<div class="pull-right col-sm-6">
						{!!Html::datepicker('transaction_date','Transaction Date','true')!!}	
						{!!Html::input('text','return_slip_num','Return Slip #')!!}
						{!!Html::input('text','reference_number','Replenishment #')!!}					
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
								
				{!!Html::topen(['no_pdf'=>true])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
					<tbody ng-repeat="item in items">
																
						<!-- Beginning balance -->
						<tr ng-show="item.replenishment.total">
							<td class="bold">Beginning Balance</td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							@foreach($itemCodes as $item)
								<td class="bold">[[item.replenishment.{{'code_'.$item->item_code}}]]</td>
							@endforeach
						</tr>											
						
						
						<!-- Actual Count -->
						<tr style="background-color:#ccccff;" ng-show="item.replenishment.total">
							<td class="bold">Actual Count</td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold">
								<span ng-bind="formatDate(item.replenishment.replenishment_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td class="bold">[[item.replenishment.reference_number | uppercase]]</td>
							@foreach($itemCodes as $item)
								<td class="bold">[[item.replenishment.{{'code_'.$item->item_code}}]]</td>
							@endforeach
						</tr>
						
						<!-- Stock count -->
						<tr ng-repeat="stock in item.stocks|filter:query" ng-show="item.show_stocks" id="[[$parent.$index]]_[[$index]]" class=[[stock.updated]]>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold">
								<span ng-bind="formatDate(stock.transaction_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td>
								@if($isAdmin)
									<a href="" class="editable-click" ng-click="editColumn('text','txn_stock_transfer_in_header','stock_transfer_number',stock.stock_transfer_in_header_id,stock.stock_transfer_number,$index,'Stock Transfer No.','stock_transfer_number',false,$parent.$index)">
	    								[[stock.stock_transfer_number | uppercase]]
	  								</a>
	  							@else
	  								[[stock.stock_transfer_number | uppercase]]
	  							@endif
							</td>
							<td class="bold"></td>
							<td class="bold"></td>


							@foreach($itemCodes as $item)
								<td class="bold">[[stock.{{'code_'.$item->item_code}}]]</td>
							@endforeach
						</tr>
						
						<!-- Record list -->
						<tr ng-repeat="record in item.records|filter:query" ng-show="item.total" class="[[record.updated]]">
							<td>[[record.customer_name]]</td>
							<td>
								<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>							
							</td>
							<td>[[record.invoice_number | uppercase]]</td>
							<td>[[record.return_slip_num | uppercase]]</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							@foreach($itemCodes as $item)
								<td> [[record.{{'code_'.$item->item_code}}]]</td>
							@endforeach
						</tr>
						
						<!-- Stock on Hand -->
						<tr style="background-color: #ccffcc" ng-show="item.showBody">
							<td class="bold">Stock On Hand</td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							@foreach($itemCodes as $item)
								<td class="bold">[[item.stock_on_hand.{{'code_'.$item->item_code}}]]</td>
							@endforeach
						</tr>
												
						<!-- Short over stocks -->
						<tr style="background-color:#edc4c4;" ng-show="item.short_over_stocks.total">
							<td class="bold">Short/Over Stocks</td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							<td class="bold"></td>
							@foreach($itemCodes as $item)
								<td class="bold">[[item.short_over_stocks.{{'code_'.$item->item_code}}]]</td>
							@endforeach
						</tr>
																		
					</tbody>	
					<tr id="no_records_div" style="background-color:white;">
						<td colspan="{{8+count($itemCodes)}}">
								No records found.
						</td>
					</tr>
						
					</tbody>				
				{!!Html::tclose(false)!!}
				<input type="hidden" id="inventory_type" value="{{$type}}">
				
				<div class="rs-mini-toolbar hide" id="load_more">
					<div class="rs-toolbar-savebtn">
						<a class="button-primary revgreen" ng-click="more()" id="button_save_slide-tb" original-title="" style="display: block; cursor:pointer;">
							<i class="fa fa-refresh" style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>
							Load more..
						</a>
					</div>					
				</div>
			</div>			
		</div>
	</div>
</div>
