<?php

Html::macro('theader', function(array $headers, $showFilter=false) {

	$html = '<thead>';
	if($showFilter)
	{
		$html.= '<tr>
					<th colspan="5">
						<div class="form-group col-sm-6 form-group-sm filter">
					        <div class="inner-addon right-addon">
					          <i class="glyphicon glyphicon-search"></i>
					          <input type="text" st-search="" class="form-control" placeholder="Search" />
					        </div>
		      			</div>
					</th>
				</tr>';
	}
	
	$html .=  ' <tr>';
	foreach($headers as $header)
	{
		$html .= '<th'.Html::attributes(array_except($header, ['name'])).'>'.$header['name'].'</th>';	
	}
	
	$html .= '	</tr>
			   <thead>';

	return $html;
});