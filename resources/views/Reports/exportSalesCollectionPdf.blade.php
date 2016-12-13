<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		
		@page { margin: 0in; }
		
		body {
			font-size: 12px;	
			margin: 0.5in 0.10in;
		}
		
		table.no-border {
    		border-collapse: collapse;
    		font-size: 12px;
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
			font-size: 12px;		
						
		}
		
		.records {
			 margin: auto;
    		 width: 65%;
		}
		
		.page-header > tbody > tr > th {
			width: 70px;
		}
		
		.pull-right {
			float: right;
		}
		
		.indent-right {
			text-align: right;
		}
		
		.row {
			width: 220px;
			height: 20px;	
			word-wrap: break-word;		
		}
		
		.row-company {
			width: 368px;
			height: 20px;			
			word-wrap: break-word;
		}
		
		.label {
			font-weight: bold;
			font-size: 12px;
		}
		
		.label-value {
			font-size: 11px;
		}
		
		.value {
			font-weight: bold;
			text-decoration: underline;			
		}
		
		.clear {
			clear: both;
		}
		
		.underline{
			text-decoration: underline;
		}
		
		.push-left {
			padding-right: 5px;
		}
		.title {
			 text-align: right;
		}
		.header {
			clear:both;
			overflow: auto;
		}
	</style>
</head>
<body>
	<table class="no-border" width="1855px;">
			<tr align="right">
				<td width="20%"></td>
				<td width="30%" valign="top" style="padding-right:80px;">
					<div class="title">
						<strong>SUNPRIDE FOODS, INC.</strong>
						<br />
						<strong>Sales & Collections Report</strong>		
					</div>
				</td>
				<td width="50%" valign="top" align="right">
					<table class="no-border" style="font-size:11px;">
						<tbody>
							<tr>
								<td align="left"></td>
								<td align="right">
									<strong>SCR No.:</strong>@if($scr) <span class="value">{{$scr}}</span> @else ______________ @endif
								</td>								
							</tr>
							<tr>
								<td align="left">
									<strong>Salesman:</strong><span class="underline">@if($filters['Salesman']) {{$filters['Salesman']}} @else ______________ @endif</span>									
								</td>
								<td align="right">
									<strong>Invoice Date</strong>&nbsp;&nbsp;&nbsp;FROM: <span @if(request()->get('invoice_date_from'))class="underline"@endif>@if(request()->get('invoice_date_from')) {{request()->get('invoice_date_from')}} @else __________ @endif</span>
								</td>								
							</tr>
							<tr>							
								<td align="left">
									<strong>Salesman Code:</strong><span class="underline">@if(request()->get('salesman')) {{request()->get('salesman')}} @else ______________ @endif</span>									
								</td>
								<td align="right">
									TO: <span @if(request()->get('invoice_date_to'))class="underline"@endif>@if(request()->get('invoice_date_to')) {{request()->get('invoice_date_to')}} @else __________ @endif</span>
								</td>								
							</tr>
							
							<tr>							
								<td align="left">
									<strong>Area Name:</strong><span class="underline">@if($area) {{$area}} @else ______________ @endif</span>									
								</td>
								<td align="right">
									<strong>Previous Inv. Date</strong>&nbsp;&nbsp;&nbsp;FROM: <span class="@if(request()->get('posting_date_from')) underline @endif">@if(request()->get('posting_date_from')) {{request()->get('posting_date_from')}} @else __________ @endif</span>
								</td>								
							</tr>
							
							<tr>							
								<td align="left"></td>
								<td align="right">									
									&nbsp;TO: <span @if(request()->get('posting_date_to')) class="underline" @endif>@if(request()->get('posting_date_to')) {{request()->get('posting_date_to')}} @else __________ @endif</span>														
								</td>								
							</tr>
							
							<tr>							
								<td align="left">
									<strong>Date Remitted:</strong><span>__________</span>
								</td>
								<td align="right">									
									<strong>Collection Date</strong>&nbsp;&nbsp;&nbsp;FROM: <span class="@if(request()->get('collection_date_from')) underline @endif">@if(request()->get('collection_date_from')) {{request()->get('collection_date_from')}} @else __________ @endif</span>														
								</td>								
							</tr>
							
							<tr>							
								<td align="left"></td>
								<td align="right">									
									&nbsp;TO: <span @if(request()->get('collection_date_to')) class="underline" @endif>@if(request()->get('collection_date_to')) {{request()->get('collection_date_to')}} @else __________ @endif</span>														
								</td>								
							</tr>
						</tbody>
					</table>					
				</td>
			</tr>
	</table>
	<br>
	<table class="table-data">
		<thead>
		@if($theadRaw)
			{!!$theadRaw!!}
		@else
			<tr>
				@foreach($columns as $column)
					<th align="center" style="wrap-text:true">{!!$column['name']!!}</th>
				@endforeach
			</tr>
		@endif
		</thead>
		<tbody>
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
	
	
	<br><br>
	<table class="no-border">
		<tbody>
			<tr>
				<th align="right">Total Cash:</th>
				<th align="left">___________________</th>
				<th></th>
				<th></th>		
			</tr>
			
			<tr>
				<th align="right">Total Current Check:</th>
				<th align="left">___________________</th>
				<th align="right">Cebu Receiving Clerk:</th>
				<th align="left">___________________</th>		
			</tr>
			
			<tr>
				<th align="right">Total PDC Check:</th>
				<th align="left">___________________</th>					
				<th align="right">SFI Cashier:</th>
				<th align="left">___________________</th>	
			</tr>
			
			
			<tr>
				<th align="right">TOTAL COLLECTIONS:</th>
				<th align="left">___________________</th>
				<th align="right">Salesman signature:</th>
				<th align="left">___________________</th>		
			</tr>
			
			<tr>
				<th align="right">Less: Expenses</th>
				<th align="left">___________________</th>
				<th align="right">Generated By:</th>
				<th align="left" style="text-decoration: underline">{{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>		
			</tr>
			<tr>
				<th align="right">NET COLLECTIONS:</th>
				<th align="left">___________________</th>
				<th align="right">Generated on:</th>
				<th align="left" style="text-decoration: underline">{{date("m/d/Y g:i A")}}</th>		
			</tr>
			
			<tr>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>
				<th>&nbsp;</th>		
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