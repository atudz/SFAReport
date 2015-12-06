<?php

Html::macro('input', function($type, $name, $label, $placeholder='') {

	$options = [
		'placeholder'=>$placeholder,
		'class' => 'form-control',	
		'id' => $name
	];

	$html = '<div class="form-group form-group-sm">
			 	<label for="'.$name.'" class="col-sm-3 control-label">'.$label.'</label>
			 	<div class="col-sm-6">'.
			 		Form::input($type, $name, null, $options) .
			 '	</div>
			 </div>';
	
	return $html;
});