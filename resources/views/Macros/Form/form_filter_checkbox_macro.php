<?php

Form::macro('filterCheckbox', function($name,$label=null,$value=1, $checked=false){

	$openDiv = '<div class="form-group form-group-sm filter-field">';
	$labelTag  = Form::label('','',['class'=>'col-sm-2 control-label']);
	$settings =  ['class'=>'form-control'];
	$input = '<div class="col-sm-8">'.
			 '<div class="checkbox">'.
			 '<label>'.Form::checkbox($name,$value,$checked).$label.'</label>'.
			 '</div>'.
			 '</div>';
	$closeDiv = '</div>';
	$html = $openDiv.$labelTag.$input.$closeDiv;
	return $html;
});