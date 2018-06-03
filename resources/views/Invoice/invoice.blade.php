{!!Html::breadcrumb(['Invoice Series Mapping'])!!}
{!!Html::pageheader('Invoice Series Mapping')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-8">							
							{!!Html::select('salesman_code','Salesman', $salesman,$isSalesman ? '' : 'Select Salesman', ['onchange'=>'set_area(this)'])!!}
							{!!Html::select('area_code','Area', [],'Select Salesman',['disabled'=>true])!!}
							{!!Html::datepicker('replenishment_date','Date Assigned',false)!!}
							{!!Html::select('status','Status', statuses(),'Select Status')!!}						
						</div>			
					{!!Html::fclose()!!}
				<!-- End Filter -->
								
				{!!Html::topen([
						'show_download'   => true,
						'show_print'      => true,
						'show_search'     => true,
						'show_add_button' => true,
						'add_link'        => 'invoiceseries.add'
				])!!}
						{!!Html::theader($tableHeaders)!!}
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
										<a href="#invoiceseries.edit/[[record.id]]" uib-tooltip="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>																		
									</td>
								</tr>									
							</tbody>				
						{!!Html::tfooter(true,8)!!}
				{!!Html::tclose()!!}			
			</div>			
		</div>
	</div>
</div>

<script>
	function set_area(el)
	{
		var sel = $(el).val();
		if(!sel){
			$('#area_code').empty();
			$('#area_code')
				.append($("<option></option>")
				.attr("value", '').text('Select Salesman'));
			$('#area_code').attr('disabled',true);						
		}
		else{
			var url = 'reports/salesman/area/'+sel;
			$.get(url,function(data){
				if(data){
					$('#area_code').empty();
					$.each(data, function(k,v){
						$('#area_code')
							.append($("<option></option>")
							.attr("value", k).text(v));
					});
					$('#area_code').removeAttr('disabled');
				} else {
					$('#area_code').empty();
					$('#area_code').attr('disabled',true);
				}			
			});
		}
	}	

</script>
