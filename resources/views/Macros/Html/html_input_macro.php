<?php

Html::macro('input', function($type, $name, $label, $value='', $attributes=[]) {

	$options = [		
		'class' => 'form-control',	
		'id' => $name
	];
	
	if($attributes)
		$options = $options + $attributes;

	$hint = '';
	if(isset($attributes['hint']))
		$hint = '<span class="">'.$attributes['hint'].'</span>';
	$html = '<div class="form-group">
			 	<div class="col-xs-12 col-md-4 col-sm-4 control-label">
			 		<label for="'.$name.'" class="">'.$label.'</label>
			 	</div>
			 	<div class="col-xs-12 col-sm-8">'.
			 		Form::input($type, $name, $value, $options) .
			 '	<span class="error help-block"></span>
			 '.$hint.'
			 	</div>
			 </div>';
	
	return $html;
});