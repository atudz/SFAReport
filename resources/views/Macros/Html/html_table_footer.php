<?php

Html::macro('tfooter', function($noRecords, $colspan=1, $text='No records found.', $options=[]) {
	
	$html = '
			<tfoot id="no_records_div" style="display:none">
				<tr>
					<td colspan="'.$colspan.'"><p class="text-left">'.$text.'</p></td>
				</tr>
			</tfoot>
			';
	return $html;
});