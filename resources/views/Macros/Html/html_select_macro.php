<?php

use Illuminate\Support\Collection;
Html::macro('select', function($name, $label, $list=[], $default='All') {

	$options = [
		'class' => 'form-control',	
		'id' => $name
	];
	
	if($default)
	{
		if($list instanceof  Collection)
			$list = $list->prepend($default);
		else
			$list = [$default] + $list;
	}	
	
	$html = '<div class="form-group">
			 	<label for="'.$name.'" class="col-xs-12 col-md-5 col-sm-5 control-label">'.$label.'</label>
			 	<div class="col-xs-12 col-sm-6">'.
			 		Form::select($name, $list, null, $options).
			 '	</div>
			 </div>';

	return $html;
});