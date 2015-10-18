<?php

/**
 * Macro template for checkbox
 */

Form::macro('formRadio', function($name,$options=[],$select=0,$label=null,$inline=true){
	
	$openDiv = '<div class="form-group">';
	if($label)
	{
		$openDiv .= '<label for="radio">'.$label.'</label>';
	}
	$openDiv .= '<div id="radio" class="radio">';
	$input = '';
	foreach($options as $option)
	{
		$checked = ($option['value'] == $select) ? true : false;
		$input .= '<label>'.Form::radio($name,$option['value'],$checked).$option['label'].'</label>';
		$input .= $inline ? '&nbsp;&nbsp;' : '<br>';
	}
	$closeDiv = '</div></div>';
	$html = $openDiv.$input.$closeDiv;
	return $html;
});