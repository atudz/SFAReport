{!!Html::breadcrumb(['Sales Report','Customer List'])!!}
{!!Html::pageheader('Customer List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::select('salesman_code','Salesman', $salesman)!!}
						{!!Html::select('area','Area', $areas)!!}
						{!!Html::select('status','Status', $statuses)!!}						
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::datepicker('sfa_modified_date','SFA Modified Date',true)!!}
						{!!Html::select('company_code','Company', $companyCode)!!}																			 		
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query">
							<td>[[record.customer_code]]</td>
							<td>[[record.customer_name]]</td>
							<td>[[record.address]]</td>
							<td>[[record.area_code]]</td>
							<td>[[record.area_name]]</td>
							<td>[[record.storetype_code]]</td>
							<td>[[record.storetype_name]]</td>
							<td>[[record.vatposting_code]]</td>
							<td>[[record.vat_ex_flag]]</td>
							<td>[[record.customer_price_group]]</td>
							<td>[[record.salesman_code]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.van_code]]</td>
							<td>[[record.sfa_modified_date]]</td>
							<td>[[record.status]]</td>									
						</tr>
	
					</tbody>
					{!!Html::tfooter(true,15)!!}
				{!!Html::tclose()!!}
				
			</div>			
		</div>
	</div>
</div>
