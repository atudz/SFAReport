<?php

Html::macro('input', function($type, $name, $label, $placeholder='', $attributes=[]) {

	$options = [
		'placeholder'=>$placeholder,
		'class' => 'form-control',	
		'id' => $name
	];
	
	if($attributes)
		$options = $options + $attributes;

	$html = '<div class="form-group">
			 	<label for="'.$name.'" class="col-xs-12 col-md-5 col-sm-5 control-label">'.$label.'</label>
			 	<div class="col-xs-12 col-sm-6">'.
			 		Form::input($type, $name, null, $options) .
			 '	</div>
			 </div>';
	
	return $html;
});