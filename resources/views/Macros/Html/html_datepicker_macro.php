<?php

Html::macro('datepicker', function($name, $label, $fromTo=false, $monthOnly=false, $from='', $to='', $controller='Calendar', $yearOnly=false) {
				
	$placeholderFrom = $fromTo ? 'placeholder="From"' : '';
	$placeholderTo = $fromTo ? 'placeholder="To"' : '';
	$options = $monthOnly ? '{minMode: \'month\'}' : 'dateOptions'; 
	if($yearOnly)
		$options = '{minMode: \'year\'}';
	
	$html = '<div class="form-group">
			 	<div class="col-xs-12 col-md-4 col-sm-4 control-label">
			 		<label for="'.$name.'" class="">'.$label.'</label>
			 	</div>
			 	<div class="col-xs-12  col-sm-8" data-ng-controller="'.$controller.'">
			 	<p class="input-group">
			 		<input ng-init="setFrom(\''.$from.'\')" type="text" id="'.$name.'_from" name="'.$name.'_from" show-weeks="true" ng-click="open($event,\''.$name.'_from\')" class="form-control" uib-datepicker-popup="[[format]]" ng-model="dateFrom" is-open="'.$name.'_from" datepicker-options="'.$options.'" close-text="Close"'.$placeholderFrom.' onkeydown="return false;"/>';
			 							 	
	$html .= '<span class="input-group-btn">
			 			<button type="button" class="btn btn-default btn-sm" ng-click="open($event,\''.$name.'_from\')"><i class="glyphicon glyphicon-calendar"></i></button>
			 		</span>
			 	</p>
				<span class="error help-block"></span>
			 	';
	if($fromTo)
	{
		$html .= '
			    <p class="input-group">
              		<input ng-init="setTo(\''.$to.'\')" type="text" id="'.$name.'_to" name="'.$name.'_to" show-weeks="true" ng-click="open($event,\''.$name.'_to\')" class="form-control" uib-datepicker-popup="[[format]]" ng-model="dateTo" is-open="'.$name.'_to" datepicker-options="dateOptions" close-text="Close" '.$placeholderTo.' onkeydown="return false;"/>';
		
		      				
         $html .= '<span class="input-group-btn">
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