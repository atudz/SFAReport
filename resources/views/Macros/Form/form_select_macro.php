<?php

/**
 * Macro template for select field
*/
Form::macro('formSelect', function($name,$options,$value=null,$label=null,$multiple=false,$defaultOption=''){

	$openDiv = '<div class="form-group">';
	$labelTag  = ($label) ? Form::label($name,$label) : '';
	$default = Form::old($name) ? Form::old($name) : $value;
	$settings = ['class'=>'form-control'];
	if($multiple)
	{
		$settings['multiple'] = true;
	}

	if($options instanceof Illuminate\Support\Collection)
	{
		if($defaultOption)
			$options->prepend($defaultOption);
		$lists = $options;
	}
	elseif($defaultOption && is_array($options)) 
	{
		$lists = [0=>$defaultOption] + $options;
	}
	else
	{
		$lists = $options;
	}

	$input = Form::select($name, $lists, $default, $settings);
	$closeDiv = '</div>';
	$html = $openDiv.$labelTag.$input.$closeDiv;
	return $html;
});