<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table>
		<tbody>
			<tr>
				<th colspan="19"></th>
				<th>SUNPRIDE FOODS, INC.</th>
				<th colspan="6"></th>											
			</tr>
			<tr>
				<th colspan="19"></th>
				<th>Sales & Collection Report</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th align="right">SCR No.:</th>
				@if($scr) 
					<th style="text-decoration: underline">{{$scr}}</th>
				@else 
					<th>__________</th>
				@endif				
			</tr>
			<tr>
				<th colspan="22"></th>
				<th></th>
				<th></th>
				<th align="right"><small>Period Covered</small></th>								
				<th></th>
				<th></th>
			</tr>
			<tr>
				<th colspan="22"></th>
				<th align="right">Salesman:</th>
				<th style="text-decoration: underline">{{$filters['Salesman']}}</th>
				<th align="right">Invoice date</th>								
				<th align="right">From:</th>
				<th @if(request()->get('invoice_date_from')) style="text-decoration: underline @endif ">
					@if(request()->get('invoice_date_from'))
						{{request()->get('invoice_date_from')}}
					@else
						______________
					@endif
				</th>
			</tr>
			<tr>
				<th colspan="22"></th>
				<th align="right">Salesman Code:</th>
				<th align="left" style="text-decoration: underline">{{request()->get('salesman')}}</th>
				<th></th>
				<th align="right">To:</th>
				<th @if(request()->get('invoice_date_from')) style="text-decoration: underline" @endif>
					@if(request()->get('invoice_date_from'))
						{{request()->get('invoice_date_to')}}
					@else
						______________
					@endif
				</th>											
			</tr>
			<tr>	
				<th colspan="22"></th>		
				<th align="right">Area Name:</th>
				<th align="left" style="text-decoration: underline">@if($area) {{$area}} @else ______________ @endif</th>
				<th align="right">Prev. Inv. date</th>
				<th align="right">From:</th>
				<th @if(request()->get('posting_date_from')) style="text-decoration: underline" @endif>
					@if(request()->get('posting_date_from'))
						{{request()->get('posting_date_from')}}
					@else
						______________
					@endif
				</th>											
			</tr>
			<tr>	
				<th colspan="22"></th>		
				<th></th>
				<th></th>
				<th></th>
				<th align="right">To:</th>
				<th @if(request()->get('posting_date_to')) style="text-decoration: underline" @endif>
					@if(request()->get('posting_date_to'))
						{{request()->get('posting_date_to')}}
					@else
						______________
					@endif
				</th>											
			</tr>
			<tr>	
				<th colspan="22"></th>	
				<th align="right">Date Remitted:</th>
				<th align="left">______________</th>
				<th align="right">Collection date</th>
				<th align="right">From:</th>
				<th @if(request()->get('collection_date_from')) style="text-decoration: underline" @endif>
					@if(request()->get('collection_date_from'))
						{{request()->get('collection_date_from')}}
					@else
						______________
					@endif
				</th>											
			</tr>
			<tr>	
				<th colspan="22"></th>		
				<th></th>
				<th></th>
				<th></th>
				<th align="right">To:</th>
				<th @if(request()->get('collection_date_to')) style="text-decoration: underline" @endif>
					@if(request()->get('collection_date_to'))
						{{request()->get('collection_date_to')}}
					@else
						______________
					@endif	
				</th>											
			</tr>
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
			@foreach($current as $record)
				<tr>
					@foreach($rows as $row)
						<td align="left" style="wrap-text:true">
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
					@endforeach
				</tr>
			@endforeach	
			
			@if(isset($currentSummary) && $currentSummary)
				<tr>
					<th>Total</th>
					@foreach($rows as $key=>$row)
						@if($key > 0)
							<th align="left" style="wrap-text:true">																
								@if(isset($currentSummary[$row]))
									{!!$currentSummary[$row]!!}									
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
				<th></th>
				<th></th>						
			</tr>
			
			<tr>
				<th align="right">Total Current Check:</th>
				<th>___________________</th>
				<th align="right">Cebu Receiving Clerk:</th>
				<th>___________________</th>				
			</tr>
			
			<tr>
				<th align="right">Total PDC Check:</th>
				<th>___________________</th>
				<th align="right">SFI Cashier:</th>
				<th>___________________</th>
						
			</tr>
			
			
			<tr>
				<th align="right">TOTAL COLLECTIONS:</th>
				<th>___________________</th>
				<th align="right">Salesman signature:</th>
				<th>___________________</th>						
			</tr>
			
			<tr>
				<th align="right">Less: Expenses</th>
				<th>___________________</th>
				<th align="right">Generated By:</th>
				<th style="text-decoration: underline">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>		
			</tr>
			<tr>
				<th align="right">NET COLLECTIONS:</th>
				<th>___________________</th>
				<th align="right">Generated on:</th>
				<th style="text-decoration: underline">{{date("F j, Y g:i A")}}</th>		
			</tr>
			
			<tr>				
				<th colspan="4"></th>		
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