{!!Html::breadcrumb(['Van Inventory','Replenishment Report'])!!}
{!!Html::pageheader('Replenishment Report')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				@if($navigationActions['show_filter'])
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">	
							{!!Html::select('salesman_code','Salesman Name', $salesman,$isSalesman ? '' : 'Select Salesman',['onchange'=>'setSalesmanDetails(this)'])!!}
							{!!Html::select('jr_salesman','Junior Salemsan', $jrSalesmans,'No Jr. Salesman', ['disabled'=>true])!!}
							{!!Html::select('van_code','Van Code', $vanCodes,'No Van Code', ['disabled'=>true])!!}						
							{!!Html::select('type','Replenishment Type', replenishment_types(),'',['onchange'=>'setSalesmanDetails($("#salesman_code"))'])!!}
						</div>			
						<div class="col-md-6">	
							{!!Html::select('area_code','Area', $areas, 'All')!!}
							{!!Html::select('reference_number','Transaction No.', replenishment_refs(), 'All')!!}
							{!!Html::select('replenishment_date','Transaction Date', replenishment_dates(), 'All')!!}			
						</div>													
					{!!Html::fclose()!!}
				@endif
				<!-- End Filter -->
				
					{!!Html::topen([
							'show_download'   => $navigationActions['show_download'],
							'show_print'      => $navigationActions['show_print_button'],
							'show_search'     => $navigationActions['show_search_field'],						
							'execute' 		  => true,
						])!!}
						{!!Html::theader($tableHeaders)!!}
						<tbody>
							<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>							
								<td>[[record.type]]</td>
								<td>[[record.area_name]]</td>
								<td>[[record.salesman_name]]</td>														
								<td>[[record.van_code]]</td>
								<td>[[record.reference_number]]</td>
								<td>
									<span ng-bind="record.replenishment_date_formatted = (formatDate(record.replenishment_date) | date:'MM/dd/yyyy hh:mm a')"></span>
								</td>
								<td>[[record.segment]]</td>
								<td>[[record.brand_name]]</td>
								<td>[[record.item_code]]</td>
								<td>[[record.item]]</td>
								<td>[[record.quantity]]</td>
							</tr>		
						</tbody>				
						{!!Html::tfooter(true,11)!!}
					{!!Html::tclose()!!}			
				
			</div>			
		</div>
	</div>
</div>

<script>
	function setSalesmanDetails(el)
 	{
		var jrSalesman = [];
		@foreach($jrSalesmans as $k => $val)
			jrSalesman.push('{{ $k }}');
		@endforeach
		var vanCodes = [];
		@foreach($vanCodes as $k => $val)
			vanCodes.push('{{ $k }}');
		@endforeach

 		var sel = $(el).val();
		if(-1 !== $.inArray(sel,jrSalesman)) {			
			$('select[name=jr_salesman]').val(sel);
		} else {
			$('select[name=jr_salesman]').val('');
		}

		if(-1 !== $.inArray(sel,vanCodes)) {			
			$('select[name=van_code]').val(sel);
		} else {
			$('select[name=van_code]').val('');
		}

		if(sel){
			var type = $('select[name=type]').val();
			var url1 = 'reports/salesman/replenishment/refs/'+sel;
			if(type){
				url1 += '/'+type;
			}

			$.get(url1,function(data) {		
				$('#reference_number').empty();
				$('#reference_number').append($("<option></option>").attr("value", '').text('All'));
				if(data){				
					$.each(data, function(k,v){
						$('#reference_number')
							.append($("<option></option>")
							.attr("value", k).text(v));
					});				
				}							
			});


			var url2 = 'reports/salesman/replenishment/dates/'+sel;
			if(type){
				url2 += '/'+type;
			}

			$.get(url2,function(data) {			
				$('#replenishment_date').empty();
				$('#replenishment_date').append($("<option></option>").attr("value", '').text('All'));
				if(data){				
					$.each(data, function(k,v){
						$('#replenishment_date')
							.append($("<option></option>")
							.attr("value", k).text(v));
					});				
				}							
			});
		}		
 	}
</script>
