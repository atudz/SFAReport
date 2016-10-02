<?php

use Illuminate\Support\Collection;
Html::macro('select', function($name, $label, $list=[], $default='All',$addons=[]) {

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
	
	if($addons)
		$options = array_merge($options,$addons);
	
	$html = '<div class="form-group">
			 	<div class="col-xs-12 col-md-5 col-sm-5 control-label">
			 		<label for="'.$name.'" class="">'.$label.'</label>
			 	</div>
			 	<div class="col-xs-12 col-sm-6">'.
			 		Form::select($name, $list, null, $options).
			 '	</div>
			 </div>';

	return $html;
});