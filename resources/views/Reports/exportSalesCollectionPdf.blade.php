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
	<strong>&nbsp;SUNPRIDE FOODS, INC.</strong><br>
	<table class="no-border">
		<tbody>
			<tr>
				<th>Sales & Collection Report</th>
				<th colspan="35"></th>
				<th align="right">SCR No.:</th>
				<th>__________</th>				
			</tr>
			<tr>
				<th colspan="38"></th>				
			</tr>
			<tr>
				<th colspan="38"></th>				
			</tr>
			<tr>
				<th align="right">Salesman:</th>
				<th align="left" style="text-decoration: underline">{{$filters['Salesman']}}</th>
				<th colspan="17"></th>
				<th align="right">Salesman Code:</th>
				<th align="left" style="text-decoration: underline">{{$filters['Salesman']}}</th>
				<th colspan="17"></th>				
			</tr>
			<tr>
				<th align="right">Area Name:</th>
				<th colspan="11" align="left" style="text-decoration: underline">__________</th>
				<th align="right">Period Covered:</th>
				<th colspan="11" align="left" style="text-decoration: underline">{{request()->get('invoice_date_from')}}</th>
				<th align="right">To:</th>
				<th colspan="11"align="left" style="text-decoration: underline">{{request()->get('invoice_date_to')}}</th>
				<th align="right">Date Remitted:</th>
				<th align="left" style="text-decoration: underline">{{date('m/d/Y')}}</th>				
			</tr>
		</tbody>
	</table>
	<br>
	<strong>SALES & COLLECTION: CURRENT TRANSACTION</strong>
	<table class="table-data">		
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
	
	<br>
	<strong>SALES & COLLECTION: PREVIOUS TRANSACTION</strong>
	<table class="table-data">		
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
	
	<br><br>
	<table class="no-border">
		<tbody>
			<tr>
				<th align="right">Total Cash:</th>
				<th align="left">___________________</th>
				<th align="right">Generated By:</th>
				<th align="left" style="text-decoration: underline">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>		
			</tr>
			
			<tr>
				<th align="right">Total Current Check:</th>
				<th align="left">___________________</th>
				<th align="right">Generated on:</th>
				<th align="left" style="text-decoration: underline">{{date("F j, Y g:i A")}}</th>		
			</tr>
			
			<tr>
				<th align="right">Total PDC Check:</th>
				<th align="left">___________________</th>
				<th align="right">Cebu Receiving Clerk:</th>
				<th align="left">___________________</th>		
			</tr>
			
			
			<tr>
				<th align="right">TOTAL COLLECTIONS:</th>
				<th align="left">___________________</th>
				<th align="right">SFI Cashier:</th>
				<th align="left">___________________</th>		
			</tr>
			
			<tr>
				<th align="right">Less: Expenses</th>
				<th align="left">___________________</th>
				<th align="left"></th>
				<th align="left"></th>		
			</tr>
			<tr>
				<th align="right">NET COLLECTIONS:</th>
				<th align="left">___________________</th>
				<th></th>
				<th></th>		
			</tr>
			
			<tr>
				<th align="right">REMARKS:</th>
				<th align="left">______________________________________</th>
				<th></th>
				<th></th>		
			</tr>
			
		</tbody>
	</table>		
</body>
</html>