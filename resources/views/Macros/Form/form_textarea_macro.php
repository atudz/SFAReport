<?php

/**
 * Macro template for text area
*/
Form::macro('formTextarea', function($name,$value=null,$label=null){

	$openDiv = '<div class="form-group">';
	$labelTag  = ($label) ? Form::label($name,$label) : '';
	$default = Form::old($name) ? Form::old($name) : $value;
	$textarea = Form::textarea( $name, $default, ['class'=>'form-control']);
	$closeDiv = '</div>';
	$html = $openDiv.$labelTag.$textarea.$closeDiv;
	return $html;
});