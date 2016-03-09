<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table>
		<tbody>
			<tr>
				<th>SUNPRIDE FOODS, INC.</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>				
			</tr>
			<tr>
				<th>Sales & Collection Report</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th align="right">SCR No.:</th>
				<th>__________</th>				
			</tr>
			<tr>
				<th align="right">Salesman:</th>
				<th style="text-decoration: underline">{{$filters['Salesman']}}</th>
				<th align="right">Salesman Code:</th>
				<th style="text-decoration: underline">{{$filters['Salesman']}}</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>				
			</tr>
			<tr>
				<th align="right">Area Name:</th>
				<th style="text-decoration: underline">__________</th>
				<th align="right">Period Covered:</th>
				<th style="text-decoration: underline">{{request()->get('invoice_date_from')}}</th>
				<th align="right">To:</th>
				<th style="text-decoration: underline">{{request()->get('invoice_date_to')}}</th>
				<th align="right">Date Remitted:</th>
				<th>__________</th>				
			</tr>
		</tbody>
	</table>
	
	<table>		
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
	
	<table>
		<tbody>
			<tr>
				<th align="right">Total Cash:</th>
				<th>___________________</th>
				<th align="right">Generated By:</th>
				<th style="text-decoration: underline">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>		
			</tr>
			
			<tr>
				<th align="right">Total Current Check:</th>
				<th>___________________</th>
				<th align="right">Generated on:</th>
				<th style="text-decoration: underline">{{date("F j, Y g:i A")}}</th>		
			</tr>
			
			<tr>
				<th align="right">Total PDC Check:</th>
				<th>___________________</th>
				<th align="right">Cebu Receiving Clerk:</th>
				<th>___________________</th>		
			</tr>
			
			
			<tr>
				<th align="right">TOTAL COLLECTIONS:</th>
				<th>___________________</th>
				<th align="right">SFI Cashier:</th>
				<th>___________________</th>		
			</tr>
			
			<tr>
				<th align="right">Less: Expenses</th>
				<th>___________________</th>
				<th></th>
				<th></th>		
			</tr>
			<tr>
				<th align="right">NET COLLECTIONS:</th>
				<th>___________________</th>
				<th></th>
				<th></th>		
			</tr>
			
			<tr>
				<th align="right">REMARKS:</th>
				<th>______________________________________</th>
				<th></th>
				<th></th>		
			</tr>
			
		</tbody>
	</table>		
</body>
</html>