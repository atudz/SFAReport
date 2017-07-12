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
			@if(!empty($reference_number))
				<tr>
					<td><strong style="color: #F9243F;">Reference #:</strong> </td>
					<td style="color: #F9243F;">{{ $reference_number }}</td>
				</tr>
			@endif
			@if(!empty($revision_number))
				<tr>
					<td><strong style="color: #F9243F;">Revision #:</strong></td>
					<td style="color: #F9243F;">{{ $revision_number }}</td>
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
								@if($row == 'from' && $report == 'stockaudit')
									{{ format_date($record->from, 'M d') }} - {{ format_date($record->to, 'M d Y') }} 
								@elseif(false !== strpos($row,'date') && $record->$row)
									@if($report == 'stocktransfer' || ($report == 'bouncecheck' && $row == 'invoice_date'))
										{{ date('m/d/Y g:i A', strtotime($record->$row)) }}									
									@else
										{{ $record->$row }}
									@endif
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!str_replace(array('%',')','(', ','),'', $record->$row)!!}	
								@elseif(ctype_alnum($record->$row))
									{!!strtoupper($record->$row)!!}
								@else
									{!!str_replace(array('%',')','(', ','),'', $record->$row)!!}
								@endif
							@elseif(is_array($record) && isset($record[$row]))
								@if($row == 'from' && $report == 'stockaudit')
									{{ format_date($record['from'], 'M d') }} - {{ format_date($record['to'], 'M d Y') }}
								@elseif(false !== strpos($row,'date') && $record[$row])
									@if($report == 'stocktransfer' || ($report == 'bouncecheck' && $row == 'invoice_date'))
										{{ date('m/d/Y g:i A', strtotime($record[$row])) }}
									@else	
										{{ $record[$row] }}
									@endif
								@elseif(false !== strpos($record[$row],'.') && is_numeric($record[$row]))	
									{!!str_replace(array('%',')','(', ','),'', $record[$row])!!}	
								@elseif(ctype_alnum($record[$row]))
									{!!strtoupper($record[$row])!!}
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

				@if(isset($report) && $report == 'salescollectionsummary' && $summary->added_updates)
					@foreach($summary->added_updates as $update)
						<tr>
							<td colspan="3" style="color: #F9243F;"> {{ $update->remarks }} </td>
							<td align="left" style="color: #F9243F;"> {{ number_format($update->total_collected_amount,2,'.',',') }}</td>
							<td align="left" style="color: #F9243F;"> {{ number_format($update->sales_tax,2,'.',',') }}</td>
							<td align="left" style="color: #F9243F;"> {{ number_format($update->amount_for_commission,2,'.',',') }}</td>
						</tr>
					@endforeach
					<tr>
						<th style="color: #F9243F;">Total</th>
						<th></th>
						<th></th>
						<th align="left" style="color: #F9243F;">{{ number_format($summary->updated_total_collected_amount,2,'.',',') }}</th>
						<th align="left" style="color: #F9243F;">{{ number_format($summary->updated_sales_tax,2,'.',',') }}</th>
						<th align="left" style="color: #F9243F;">{{ number_format($summary->updated_amount_for_commission,2,'.',',') }}</th>
					</tr>
				@endif
			@endif			
		</tbody>
	</table>
	
	<table>
		<tbody>
			@if(isset($report) && $report == 'salescollectionsummary' && $summary->added_notes)
				@foreach($summary->added_notes as $note)
					<tr>
						<td colspan="3">{{ $note->notes }}</td>
					</tr>
				@endforeach
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