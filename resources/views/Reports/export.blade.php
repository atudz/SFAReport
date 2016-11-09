<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
	<table>
		<tbody>
			<tr>
				@foreach($columns as $column)
					<th>{{$column['name']}}</th>
				@endforeach
			</tr>
			@foreach($records as $record)
				<tr>
					@foreach($rows as $row)
						<td>{{str_replace(array('%','(',')', ','),'', $record->$row)}}</td>
					@endforeach
				</tr>
			@endforeach
		</tbody>
	</table>
</body>
</html>