{!!Html::breadcrumb(['Sales Report','Material Price List'])!!}
{!!Html::pageheader('Material Price List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6 col-xs-12">
						{!!Html::select('company_code','Company', $companyCode)!!}
						{!!Html::select('area','Area', $areas)!!}						
						{!!Html::select('segment_code','Segment', $segmentCodes)!!}
						{!!Html::select('item_code','Material', $items)!!}
						{!!Html::select('status','Status', $statuses)!!}
					</div>					
					<div class="pull-right col-sm-6 col-xs-12">	
						{!!Html::datepicker('sfa_modified_date','SFA Modified date',true)!!}
						{!!Html::datepicker('effective_date1','Effective date from',true)!!}
						{!!Html::datepicker('effective_date2','Effective date to',true)!!}																			 		
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
					<tr ng-repeat="record in records|filter:query" class=[[record.updated]]>
						<td>[[record.item_code]]</td>
						<td>[[record.description]]</td>
						<td>[[record.uom_code]]</td>
						<td>[[record.segment_code]]</td>
						<td>[[record.unit_price]]</td>
						<td>[[record.customer_price_group]]</td>
						<td>
							<span ng-bind="formatDate(record.effective_date_from) | date:'MM/dd/yyyy'"></span>
						</td>
						<td>
							<span ng-bind="formatDate(record.effective_date_to) | date:'MM/dd/yyyy'"></span>
						</td>
						<td>[[record.area_name]]</td>
						<td>
							<span ng-bind="formatDate(record.sfa_modified_date) | date:'MM/dd/yyyy'"></span>
						</td>
						<td>[[record.status]]</td>
					</tr>
					</tbody>
					{!!Html::tfooter(true,11)!!}
				{!!Html::tclose()!!}
				
			</div>			
		</div>
	</div>
</div>
