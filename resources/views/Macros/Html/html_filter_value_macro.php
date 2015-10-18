<?php

Html::macro('filterValue', function($label,$value) {
	
	$label = '<div class="cell-label">'.$label.'</div>';
	$values = '<div class="cell-input">'.$value.'</div>';
	
	return $label.$values;
});