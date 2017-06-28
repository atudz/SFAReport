{!!Html::breadcrumb(['Sales Report','Customer List'])!!}
{!!Html::pageheader('Customer List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
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
							{!!Html::input('text','customer_name','Customer Name')!!}													
						</div>					
						<div class="col-md-6">	
							{!!Html::datepicker('sfa_modified_date','SFA Modified Date',true)!!}									
							{!!Html::select('customer_price_group','Customer Price Group', $priceGroup)!!}
							{!!Html::select('status','Status', $statuses)!!}																															 	
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
						{!!Html::theader($tableHeaders,[
							'can_sort' => $navigationActions['can_sort_columns']
						])!!}
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
									<td>
										<span ng-bind="record.sfa_modified_date_formatted = (formatDate(record.sfa_modified_date) | date:'MM/dd/yyyy')"></span>
									</td>
									<td>[[record.status]]</td>									
								</tr>
			
							</tbody>
						{!!Html::tfooter(true,15)!!}
					{!!Html::tclose()!!}
				@endif
			</div>			
		</div>
	</div>
</div>
