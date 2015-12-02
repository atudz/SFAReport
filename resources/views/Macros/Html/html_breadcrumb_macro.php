<?php

Html::macro('breadcrumb', function(array $links) {

	$html = '<div class="row">
			<ol class="breadcrumb">
			<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>';

	foreach($links as $link)
	{
		$html .= '<li class="active">'.$link.'</li>';
	}		
	
	$html .= '</ol></div>';
	
	return $html;
});