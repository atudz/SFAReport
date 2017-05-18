{!!Html::breadcrumb(['Van Inventory','Adjustment Replenishment'])!!}
{!!Html::pageheader('Adjustment Replenishment')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-8">	
						{!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman,$isSalesman ? '' : 'Select Salesman',['onblur'=>'validate(this)'])!!}
						{!!Html::datepicker('replenishment_date','Adjustment date/time <span class="required">*</span>',false)!!}
						{!!Html::input('text','reference_number','Adjustment No. <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}						
						{!!Html::input('text','adjustment_reason','Adjustment Reason')!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen(['no_download'=>$isGuest2,'no_pdf'=>$isGuest1,'add_link'=>'adjustment.add','edit_link'=>'[[editUrl]]','edit_hide'=>'[[editHide]]'])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
							<td>[[record.segment_code]]</td>
							<td>[[record.brand_name]]</td>							
							<td>[[record.description]]</td>
							<td>[[record.item_code]]</td>							
							<td>[[record.quantity]]</td>														
						</tr>									
					</tbody>				
					{!!Html::tfooter(true,5)!!}
				{!!Html::tclose()!!}			
			</div>			
		</div>
	</div>
</div>
