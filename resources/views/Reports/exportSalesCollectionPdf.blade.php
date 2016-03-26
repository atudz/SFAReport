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
		
		.page-header > tbody > tr > th {
			width: 150px;
		}
	</style>
</head>
<body>
	<strong>&nbsp;SUNPRIDE FOODS, INC.</strong><br>
	<table class="no-border page-header">
		<tbody>
			<tr>
				<th align="left">Sales & Collection Report</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>				
				<th align="right">SCR No.:</th>				
				@if($scr) 
					<th align="left" style="text-decoration: underline">{{$scr}}</th>
				@else 
					<th align="left">__________</th>
				@endif				
			</tr>						
			<tr>
				<th align="right">Salesman:</th>
				<th align="left" style="text-decoration: underline">{{$filters['Salesman']}}</th>
				<th align="right">Salesman Code:</th>
				<th align="left" style="text-decoration: underline">{{$filters['Salesman']}}</th>
				<th>&nbsp;</th>				
				<th>&nbsp;</th>				
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
			</tr>
			<tr>
				<th align="right">Area Name:</th>
				<th align="left" style="text-decoration: underline">__________</th>
				<th align="right">Period Covered:</th>
				<th align="left" style="text-decoration: underline">{{request()->get('invoice_date_from')}}</th>
				<th align="right">To:</th>
				<th align="left" style="text-decoration: underline">{{request()->get('invoice_date_to')}}</th>
				<th align="right">Date Remitted:</th>
				<th align="left" style="text-decoration: underline">{{date('m/d/Y')}}</th>				
			</tr>
		</tbody>
	</table>
	<br>
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
					@foreach($rows as $k=>$row)
						@if($record->show || (!$record->show && $k > 15 && $k < 26 ))						
						<td align="left" style="wrap-text:true" rowspan="@if($k < 16 || $k == 26) {{$record->rowspan}} @else 1 @endif">							
							@if(is_object($record) && isset($record->$row))
								@if(false !== strpos($row,'date') && $record->$row)
									{{ date('m/d/Y', strtotime($record->$row)) }}
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!number_format($record->$row,2,'.',',')!!}	
								@else
									{!!$record->$row!!}
								@endif
							@elseif(is_array($record) && isset($record[$row]))
								@if(false !== strpos($row,'date') && $record[$row])
									{{ date('m/d/Y', strtotime($record[$row])) }}
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!number_format($record->$row,2,'.',',')!!}	
								@else
									{!!$record[$row]!!}
								@endif									
							@endif
						</td>
						@endif						
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