<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		
		body {
			font-size: 10px;
		}
		
		table.no-border {
    		border-collapse: collapse;
    		font-size: 11px;
		}		
		table.no-border,
		.no-border th,
		.no-border td {
			border: 1px solid white;
			word-wrap: break-word;			
		}
		
		table.table-data {
			width: auto;
    		border-collapse: collapse;
    		font-size: {{$fontSize}};
		}		
		table.table-data,
		.table-data th,
		.table-data td {
			border: 1px solid black;
			word-wrap: break-word;			
		}
		
		.title {
			 margin: auto;
    		 width: 10%;
		}
		.records {
			 margin: auto;
    		 width: 65%;
		}
	</style>
</head>
<body>
	<div class="title">		
		@if(isset($header))
			<h3>{{$header}}</h3>			
		@endif
	</div>
	
	<div>
	<table class="table-data">		
		<tbody>
			<tr>
				<th colspan="27">SALES & COLLECTION: CURRENT TRANSACTION</th>
			</tr>
			@if($theadRaw)
				{!!$theadRaw!!}
			@else
				<tr>
					@foreach($columns as $column)
						<th align="center" style="wrap-text:true">{!!$column['name']!!}</th>
					@endforeach
				</tr>
			@endif			
			@foreach($current as $record)
				<tr>
					@foreach($rows as $row)
						<td align="left" style="wrap-text:true">
							@if(is_object($record) && isset($record->$row))
								@if(false !== strpos($row,'date'))
									{{ date('m/d/Y', strtotime($record->$row)) }}
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!number_format($record->$row,2,'.',',')!!}	
								@else
									{!!$record->$row!!}
								@endif
							@elseif(is_array($record) && isset($record[$row]))
								@if(false !== strpos($row,'date'))
									{{ date('m/d/Y', strtotime($record[$row])) }}
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!number_format($record->$row,2,'.',',')!!}	
								@else
									{!!$record[$row]!!}
								@endif									
							@endif
						</td>
					@endforeach
				</tr>
			@endforeach	
			
			@if(isset($currentSummary) && $currentSummary)
				<tr>
					<th>Total</th>
					@foreach($rows as $key=>$row)
						@if($key > 0)
							<th align="left" style="wrap-text:true">
								@if(is_object($currentSummary) && isset($currentSummary->$row))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!$currentSummary->$row!!}
										@else
											({!!number_format($currentSummary->$row,2,'.',',')!!})
										@endif
									@else
										@if($row == 'quantity')
											{!!$currentSummary->$row!!}
										@else
											{!!number_format($currentSummary->$row,2,'.',',')!!}
										@endif
									@endif									
								@elseif(is_array($currentSummary) && isset($currentSummary[$row]))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!$currentSummary[$row]!!}
										@else
											({!!number_format($currentSummary[$row],2,'.',',')!!})
										@endif
									@else
										@if($row == 'quantity')
											{!!$currentSummary[$row]!!}
										@else
											{!!number_format($currentSummary[$row],2,'.',',')!!}
										@endif
									@endif
								@endif													
							</th>
						@endif						
					@endforeach
				</tr>			
			@endif			
		</tbody>
	</table>	
	<table>		
		<tbody>
			<tr>
				<th colspan="27">SALES & COLLECTION: PREVIOUS TRANSACTION</th>
			</tr>
			@if($theadRaw)
				{!!$theadRaw!!}
			@else
				<tr>
					@foreach($columns as $column)
						<th align="center" style="wrap-text:true">{!!$column['name']!!}</th>
					@endforeach
				</tr>
			@endif			
			@foreach($previous as $record)
				<tr>
					@foreach($rows as $row)
						<td align="left" style="wrap-text:true">
							@if(is_object($record) && isset($record->$row))
								@if(false !== strpos($row,'date'))
									{{ date('m/d/Y', strtotime($record->$row)) }}
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!number_format($record->$row,2,'.',',')!!}	
								@else
									{!!$record->$row!!}
								@endif
							@elseif(is_array($record) && isset($record[$row]))
								@if(false !== strpos($row,'date'))
									{{ date('m/d/Y', strtotime($record[$row])) }}
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!number_format($record->$row,2,'.',',')!!}	
								@else
									{!!$record[$row]!!}
								@endif									
							@endif
						</td>
					@endforeach
				</tr>
			@endforeach	
			
			@if(isset($previousSummary) && $previousSummary)
				<tr>
					<th>Total</th>
					@foreach($rows as $key=>$row)
						@if($key > 0)
							<th align="left" style="wrap-text:true">
								@if(is_object($previousSummary) && isset($previousSummary->$row))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!$previousSummary->$row!!}
										@else
											({!!number_format($previousSummary->$row,2,'.',',')!!})
										@endif
									@else
										@if($row == 'quantity')
											{!!$previousSummary->$row!!}
										@else
											{!!number_format($previousSummary->$row,2,'.',',')!!}
										@endif
									@endif									
								@elseif(is_array($previousSummary) && isset($previousSummary[$row]))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!$previousSummary[$row]!!}
										@else
											({!!number_format($previousSummary[$row],2,'.',',')!!})
										@endif
									@else
										@if($row == 'quantity')
											{!!$previousSummary[$row]!!}
										@else
											{!!number_format($previousSummary[$row],2,'.',',')!!}
										@endif
									@endif
								@endif													
							</th>
						@endif						
					@endforeach
				</tr>			
			@endif			
		</tbody>
	</table>
	
	<table class="no-border">
		<tbody>
			<tr>
				<th colspan="3">Generated By: {{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>				
			</tr>
			<tr>
				<th colspan="3">Date Generated: {{date("F j, Y g:i A")}}</th>
			</tr>
		</tbody>
	</table>		
</body>
</html>