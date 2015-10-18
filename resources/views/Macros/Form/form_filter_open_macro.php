<?php

Form::macro('filterOpen', function($options=[]) {
	
	$div = '<div data-ng-controller="FilterCtrl">'.
		   '<div class="filter filter-label">'.
	       '<span class="<%caret%>"></span><a class="filter-link" href="#" data-ng-click="toggleFilter()">&nbsp;&nbsp;Filter</a>'.
	       '</div>'.
		    '<div class="filter <%showFilter%>" >';	
	$form = Form::open($options);
	
	return $div.$form;
});