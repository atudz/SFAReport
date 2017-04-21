{!!Html::breadcrumb(['Van Inventory','Stock Audit'])!!}
{!!Html::pageheader('Stock Audit')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">
							{!!Html::select('salesman_code','Salesman', $salesman,$isSalesman ? '' : 'All')!!}						
							{!!Html::select('area','Area', $areas)!!}												
							{!!Html::datepicker('month','Month',false,true)!!}
							{!!Html::datepicker('year','Year',false,false,'','','Calendar',true)!!}												 																															
						</div>					
						<div class="col-md-6">	
							{!!Html::datepicker('period','Period Covered',true)!!}
							{!!Html::input('text','reference_number','Statement No.')!!}						
						</div>			
					{!!Html::fclose()!!}
					<!-- End Filter -->
				@endif

				@if($navigationActions['show_table'])
					{!!Html::topen([
						'show_download'   => $navigationActions['show_download'],
						'show_print'      => $navigationActions['show_print'],
						'show_search'     => $navigationActions['show_search_field'],
					])!!}
						{!!Html::theader($tableHeaders)!!}
						<tbody>
							<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>							
								<td>[[record.area_name]]</td>
								<td>[[record.salesman_name]]</td>
								<td>[[negate(record.canned)]]</td>
								<td>[[negate(record.frozen)]]</td>							
								<td>
									<span ng-bind="record.from_formatted = (formatDate(record.from) | date:'MMM dd')"></span> 
									-
									<span ng-bind="record.to_formatted = (formatDate(record.to) | date:'MMM dd, yyyy')"></span> 
								</td>
								<td>[[record.reference_number]]</td>							
							</tr>									
						</tbody>				
						{!!Html::tfooter(true,6)!!}
					{!!Html::tclose()!!}			
				@endif
			</div>			
		</div>
	</div>
</div>
