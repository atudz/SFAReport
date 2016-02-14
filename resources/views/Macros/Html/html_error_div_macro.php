<?php

Html::macro('error', function($scopeVar='',$id='') {
	
	$html = '<div class="alert-danger no-padding" ng-show="'.$scopeVar.'"> 
				<div class="error-list" id="'.$id.'"></div>
			</div>';

	return $html;
});