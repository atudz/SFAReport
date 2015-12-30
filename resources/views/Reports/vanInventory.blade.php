{!!Html::breadcrumb(['Van Inventory','Canned & Mixes'])!!}
{!!Html::pageheader('Canned & Mixes')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::select('salesman_code','Salesman', $salesman,'')!!}
						{!!Html::select('status','Status', $statuses,'')!!}
					</div>					
					<div class="pull-right col-sm-6">
						{!!Html::datepicker('transaction_date','Transaction Date','true')!!}						
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				<div class="col-sm-12">
						<form class="form-inline">
							<div class="pull-left">
						
								<div class="form-group">
									<div class="inner-addon left-addon">
										<i class="glyphicon glyphicon-search"></i>
										<input type="text" class="form-control input-sm" placeholder="Search" ng-model="query.$"/>
									</div>
								</div>
								</div>
							<div class="pull-right">
								<div class="form-group form-group-sm">
									<label>Date Filter&nbsp;</label>
									<select id="transaction_date" class="form-control" ng-model="dateValue" ng-change="filterDate()">
										<option ng-repeat="date in dateFilter" value=[[date]]>[[date]]</option>											
									</select>
								</div>
							</div>	
						</form>
				    				    
			    </div>			    
				{!!Html::topen(['no_download'=>true,'no_search'=>true])!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr style="background-color:#ccccff;" ng-show="showBody">
							<th>Actual Count</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>
								<span ng-bind="formatDate(replenishment.replenishment_date) | date:'MM/dd/yyyy'"></span>
							</th>
							<th>[[replenishment.reference_number]]</th>
							@foreach($itemCodes as $item)
								<th>[[replenishment.{{'code_'.$item->item_code}}]]</th>
							@endforeach
						</tr>
						<tr ng-show="showBody">
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>
								<span ng-bind="formatDate(stocks.transaction_date) | date:'MM/dd/yyyy'"></span>
							</th>
							<th>[[stocks.stock_transfer_number]]</th>
							<th></th>
							<th></th>
							@foreach($itemCodes as $item)
								<th>[[stocks.{{'code_'.$item->item_code}}]]</th>
							@endforeach
						</tr>
						<tr ng-repeat="record in records|filter:query" ng-show="showBody">
							<td>[[record.customer_name]]</td>
							<td>
								<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>							
							</td>
							<td>[[record.invoice_number]]</td>
							<td>[[record.return_slip_num]]</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							@foreach($itemCodes as $item)
								<td> [[record.{{'code_'.$item->item_code}}]]</td>
							@endforeach
						</tr>
						<tr id="no_records_div" style="background-color:white;">
							<td colspan="{{8+count($itemCodes)}}">
								No records found.
							</td>
						</tr>
						
						<tr style="background-color: #ccffcc" ng-show="showBody">
							<th>Stock Onhand</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							@foreach($itemCodes as $item)
								<th>[[stock_on_hand.{{'code_'.$item->item_code}}]]</th>
							@endforeach
						</tr>
						
						<tr style="background-color:#ccccff;" ng-show="showBody">
							<th>Actual Count</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>
								<span ng-bind="formatDate(replenishment.replenishment_date) | date:'MM/dd/yyyy'"></span>
							</th>
							<th>[[replenishment.reference_number]]</th>
							@foreach($itemCodes as $item)
								<th>[[replenishment.{{'code_'.$item->item_code}}]]</th>
							@endforeach
						</tr>	
						
						<tr style="background-color:#edc4c4;" ng-show="showBody">
							<th>Short Over Stocks</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							@foreach($itemCodes as $item)
								<th>[[short_over_stocks.{{'code_'.$item->item_code}}]]</th>
							@endforeach
						</tr>
						
						<tr ng-show="showBody">
							<th>Beginning Balance</th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							@foreach($itemCodes as $item)
								<th>[[replenishment.{{'code_'.$item->item_code}}]]</th>
							@endforeach
						</tr>					
					</tbody>					
				{!!Html::tclose()!!}
				<input type="hidden" id="inventory_type" value="{{$type}}">
			</div>			
		</div>
	</div>
</div>
