<?php

/**
 * Macro template for display
 */
Form::macro('formDisplay', function($value,$label=null){

	$openDiv = '<div class="form-group">
				<label class="col-sm-2 control-label">'.$label.
			   '<div class="col-sm-10">';
	$input = '<p class="form-control-static">'.$value.'</p>';
	$closeDiv = '</div></div>';
	$html = $openDiv.$input.$closeDiv;
	return $html;
});