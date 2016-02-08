<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table>
		<tbody>
			@if(isset($header))
			<tr>
				<th colspan="2" align="center">{{$header}}</th>
			</tr>
			@endif
			@if(isset($filters))
				@foreach($filters as $label=>$val)
					<tr>
						<td align="left"><strong>{{$label}}</strong></td>
						<td align="left">{{$val}}</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
	
	<table>		
		<tbody>
			@if($theadRaw)
				{!!$theadRaw!!}
			@else
				<tr>
					@foreach($columns as $column)
						<th align="center" style="wrap-text:true">{!!$column['name']!!}</th>
					@endforeach
				</tr>
			@endif			
			@foreach($records as $record)
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
			
			@if(isset($summary) && $summary)
				<tr>
					<th>Total</th>
					@foreach($rows as $key=>$row)
						@if($key > 0)
							<th align="left" style="wrap-text:true">
								@if(is_object($summary) && isset($summary->$row))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!$summary->$row!!}
										@else
											({!!number_format($summary->$row,2,'.',',')!!})
										@endif
									@else
										@if($row == 'quantity')
											{!!$summary->$row!!}
										@else
											{!!number_format($summary->$row,2,'.',',')!!}
										@endif
									@endif									
								@elseif(is_array($summary) && isset($summary[$row]))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!$summary[$row]!!}
										@else
											({!!number_format($summary[$row],2,'.',',')!!})
										@endif
									@else
										@if($row == 'quantity')
											{!!$summary[$row]!!}
										@else
											{!!number_format($summary[$row],2,'.',',')!!}
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
				<th colspan="3">Generated By: {{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>				
			</tr>
			<tr>
				<th colspan="3">Date Generated: {{date("F j, Y g:i A")}}</th>
			</tr>
		</tbody>
	</table>		
</body>
</html>