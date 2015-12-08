<?php

Html::macro('datepicker', function($name, $label, $fromTo=false, $controller='Calendar') {
				
	$html = '<div class="form-group form-group-sm">
			 	<label for="'.$name.'" class="col-sm-3 control-label">'.$label.'</label>
			 	<div class="col-sm-6" data-ng-controller="'.$controller.'">
			 	<p class="input-group">
			 		<input type="text" id="'.$name.'_from" name="'.$name.'_from" show-weeks="true" ng-click="open($event,\''.$name.'_from\')" class="form-control" uib-datepicker-popup="[[format]]" ng-model="dateFrom" is-open="'.$name.'_from" datepicker-options="dateOptions" close-text="Close" />
			 		<span class="input-group-btn">
			 			<button type="button" class="btn btn-default btn-sm" ng-click="open($event,\''.$name.'_from\')"><i class="glyphicon glyphicon-calendar"></i></button>
			 		</span>
			 	</p>';
	if($fromTo)
	{
		$html .= '
			    <p class="input-group">
              		<input type="text" id="'.$name.'_to" name="'.$name.'_to" show-weeks="true" ng-click="open($event,\''.$name.'_to\')" class="form-control" uib-datepicker-popup="[[format]]" ng-model="dateTo" is-open="'.$name.'_to" datepicker-options="dateOptions" close-text="Close" />
              		<span class="input-group-btn">
                		<button type="button" class="btn btn-default btn-sm" ng-click="open($event,\''.$name.'_to\')"><i class="glyphicon glyphicon-calendar"></i></button>
              		</span>
                </p>
                </div>
             </div>
				';
	}

	return $html;
});