<?php

/**
 * Macro template for checkbox
 */
Form::macro('formCheckbox', function($name,$label=null,$value=1,$checked=false,$additions=[]){

	$openDiv = '<div class="checkbox">';
	$input = '<label>'.Form::checkbox($name, $value, $checked, $additions).$label.'</label>';
	$closeDiv = '</div>';
	$html = $openDiv.$input.$closeDiv;
	return $html;
});