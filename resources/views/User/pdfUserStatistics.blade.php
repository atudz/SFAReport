<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
	<h1 style="text-align: center; margin: 0 0 20px; font-family: 'Arial';">User Statistics Profile</h1>
	<div style="overflow : visible;">
		<div style="width: 50%; float:left;">
			<h2 style="text-align: center; margin: 0 0 15px;">Personal Information</h2>
			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Name:  <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ $user_info['firstname'] . ' ' . (!empty($user_info['middlename']) ? ($user_info['middlename'] . ' ' . $user_info['lastname']) : $user_info['lastname']) }}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Email: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ $user_info['email'] }}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Username: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ $user_info['username'] }}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Gender: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ $user_info['gender'] }}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Age: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ $user_info['age'] }}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Address: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ !empty($user_info['address1']) ? $user_info['address1'] : '-'}}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Telephone No.: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ !empty($user_info['telephone']) ? $user_info['telephone'] : '-'}}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Mobile No.: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ !empty($user_info['mobile']) ? $user_info['mobile'] : '-'}}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Salesman Code: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ !empty($user_info['salesman_code']) ? $user_info['salesman_code'] : '-'}}</span></h3>

			<h2 style="text-align: center; margin: 0 0 15px;">Access & Location</h2>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Role: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ $user_info['role'] }}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Branch: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ $user_info['branch'] }}</span></h3>

			<h3 style="margin: 0 0 25px; font-family: 'Arial';">Assignment: <span style="font-size: 16px; font-family: 'Arial'; font-weight: normal;">{{ $user_info['assignment_type'] }}</span></h3>
		</div>
		<div style="width: 50%; float:left;">
			<div style="width: 400px; height: 400px;">
				<img id="chart-image-div" src="data:image/png;base64,{{ $image_string }}" alt="">
			</div>
		</div>
	</div>
	<h4 style="position: absolute; bottom: 0;">Date Generated: {{ date('F j,Y g:i:s A') }}</h4>
</body>
</html>