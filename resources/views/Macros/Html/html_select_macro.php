<?php

use Illuminate\Support\Collection;
Html::macro('select', function($name, $label, $list=[], $default='All',$addons=[],$value=null) {

	$options = [
		'class' => 'form-control',	
		'id' => $name
	];
	
	if($default)
	{
		if($list instanceof  Collection)
			$list = $list->prepend($default,'');
		else
			$list = [''=>$default] + $list;
	}	
	
	if($addons)
		$options = array_merge($options,$addons);
	
	$html = '<div class="form-group">
			 	<div class="col-xs-12 col-md-4 col-sm-4 control-label">
			 		<label for="'.$name.'" class="">'.$label.'</label>
			 	</div>
			 	<div class="col-xs-12 col-sm-8	">'.
			 		Form::select($name, $list, $value, $options).
			 '	
			 	<span class="error help-block"></span>
			 	</div>
			 </div>';

	return $html;
});