{!!Html::breadcrumb(['Sales Report','Material Price List'])!!}
{!!Html::pageheader('Material Price List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->			
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">
							{!!Html::select('company_code','Company Code', $companyCode)!!}
							{!!Html::select('area','Area', $areas)!!}						
							{!!Html::select('segment_code','Segment', $segmentCodes)!!}
							{!!Html::select('item_code','Material', $items)!!}
							{!!Html::select('status','Status', $statuses)!!}
						</div>					
						<div class="col-md-6">	
							{!!Html::datepicker('sfa_modified_date','SFA Modified Date',true)!!}
							{!!Html::datepicker('effective_date1','Effective Date From',true)!!}
							{!!Html::datepicker('effective_date2','Effective Date To',true)!!}																			 		
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
						{!!Html::theader($tableHeaders,$navigationActions['can_sort_columns'])!!}
							<tbody>
								<tr ng-repeat="record in records|filter:query" class=[[record.updated]]>
									<td>[[record.item_code]]</td>
									<td>[[record.description]]</td>
									<td>[[record.uom_code]]</td>
									<td>[[record.segment_code]]</td>
									<td>[[record.unit_price]]</td>
									<td>[[record.customer_price_group]]</td>
									<td>
										<span ng-bind="record.effective_date_from_formatted = (formatDate(record.effective_date_from) | date:'MM/dd/yyyy')"></span>
									</td>
									<td>
										<span ng-bind="record.effective_date_to_formatted = (formatDate(record.effective_date_to) | date:'MM/dd/yyyy')"></span>
									</td>
									<td>[[record.area_name]]</td>
									<td>
										<span ng-bind="record.sfa_modified_date_formatted = (formatDate(record.sfa_modified_date) | date:'MM/dd/yyyy')"></span>
									</td>
									<td>[[record.status]]</td>
								</tr>
							</tbody>
						{!!Html::tfooter(true,11)!!}
					{!!Html::tclose()!!}
				@endif
			</div>			
		</div>
	</div>
</div>
