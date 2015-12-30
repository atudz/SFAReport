<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<!-- <link rel="stylesheet" href="{{ URL::asset('js/components/packages/bootstrap/dist/css/bootstrap.min.css') }}" /> -->
	<style>
		.table-bordered>tbody>tr>td,
		.table-bordered>tbody>tr>th, 
		.table-bordered>tfoot>tr>td, 
		.table-bordered>tfoot>tr>th, 
		.table-bordered>thead>tr>td, 
		.table-bordered>thead>tr>th {
    			border: 1px solid black;
		}
		table {
    		border-spacing: 0;
    		border-collapse: collapse;
    		font-size: 12px;
    		/* min-width: 250px; */
    		/* max-width: 500px; */
    		/* table-layout:fixed; */
		}
	</style>
</head>
<body>
	<table class="table table-bordered table-condensed">		
		<tbody>
			<tr>
				@foreach($columns as $column)
					<th>{{$column['name']}}</th>
				@endforeach
			</tr>
			@foreach($records as $record)
				<tr>
					@foreach($rows as $row)
						<td>
							@if(is_object($record) && isset($record->$row))
								{!!$record->$row!!}
							@elseif(is_array($record) && isset($record[$row]))
								{!!$record[$row]!!}	
							@endif
						</td>
					@endforeach
				</tr>
			@endforeach				
		</tbody>
	</table>
</body>
</html>