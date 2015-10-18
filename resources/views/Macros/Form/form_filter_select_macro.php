<?php

Form::macro('filterSelect', function($name,$options,$label=null,$value=null,$multiple=false){

	$openDiv = '<div class="form-group form-group-sm filter-field">';
	$labelTag  = Form::label($name,$label,['class'=>'col-sm-2 control-label']);
	$settings = ['class'=>'form-control'];
	if($multiple)
	{
		$settings['multiple'] = true;
	}
	$input = '<div class="col-sm-8">'.Form::select($name, $options, $value, $settings).'</div>';
	$closeDiv = '</div>';
	$html = $openDiv.$labelTag.$input.$closeDiv;
	return $html;
});