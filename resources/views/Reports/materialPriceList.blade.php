{!!Html::breadcrumb(['Sales Report','Material Price List'])!!}
{!!Html::pageheader('Material Price List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::select('customer_code','Company Code', $customerCode)!!}
						{!!Html::select('area','Area', $areas)!!}						
						{!!Html::select('segment_code','Segment', $segmentCodes)!!}
						{!!Html::select('item_code','Material', $items)!!}
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::datepicker('sfa_modified_date','SFA Modified date',true)!!}
						{!!Html::select('status','Status', $statuses)!!}													 			
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
					<tr ng-repeat="record in records|filter:query">
						<td>[[record.item_code]]</td>
						<td>[[record.description]]</td>
						<td>[[record.uom_code]]</td>
						<td>[[record.segment_code]]</td>
						<td>[[record.unit_price]]</td>
						<td>[[record.customer_price_group]]</td>
						<td>[[record.effective_date_from]]</td>
						<td>[[record.effective_date_to]]</td>
						<td>[[record.area_name]]</td>
						<td>[[record.sfa_modified_date]]</td>
						<td>[[record.status]]</td>
					</tr>
					</tbody>
				{!!Html::tclose()!!}
				
			</div>			
		</div>
	</div>
</div>
