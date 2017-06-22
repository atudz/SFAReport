{!!Html::breadcrumb(['Invoice Series Mapping'])!!}
{!!Html::pageheader('Invoice Series Mapping')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-8">	
							{!!Html::select('salesman_code','Salesman', $salesman,$isSalesman ? '' : 'Select Salesman')!!}
							{!!Html::select('area_code','Area', $areas,'Select Area')!!}
							{!!Html::datepicker('replenishment_date','Date Assigned',false)!!}
							{!!Html::select('status','Status', statuses(),'Select Status')!!}						
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
						'add_link'        => 'invoiceseries.add'
					])!!}
						{!!Html::theader($tableHeaders,$navigationActions['can_sort_columns'])!!}
							<tbody>
								<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
									<td>[[record.area_name]]</td>
									<td>[[record.salesman_code]]</td>							
									<td>[[record.salesman_name]]</td>
									<td>[[record.invoice_start]]</td>
									<td>[[record.invoice_end]]</td>														
									<td>
										<span ng-bind="created_at = (formatDate(record.created_at) | date:'MM/dd/yyyy hh:mm a')"></span>
									</td>
									<td>[[record.status]]</td>
									<td align="center">
										@if($navigationActions['show_edit_button'])
											<a href="#invoiceseries.edit/[[record.id]]" uib-tooltip="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>								
										@endif
									</td>
								</tr>									
							</tbody>				
						{!!Html::tfooter(true,8)!!}
					{!!Html::tclose()!!}			
				@endif
			</div>			
		</div>
	</div>
</div>
