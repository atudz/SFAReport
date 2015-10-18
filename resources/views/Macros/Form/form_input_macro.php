<?php

/**
 * Macro template for input
 */
Form::macro('formInput', function($type,$name,$label=null,$value=null,$required=false,$preview='',$options=[]){
	
	// No need to wrap submit with div
	if(in_array($type,['submit','button']))
	{
		return Form::input($type,$name,$value,array_merge(['class'=>'btn btn-primary'],$options));
	}
	elseif('hidden' == $type)
	{
		return Form::input($type,$name,$value);
	}
	
	$openDiv = '<div class="form-group">';	
	$labelTag  = ($label) ? Form::label($name,$label) : '';
	$default = Form::old($name) ? Form::old($name) : $value;
	$settings =  ['class'=>'form-control'];
	if($required && !$preview)
	{
		$settings['required'] =  true;
	}
	$input = Form::input($type, $name, $default, array_merge($settings,$options));
	if($preview && 'file' == $type)
	{
		$input .= '<img src="'.$preview.'">';
	}
	$closeDiv = '</div>';	
	$html = $openDiv.$labelTag.$input.$closeDiv;
	return $html;
});