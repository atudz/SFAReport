<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>		
		
		.container {
			width: 720px;
			height: auto;
			font-size: 12px;
		}
			
		.table {
			padding: 10px; 10px;
		}	
		
		.bold {
			font-weight: bold;
		}
		
	    table, th, td {
			border: 1px solid black;
			word-wrap: break-word;	
			font-size: 12px;		
			border-collapse: collapse;
		} 
		
		tr.details {
			text-align: center;
		}
		
		tr.footer {
			text-align: center;
		}
		
		.header {
			@if(count($shortages) || count($overages))
				margin-left: 80px;
			@endif
			padding: 10px 10px;
			word-wrap: break-word;
			text-align: center;
			display: inline-block;
			width: @if(count($shortages) || count($overages)) 515px @else 100% @endif;
		}
		
		.header > .company {
			padding-left: 15px;
			font-size: 25px;			
			font-weight: bold;
		}
		
		.header > .salesman {
			font-size: 12px;
			font-weight: bold;
			text-transform: uppercase;			
		}
		
		.header > .report {
			font-size: 12px;
			clear:both;		
		}
		
		.top-header {
			
		}
		
		.report-revision {
			padding-top: 10px;
			display: inline-block;
			vertical-align: top;
			width: 100px;
			word-wrap: break-word;
		}
		
		.charge {
			margin-top: 5px;
			padding: 10px 10px;
		}
		
		.row {			
			padding: 0px 5px;		
		}
		
		.row > .label{
			font-weight: bold;		
			display:inline-block;	
			width: 200px;
		}
		
		.row > .value{
			padding-left: 10px;
			font-weight: bold;
			display:inline-block;			
		}
		
		.signature {
			padding: 10px 10px;
		}
		
		.signature > .disclaimer {
			text-align:center;
		}
		
		.signature > .signature-block {
			padding: 5px 5px;			
		}
		
		.signature > .signature-block > .signee{
			display:inline-block;
			width: 225px;
		}
		
		.name {
			font-weight: bold;
			text-transform: uppercase;
		}
		
		.generated {
			padding: 10px 10px;
		}
		.generated > div {
			padding-top: 5px;
			font-weight: bold;
		}
		
		.item {
			width: 200px;
		}
		
		.space {
			width: 30px;
		}
		
		.total {
			vertical-align: bottom;
    		text-align: center;
		}
		.date {
			text-transform: uppercase;
		}
		
		.empty {
			padding: 40px 40px;
		}
		
		.empty > p {
			font-size: 30px;
			font-weight: bold;
			text-align: center;
		}
		
		.revision {
			text-align: right;
		}
	
		.signature-div{
			padding-top: 20px;
		}
		
	</style>
</head>
<body>
	<div class="container">
		<div class="top-header">
				
			<div class="header">
				<div class="company">
					SUNPRIDE FOODS, INC.
				</div>
				<div class="salesman">
					{{$salesman}} @if($jrSalesman)/ {{$jrSalesman}}@endif - {{$area}}								
				</div>
				<div class="report">
					STATEMENT OF SHORTAGES AND OVERAGES
				</div>
				<div class="report">{{$type}}</div>
				<div class="report date">
					PERIOD COVERED: {{format_date(Input::get('transaction_date_from'),'d M')}} TO {{format_date(Input::get('transaction_date_to'),'d M Y')}}
				</div>
			</div>	
			
			@if(count($overages) || count($shortages))
				<div class="report-revision">
					<div class="report">
						<div>REPORT# @if($ref){{$ref->reference_number}}@endif</div>
						{{-- <div>REV# @if($ref){{$ref->revision_number}}@endif</div> --}}
					</div>
				</div>		
			@endif
		</div>
		
		@if(count($overages) || count($shortages))
			<div class="table">
				<table>
					<thead>
						<tr>
							<th class="item">Item</th>
							<th>Stock On Hand</th>
							<th>Actual Count</th>
							<th>Short/Over Stocks</th>
							<th class="space">&nbsp;</th>
							<th>Unit Price</th>
							<th class="space">&nbsp;</th>
							<th>Total Amount per Item</th>
							<th>Total Amount</th>
						</tr>
					</thead>
					
					<tbody>
						<tr>
							<td>Overages:</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td rowspan="{{count($overages)+1}}" class="total">
								@if($overages)
									{{negate($overages->sum('total_amount'),true)}}
								@else
									0.00
								@endif
							</td>
						</tr>
						
						@foreach($overages as $over)
							<tr class="details">
								<td class="bold" align="left">{{$over['description']}}</td>
								<td>{{negate($over['stock_on_hand'])}}</td>
								<td>{{negate($over['actual_count'])}}</td>
								<td>{{negate($over['short_over'])}}</td>
								<td>x</td>
								<td>{{number_format($over['price'],2)}}</td>
								<td>=</td>
								<td>{{negate($over['total_amount'],true)}}</td>												
							</tr>
						@endforeach
						
						<tr>
							<td>Shortages:</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td class="total" rowspan="{{count($shortages)+1}}">
								@if($shortages)
									{{negate($shortages->sum('total_amount'),true)}}
								@else
									0.00
								@endif
							</td>
						</tr>
						
						@foreach($shortages as $short)
							<tr class="details">
								<td class="bold" align="left">{{$short['description']}}</td>
								<td>{{negate($short['stock_on_hand'])}}</td>
								<td>{{negate($short['actual_count'])}}</td>
								<td>{{negate($short['short_over'])}}</td>
								<td>x</td>
								<td>{{number_format($short['price'],2)}}</td>
								<td>=</td>
								<td>{{negate($short['total_amount'],true)}}</td>											
							</tr>
						@endforeach
						<tr class="footer">
							<?php
								$sumShortages = $shortages ? $shortages->sum('total_amount') : 0;								
								$sumOverages = $overages ? $overages->sum('total_amount') : 0;
							?>
							<td colspan="6">TOTAL STOCK @if(abs($sumShortages) > abs($sumOverages)) SHORTAGES @else OVERAGE @endif IN PESO VALUE</td>
							<td>Php</td>
							<td></td>
							<td class="bold">
							<?php
								$totalStockOverage = bcadd($sumOverages,$sumShortages,2);
								echo negate($totalStockOverage,true);
							?>
							</td>
						</tr>				
					</tbody>				
				</table>
			</div>
			
			@if($totalStockOverage < 0)
				<div class="charge">
					<div class="row">
						<div class="label">
							<label><i>Stock Shortage Charge to {{$salesman}} (60%)</i></label>
						</div>
						<div class="value">{{number_format(bcmul(abs($totalStockOverage),0.6,2),2)}}</div>
					</div>
					
					<div class="row">
						<div class="label">
							<label><i>Stock Shortage Charge to {{$jrSalesman}} (40%)</i></label>
						</div>
						<div class="value">{{number_format(bcmul(abs($totalStockOverage),0.4,2),2)}}</div>
					</div>
				</div>
			@endif
		@else		
			<div class="empty">
				<p>NO OVERAGES NOR SHORTAGES</p>
			</div>
		@endif
		
		<div class="signature">
			<div class="disclaimer">This is to certify that all facts and figures stated herein are true and correct.</div>
			<div class="signature-block">
				<div class="signee">
					<p>Audited:</p>
					<div class="signature-div">
						<div class="name">{{$auditor}}</div>
						<div>Auditor - {{$auditorArea}}</div>
					</div>
				</div>
				<div class="signee">	
					<p>Confirmed:</p>
					<div class="signature-div">
						<div class="name">{{$salesman}}</div>
						<div>Senior RDS - {{$area}}</div>
					</div>
				</div>
				@if($jrSalesman)
				<div class="signee">
					<p>Confirmed:</p>
					<div class="signature-div">
						<div class="name">{{$jrSalesman}}</div>
						<div>Junior RDS - {{$area}}</div>
					</div>
				</div>
				@endif
			</div>
		</div>
		
		<div class="generated">
			<div>Generated By: {{auth()->user()->fullname}}</div>
			<div>Date Generated: {{date("F j, Y g:i A")}}</div>
		</div>
	</div>			
</body>
</html>