<?php

Html::macro('select', function($name, $label, $list=[], $default='All') {

	$options = [
		'class' => 'form-control'	
	];
	
	$list = array_merge([$default], $list);
	$html = '<div class="form-group form-group-sm">
			 	<label for="'.$name.'" class="col-sm-3 control-label">'.$label.'</label>
			 	<div class="col-sm-6">'.
			 		Form::select($name, $list, null, $options).
			 '	</div>
			 </div>';

	return $html;
});