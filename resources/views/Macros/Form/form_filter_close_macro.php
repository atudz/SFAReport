<?php

Form::macro('filterClose', function() {
	
	$div = '</div>';
	$submit = '<div class="form-group form-group-sm">'.
			  '<div class="col-sm-offset-2 col-sm-10">'.
			  Form::input('submit','submit','Filter',['class'=>'btn btn-primary']).
			  '</div></div></div>';
	$form = Form::close();

	return $submit.$form.$div;
});