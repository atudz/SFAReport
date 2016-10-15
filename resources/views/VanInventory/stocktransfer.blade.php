{!!Html::breadcrumb(['Van Inventory','Stock Transfer'])!!}
{!!Html::pageheader('Stock Transfer')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-6">
						{!!Html::select('salesman','Salesman', $salesman)!!}						
						{!!Html::select('company_code','Company Code', $companyCode)!!}
						{!!Html::select('area','Area', $areas)!!}												
						{!!Html::select('segment','Segment', $segments)!!}													 																															
					</div>					
					<div class="col-md-6">	
						{!!Html::select('material','Material', $items)!!}
						{!!Html::datepicker('transfer_date','Stock Transfer Date',true)!!}
						{!!Html::input('text','stock_transfer_number','Stock Transfer #')!!}						
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen(['no_download'=>$isGuest2,'no_pdf'=>$isGuest1])!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
							<td>[[record.stock_transfer_number]]</td>	
							<td>
								<span ng-bind="record.transfer_date_formatted = (formatDate(record.transfer_date) | date:'MM/dd/yyyy')"></span>
							</td>
							<td>[[record.dest_van_code]]</td>
							<td>[[record.segment_code]]</td>
							<td>[[record.brand]]</td>
							<td>[[record.item_code]]</td>
							<td>[[record.description]]</td>
							<td>[[record.uom_code]]</td>
							<td>[[record.quantity]]</td>
						</tr>									
					</tbody>
				
					{!!Html::tfooter(true,9)!!}
				{!!Html::tclose()!!}			
			</div>			
		</div>
	</div>
</div>
