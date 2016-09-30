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
						<td align="left">{{str_replace(array('%',')','(', ','),'', $val)}}</td>
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
								@if(false !== strpos($row,'date') && $record->$row)
									{{ date('m/d/Y', strtotime($record->$row)) }}
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!str_replace(array('%',')','(', ','),'', $record->$row)!!}	
								@elseif(ctype_alnum($record->$row))
									{!!str_replace(array('%',')','(', ','),'', strtoupper($record->$row))!!}
								@else
									{!!str_replace(array('%',')','(', ','),'', $record->$row)!!}
								@endif
							@elseif(is_array($record) && isset($record[$row]))
								@if(false !== strpos($row,'date') && $record[$row])
									{{ date('m/d/Y', strtotime($record[$row])) }}
								@elseif(false !== strpos($record[$row],'.') && is_numeric($record[$row]))	
									{!!str_replace(array('%',')','(', ','),'', $record[$row])!!}	
								@elseif(ctype_alnum($record[$row]))
									{!!str_replace(array('%',')','(', ','),'', strtoupper($record[$row]))!!}
								@else
									{!!str_replace(array('%',')','(', ','),'', $record[$row])!!}
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
											{!!str_replace(array('%',')','(', ','),'', $summary->$row)!!}
										@else
											{!!str_replace(array('%',')','(', ','),'', $summary->$row)!!}
										@endif
									@else
										@if($row == 'quantity')
											{!!str_replace(array('%',')','(', ','),'', $summary->$row)!!}
										@else
											{!!str_replace(array('%',')','(', ','),'', $summary->$row)!!}
										@endif
									@endif									
								@elseif(is_array($summary) && isset($summary[$row]))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!str_replace(array('%',')','(', ','),'', $summary[$row])!!}
										@else
											{!!str_replace(array('%',')','(', ','),'', $summary[$row])!!}
										@endif
									@else
										@if($row == 'quantity')
											{!!str_replace(array('%',')','(', ','),'', $summary[$row])!!}
										@else
											{!!str_replace(array('%',')','(', ','),'', $summary[$row])!!}
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
				@if(in_array($report,['vaninventorycanned','vaninventoryfrozen']))
					<th colspan="3">Date Generated: {{date("m/d/Y g:i A")}}</th>
				@else
					<th colspan="3">Date Generated: {{date("F j, Y g:i A")}}</th>
				@endif
			</tr>
		</tbody>
	</table>		
</body>
</html>