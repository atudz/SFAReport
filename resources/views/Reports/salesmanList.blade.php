{!!Html::breadcrumb(['Sales Report','Salesman List'])!!}
{!!Html::pageheader('Salesman List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::select('salesman_code','Salesman', $salesman)!!}
						{!!Html::select('area','Area', $areas)!!}
						{!!Html::select('customer_code','Customer Code', $customerCode)!!}
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
							<td>[[record.salesman_code]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.area_code]]</td>
							<td>[[record.area_name]]</td>							
							<td>[[record.van_code]]</td>
							<td>[[record.sfa_modified_date]]</td>
							<td>[[record.status]]</td>									
						</tr>
					</tbody>
				{!!Html::tclose()!!}
				
			</div>			
		</div>
	</div>
</div>
