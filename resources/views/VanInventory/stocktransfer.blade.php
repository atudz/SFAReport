{!!Html::breadcrumb(['Van Inventory','Stock Transfer'])!!}
{!!Html::pageheader('Stock Transfer')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
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
				
				{!!Html::topen(['no_download'=>$isGuest2,'no_pdf'=>$isGuest1,'add_link'=>'stocktransfer.add'])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
							<td>
								@if($isAdmin || $isAuditor)
									<a href="" class="editable-click" ng-click="editColumn('text','txn_stock_transfer_in_header','stock_transfer_number',record.stock_transfer_in_header_id,record.stock_transfer_number,$index,'Stock Transfer No.','stock_transfer_number',false,$parent.$index)">
	    								[[record.stock_transfer_number | uppercase]]
	  								</a>
	  							@else
	  								[[record.stock_transfer_number | uppercase]]
	  							@endif
							</td>	
							<td>
								@if($isAdmin || $isAuditor)
									<a href="" class="editable-click" ng-click="editColumn('date','txn_stock_transfer_in_header','transfer_date',record.stock_transfer_in_header_id,record.transfer_date,$index,'Transaction Date','transfer_date',false,$parent.$index)">
	    								<span ng-bind="record.transaction_date_formatted = (formatDate(record.transfer_date) | date:'MM/dd/yyyy hh:mm a')"></span>
	  								</a>
	  							@else
	  								<span ng-bind="record.transaction_date_formatted = (formatDate(record.transfer_date) | date:'MM/dd/yyyy hh:mm a')"></span>
	  							@endif	
							</td>
							<td>[[record.dest_van_code]]</td>
							<td>[[record.segment_code]]</td>
							<td>[[record.brand]]</td>
							<td>[[record.item_code]]</td>
							<td>[[record.description]]</td>
							<td>[[record.uom_code]]</td>
							<td>
								@if($isAdmin || $isAuditor)
									<a href="" class="editable-click" ng-click="editColumn('number','txn_stock_transfer_in_detail','quantity',record.stock_transfer_in_detail_id,record.quantity,$index,'Qty','quantity',false,$parent.$index)">
	    								[[record.quantity]]
	  								</a>
	  							@else
	  								[[record.quantity]]
	  							@endif
							</td>
						</tr>									
					</tbody>				
					{!!Html::tfooter(true,9)!!}
				{!!Html::tclose()!!}			
			</div>			
		</div>
	</div>
</div>
