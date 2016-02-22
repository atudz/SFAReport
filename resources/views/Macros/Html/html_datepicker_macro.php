<?php

Html::macro('datepicker', function($name, $label, $fromTo=false, $monthOnly=false, $controller='Calendar') {
				
	$placeholderFrom = $fromTo ? 'placeholder="From"' : '';
	$placeholderTo = $fromTo ? 'placeholder="To"' : '';
	$options = $monthOnly ? '{minMode: \'month\'}' : 'dateOptions'; 
	
	$html = '<div class="form-group">
			 	<div class="col-xs-12 col-md-5 col-sm-5 control-label">
			 		<label for="'.$name.'" class="">'.$label.'</label>
			 	</div>
			 	<div class="col-xs-12  col-sm-6" data-ng-controller="'.$controller.'">
			 	<p class="input-group">
			 		<input type="text" id="'.$name.'_from" name="'.$name.'_from" show-weeks="true" ng-click="open($event,\''.$name.'_from\')" class="form-control" uib-datepicker-popup="[[format]]" ng-model="dateFrom" is-open="'.$name.'_from" datepicker-options="'.$options.'" close-text="Close"'.$placeholderFrom.' onkeydown="return false;"/>
			 		<span class="input-group-btn">
			 			<button type="button" class="btn btn-default btn-sm" ng-click="open($event,\''.$name.'_from\')"><i class="glyphicon glyphicon-calendar"></i></button>
			 		</span>
			 	</p>';
	if($fromTo)
	{
		$html .= '
			    <p class="input-group">
              		<input type="text" id="'.$name.'_to" name="'.$name.'_to" show-weeks="true" ng-click="open($event,\''.$name.'_to\')" class="form-control" uib-datepicker-popup="[[format]]" ng-model="dateTo" is-open="'.$name.'_to" datepicker-options="dateOptions" close-text="Close" '.$placeholderTo.' onkeydown="return false;"/>
              		<span class="input-group-btn">
                		<button type="button" class="btn btn-default btn-sm" ng-click="open($event,\''.$name.'_to\')"><i class="glyphicon glyphicon-calendar"></i></button>
              		</span>
                </p>
                <p class="indent error hide" id="'.$name.'_error">Invalid date range.</p>				               
				';
	}
	
	$html .= ' </div>
             </div>';

	return $html;
});