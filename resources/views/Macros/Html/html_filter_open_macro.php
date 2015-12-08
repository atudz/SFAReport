<?php

Html::macro('fopen', function($label, $controller='Filter') {
	
	$html = '<div class="col-sm-12">
			 <button type="button" class="btn btn-info btn-sm" ng-click="toggleFilter = !toggleFilter">'.$label.'</button>
			 <hr>
			 <div uib-collapse="toggleFilter">
			 <div class="well filter col-sm-12">
			 <form class="form-horizontal">';

	return $html;
});