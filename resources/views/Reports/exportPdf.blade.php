<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		
		body {
			font-size: {{$textSize}};
		}
		
		table.no-border {
    		border-collapse: collapse;
    		font-size: {{$textSize}};
		}		
		table.no-border,
		.no-border th,
		.no-border td {
			border: 1px solid white;
			word-wrap: break-word;			
		}
		
		table.table-data {
			width: 100%;
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
    		 width: auto;
		}
		.records {
			 margin: auto;
    		 width: 65%;
		}
		
		.revision {
			font-size: {{$fontSize}};
		}
		
		.rev-label {
			padding: 3px 3px;
		}
		.clear {
			clear: both;
		}
		
	</style>
</head>
<body>
	@if(isset($report) && $report == 'salescollectionsummary')
		<div class="title" align="left">		
			@if(isset($header))
				<h3>{{$header}}</h3>			
			@endif
		</div>
	@else
		<div class="title" align="center">		
			@if(isset($header))
				<h3>{{$header}}</h3>			
			@endif
		</div>
	@endif
	@if(!empty($reference_number))
		<div style="text-align: right; color: #F9243F;">
			<strong>Reference #:</strong> {{ $reference_number }}
		</div>
	@endif
	@if(!empty($revision_number))
		<div style="text-align: right; color: #F9243F;">
			<strong>Revision #:</strong> {{ $revision_number }}
		</div>
	@endif
	<table class="no-border clear">
			<tbody>												
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
	<br>
	<div >
	<table class="table-data">
		<thead>
		@if($theadRaw)
			{!!$theadRaw!!}
		@else
			<tr>
				@foreach($columns as $column)
					<th align="left" >{!!$column['name']!!}</th>
				@endforeach
			</tr>
		@endif
		</thead>
		<tbody>
		@foreach($records as $record)
			<tr>
				@foreach($rows as $row)
					<td align="left" style="wrap-text:true">
						<?php
							if(in_array($row,['value','before','comment']) && strlen($record->$row) > 25)
							{
								$record->$row = wordwrap($record->$row,25,'<br>',true);								
							}
						?>
						@if(is_object($record) && isset($record->$row))
							@if($row == 'from' && $report == 'stockaudit')
								{{ format_date($record->from, 'M d') }} - {{ format_date($record->to, 'M d Y') }}							
							@elseif(false !== strpos($row,'date') && $record->$row)
								@if($report == 'bir')
									{{ $record->$row }}
								@elseif($report == 'stocktransfer' || ($report == 'bouncecheck' && $row == 'invoice_date'))
									{{ date('m/d/Y g:i A', strtotime($record->$row)) }}									
								@else
									{{ date('m/d/Y', strtotime($record->$row)) }}
								@endif								
							@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))
								{!!number_format($record->$row,2,'.',',')!!}
							@else
								{!!$record->$row!!}
							@endif
						@elseif(is_array($record) && isset($record[$row]))
							@if($row == 'from' && $report == 'stockaudit')
									{{ format_date($record['from'], 'M d') }} - {{ format_date($record['to'], 'M d Y') }}
							@elseif(false !== strpos($row,'date') && $record[$row])
								@if($report == 'bir')
									{{ $record[$row] }}
								@elseif($report == 'stocktransfer' || ($report == 'bouncecheck' && $row == 'invoice_date'))
									{{ date('m/d/Y g:i A', strtotime($record[$row])) }}
								@else	
									{{ date('m/d/Y', strtotime($record[$row])) }}
								@endif
							@elseif(false !== strpos($record[$row],'.') && is_numeric($record[$row]))
								{!!number_format($record[$row],2,'.',',')!!}
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
									@if(in_array($row,['quantity','regular_order_qty','trade_order_qty']))
										{!!$summary->$row!!}
									@else
										({!!number_format($summary->$row,2,'.',',')!!})
									@endif
								@else
									@if(in_array($row,['quantity','regular_order_qty','trade_order_qty']))
										{!!$summary->$row!!}
									@else
										{!!number_format($summary->$row,2,'.',',')!!}
									@endif
								@endif
							@elseif(is_array($summary) && isset($summary[$row]))
								@if(in_array($row,['discount_amount','collective_discount_amount']))
									@if(in_array($row,['quantity','regular_order_qty','trade_order_qty']))
										{!!$summary[$row]!!}
									@else
										({!!number_format($summary[$row],2,'.',',')!!})
									@endif
								@else
									@if(in_array($row,['quantity','regular_order_qty','trade_order_qty']))
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
			@if(isset($report) && $report == 'salescollectionsummary' && $summary->added_updates)
				@foreach($summary->added_updates as $update)
					<tr>
						<td colspan="3" style="color: red;"> {{ $update->remarks }} </td>
						<td style="color: red;">{{ number_format($update->total_collected_amount,2,'.',',') }}</td>
						<td style="color: red;">{{ number_format($update->sales_tax,2,'.',',') }}</td>
						<td style="color: red;">{{ number_format($update->amount_for_commission,2,'.',',') }}</td>
					</tr>
				@endforeach
				<tr>
					<th style="color: red;">Total</th>
					<th></th>
					<th></th>
					<th style="color: red; text-align: left;">{{ number_format($summary->updated_total_collected_amount,2,'.',',') }}</th>
					<th style="color: red; text-align: left;">{{ number_format($summary->updated_sales_tax,2,'.',',') }}</th>
					<th style="color: red; text-align: left;">{{ number_format($summary->updated_amount_for_commission,2,'.',',') }}</th>
				</tr>
			@endif
		@endif
		</tbody>
	</table>
	</div>
	<br>

	@if(isset($report) && $report == 'salescollectionsummary' && $summary->added_notes)
		<ul>
			@foreach($summary->added_notes as $note)
				<li>{{ $note->notes }}</li>
			@endforeach
		</ul>
	@endif

	<table class="no-border">
		<tbody>
			<tr align="left">
				<th colspan="3">Generated By: {{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>				
			</tr>
			<tr align="left">
				<th colspan="3">Date Generated: {{date("F j, Y g:i A")}}</th>
			</tr>
		</tbody>
	</table>		
</body>
</html>