<?php

Html::macro('theader', function(array $headers, $can_sort = false) {

	$html = '<thead>
				<tr>';
	foreach($headers as $header)
	{
		if($can_sort && isset($header['sort']))
		{
			$html .= '<th'.Html::attributes(array_except($header, ['name','sort'])).
					' class="sortable" ng-click="sort(\''.$header['sort'].'\')" id="'.$header['sort'].'">'.
					 $header['name'].
					 ' <i class="fa fa-sort"></i></span>';
		}						
		else
		{
			$html .= '<th'.Html::attributes(array_except($header, ['name','sort'])).'>'.$header['name'];
		}
		$html .= '</th>';	
	}
	
	$html .= '	</tr>
			</thead>';

	return $html;
});