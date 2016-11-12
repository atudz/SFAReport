<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>		
		
		.container {
			width: 720px;
			height: auto;
			font-size: 12px;
		}
			
		table {
			padding-top: 10px;
			width: 100%;
		}	
		
		.filter {		
			width: 400px;
			display:inline-block;
		}
		
		.filter-row {			
			word-wrap: break-word;
			width: 100%;
			font-weight:bold;			
		}
		
		.filter-row  > .filter-name {
			display:inline-block;
			width: 30%;
		}
		
		.filter-row > .filter-value {
			display:inline-block;
			width: 65%;
		}
		
		.quantity {
			text-align: center;
		}
		
		.report-revision {
			    padding-top: 10px;
			    display: inline-block;
			    vertical-align: bottom;
			    word-wrap: break-word;
			    text-align: right;
			    width: 315px;
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
		
		.header {
			margin-left: 80px;			
			padding: 10px 10px;
			word-wrap: break-word;
			text-align: center;
			display: inline-block;
			width: 100%;
		}		
		
		.top-header {
			margin-top:20px;
			margin-bottom: 10px;
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
		.generated {
			padding: 10px 0px;
		}
		.generated > div {
			padding-top: 5px;
			font-weight: bold;
		}
	
		.signature-div{
			padding-top: 20px;
			font-weight:bold;
		}
		
		.empty > p {
			font-size: 30px;
			font-weight: bold;
			text-align: center;
		}
		
	</style>
</head>
<body>
	<div class="container">
		<div class="top-header">				
			<div class="filter">	
				<div class="filter-row">
					<div class="filter-name">Salesman Name:</div>
					<div class="filter-value">{{$replenishment->salesman}}</div>					
				</div>			
				<div class="filter-row">
					<div class="filter-name">Junior Salesman:</div>
					<div class="filter-value">{{$replenishment->jr_salesman}}</div>					
				</div>
				<div class="filter-row">
					<div class="filter-name">Van Code: </div>
					<div class="filter-value">{{$replenishment->van_code}}</div>					
				</div>
				<div class="filter-row">
					<div class="filter-name">Count date:</div>
					<div class="filter-value">@if($replenishment->replenish_date) {{format_date($replenishment->replenish_date,'m/d/Y g:i A')}} @endif</div>					
				</div>
				<div class="filter-row">
					<div class="filter-name">Count Sheet No:</div>
					<div class="filter-value">@if($replenishment->replenish){{$replenishment->replenish->reference_num}} @endif</div>					
				</div>
			</div>	
			
			<div class="report-revision">
					<div class="report">
						<div>REPORT#{{latest_revision('vaninventory')}}</div>
						<div>REV#{{latest_revision('vaninventory')}}</div>
					</div>
			</div>					
		</div>
		
		@if($replenishment->items)
			<div>
				<table>
					<thead>
						<tr>
							<th>Material Code</th>
							<th>Material Description</th>
							<th>Total Qty</th>							
						</tr>
					</thead>
					
					<tbody>
						@foreach($replenishment->items as $item)
						<tr>							
							<td>{{$item->item_code}}</td>
							<td>{{$item->description}}</td>
							<td class="quantity">{{$item->quantity}}</td>
						</tr>
						@endforeach									
					</tbody>				
				</table>
			</div>			
		@else		
			<div class="empty">
				<p>No items</p>
			</div>
		@endif
		
		<div class="signature">			
			<div class="signature-block">
				<div class="signee">
					<p>Counted:</p>
					<div class="signature-div">
						<div class="name">@if($replenishment->replenish) {{$replenishment->replenish->counted}} @endif</div>						
					</div>
				</div>
				<div class="signee">	
					<p>Confirmed:</p>
					<div class="signature-div">
						<div class="name">@if($replenishment->replenish){{$replenishment->replenish->confirmed}} @endif</div>
					</div>
				</div>
				@if(true)
				<div class="signee">
					<p>Confirmed:</p>
					<div class="signature-div">
						<div class="name">@if($replenishment->replenish){{$replenishment->jr_salesman}} @endif</div>
					</div>
				</div>
				@endif
			</div>
		</div>
		
		<div class="filter">
			<div class="filter-row">LAST USED DOCUMENTS / RECEIPTS :</div>
			<div class="filter-row">
				<div class="filter-name">LAST SR:</div>
				<div class="filter-value">@if($replenishment->replenish) {{$replenishment->replenish->last_sr}} @endif</div>					
			</div>			
			<div class="filter-row">
				<div class="filter-name">LAST RPRR:</div>
				<div class="filter-value">@if($replenishment->replenish) {{$replenishment->replenish->last_rprr}} @endif</div>					
			</div>
			<div class="filter-row">
				<div class="filter-name">LAST CASH SLIP:</div>
				<div class="filter-value">@if($replenishment->replenish) {{$replenishment->replenish->last_cs}} @endif</div>					
			</div>
			<div class="filter-row">
				<div class="filter-name">LAST DR:</div>
				<div class="filter-value">@if($replenishment->replenish) {{$replenishment->replenish->last_dr}} @endif</div>					
			</div>
			<div class="filter-row">
				<div class="filter-name">LAST DDR:</div>
				<div class="filter-value">@if($replenishment->replenish) {{$replenishment->replenish->last_ddr}} @endif</div>					
			</div>
		</div>
		
		<div class="generated">
			<div>Generated By: {{auth()->user()->fullname}}</div>
			<div>Date Generated: {{date("F j, Y g:i A")}}</div>
		</div>
	</div>			
</body>
</html>