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
			 	<div class="col-xs-12 col-md-4 col-sm-4 control-label">
			 		<label for="'.$name.'" class="">'.$label.'</label>
			 	</div>
			 	<div class="col-xs-12 col-sm-8">'.
			 		Form::input($type, $name, null, $options) .
			 '	<span class="error help-block"></span>
			 	</div>
			 </div>';
	
	return $html;
});