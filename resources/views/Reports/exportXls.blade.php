<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table>		
		<tbody>
			<tr>
				@foreach($columns as $column)
					<th>{!!$column['name']!!}</th>
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