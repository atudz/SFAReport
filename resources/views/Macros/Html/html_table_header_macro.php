<?php

Html::macro('theader', function(array $headers, $options = []) {

	$html = '<thead>
				<tr>';

	if((array_key_exists('show_mass_edit_button', $options) && $options['show_mass_edit_button'])){
		$html .= '<th>Select All <br/> <input type="checkbox" style="margin: 0 auto; display: block;" ng-click="checkAll()" ng-disabled="records.length == 0"></th>';
	}

	foreach($headers as $header)
	{
		if((array_key_exists('can_sort', $options) && $options['can_sort']) && isset($header['sort']))
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