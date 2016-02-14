<?php

Html::macro('input', function($type, $name, $label, $placeholder='', $attributes=[]) {

	$options = [
		'placeholder'=>$placeholder,
		'class' => 'form-control',	
		'id' => $name
	];
	
	if($attributes)
		$options = $options + $attributes;

	$html = '<div class="form-group form-group-sm">
			 	<label for="'.$name.'" class="col-sm-3 control-label">'.$label.'</label>
			 	<div class="col-sm-6">'.
			 		Form::input($type, $name, null, $options) .
			 '	</div>
			 </div>';
	
	return $html;
});