{!!Html::breadcrumb(['Summary of Reversal'])!!}
{!!Html::pageheader('Summary of Reversal')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-6">	
						{!!Html::select('salesman','Salesman', $salesman,'All')!!}
						{!!Html::select('report','Reports', get_reports(),'All')!!}
						{!!Html::select('branch','Branch', $areas)!!}
						{!!Html::select('updated_by','User', get_users())!!}																										
					</div>			
					<div class="col-md-6">	
						{!!Html::datepicker('created_at','Reversal Date',true)!!}
						{!!Html::input('text','revision','Reversal No.')!!}																
					</div>
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen(['no_download'=>$isGuest2,'no_pdf'=>($isGuest1 || $isManager)])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query">
							<td>[[record.revision_number]]</td>
							<td>
								<span ng-bind="record.created_at_formatted = (formatDate(record.created_at) | date:'MM/dd/yyyy h:mm a')"></span>
							</td>
							<td>[[record.report_type]]</td>
							<td>[[record.area_name]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.before]]</td>
							<td>[[record.value]]</td>
							<td>[[record.comment]]</td>
							<td>[[record.username]]</td>														
						</tr>									
					</tbody>				
					{!!Html::tfooter(true,9)!!}
				{!!Html::tclose()!!}			
			</div>			
		</div>
	</div>
</div>
