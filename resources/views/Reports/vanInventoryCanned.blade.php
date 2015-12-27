{!!Html::breadcrumb(['Van Inventory','Canned & Mixes'])!!}
{!!Html::pageheader('Canned & Mixes')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::datepicker('transaction_date','Transaction Date','true')!!}
						{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::select('salesman','Salesman', $salesman)!!}							 			
						{!!Html::datepicker('posting_date','Posting Date','true')!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				<div class="col-sm-12">
					<div class="pull-left">
						<form class="form-inline">
							<div class="form-group">
								<div class="inner-addon left-addon">
									<i class="glyphicon glyphicon-search"></i>
									<input type="text" class="form-control input-sm" placeholder="Search" ng-model="query.$"/>
								</div>
							</div>
							<div class="form-group">
								<select id="transaction_date" class="form-control">
										<option value="2015/11/09">2015/11/09</option>
										<option value="2015/11/10">2015/11/10</option>
								</select>
							</div>
						</form>
				    </div>				    
			    </div>			    
				{!!Html::topen(['no_download'=>true,'no_search'=>true])!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr style="background-color:#ccccff;">
							<th><strong>ACTUAL COUNT</strong></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th>
								<span ng-bind="formatDate(replenishment.replenishment_date) | date:'MM/dd/yyyy'"></span>
							<td>[[replenishment.reference_number]]</td>
							@foreach($itemCodes as $item)
								<th>[[replenishment.{{'code_'.$item->item_code}}]]</th>
							@endforeach
						</tr>
						<tr>
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
						<tr ng-repeat="record in records|filter:query">
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
						
						<tr style="background-color: #ccffcc">
							<th>STOCK ONHAND</th>
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
					</tbody>
				{!!Html::tclose()!!}
				<input type="hidden" id="inventory_type" value="canned">
			</div>			
		</div>
	</div>
</div>
