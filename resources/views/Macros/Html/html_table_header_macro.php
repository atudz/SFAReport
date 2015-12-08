<?php

Html::macro('theader', function(array $headers) {

	$html = '<thead>
				<tr>';
	foreach($headers as $header)
	{
		$html .= '<th'.Html::attributes(array_except($header, ['name'])).'>'.$header['name'].'</th>';	
	}
	
	$html .= '	</tr>
			   <thead>';

	return $html;
});