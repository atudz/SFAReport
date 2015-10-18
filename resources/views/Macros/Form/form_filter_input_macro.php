<?php

Form::macro('filterInput', function($type,$name,$label=null,$value=null){

	// No need to wrap submit with div
	if(in_array($type,['submit','button']))
	{
		return Form::input($type,$name,$value,['class'=>'btn btn-primary']);
	}
	elseif('hidden' == $type)
	{
		return Form::input($type,$name,$value);
	}

	$openDiv = '<div class="form-group form-group-sm filter-field">';
	$labelTag  = Form::label($name,$label,['class'=>'col-sm-2 control-label']);
	$settings =  ['class'=>'form-control'];
	$input = '<div class="col-sm-8">'.Form::input($type, $name, $value, ['class'=>'form-control']).'</div>';
	$closeDiv = '</div>';
	$html = $openDiv.$labelTag.$input.$closeDiv;
	return $html;
});