{!!Html::breadcrumb(['Sales Report','Salesman List'])!!}
{!!Html::pageheader('Salesman List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-6">
						@if($isSalesman)
							{!!Html::select('salesman_code','Salesman', $salesman,'')!!}
						@else
							{!!Html::select('salesman_code','Salesman', $salesman)!!}
						@endif
						{!!Html::select('area','Area', $areas)!!}
						{!!Html::select('company_code','Company Code', $companyCode)!!}
					</div>					
					<div class="col-md-6">	
						{!!Html::datepicker('sfa_modified_date','SFA Modified date',true)!!}
						{!!Html::select('status','Status', $statuses)!!}													 			
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen(['no_download'=>$isGuest2])!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query">
							<td>[[record.salesman_code]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.area_code]]</td>
							<td>[[record.area_name]]</td>							
							<td>[[record.van_code]]</td>
							<td>
								<span ng-bind="formatDate(record.sfa_modified_date) | date:'MM/dd/yyyy'"></span>
							</td>
							<td>[[record.status]]</td>									
						</tr>
					</tbody>
					{!!Html::tfooter(true,7)!!}
				{!!Html::tclose()!!}
				
			</div>			
		</div>
	</div>
</div>
