{!!Html::breadcrumb(['Van Inventory','Actual Count Replenishment'])!!}
{!!Html::pageheader('Actual Count Replenishment')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-8">	
						{!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman,$isSalesman ? '' : 'Select Salesman')!!}
						{!!Html::datepicker('replenishment_date','Count date/time <span class="required">*</span>',false)!!}
						{!!Html::input('text','reference_number','Count Sheet No. <span class="required">*</span>')!!}						
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen(['no_download'=>$isGuest2,'no_pdf'=>$isGuest1,'add_link'=>'replenishment.add','edit_link'=>'replenishment.edit/A1'])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>							
							<td>[[record.item_code]]</td>
							<td>[[record.description]]</td>
							<td>[[record.quantity]]</td>														
						</tr>									
					</tbody>				
					{!!Html::tfooter(true,6)!!}
				{!!Html::tclose()!!}			
			</div>			
		</div>
	</div>
</div>
