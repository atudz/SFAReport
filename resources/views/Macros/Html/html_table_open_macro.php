<?php

Html::macro('topen', function($options=[]) {

	$xlsUrl = isset($options['xls_url']) ? $options['xls_url'] : '#';
	$pdfUrl = isset($options['pdf_url']) ? $options['pdf_url'] : '#';
	
	$html = '
			<div class="col-sm-12 table-options">
				<div class="pull-left">
					<div class="inner-addon left-addon">
					<i class="glyphicon glyphicon-search"></i>
						<input type="text" class="form-control input-sm" placeholder="Search" ng-model="query.$"/>
					</div>
		      	</div>
		      	<div class="pull-right">					
		      		<div class="btn-group" uib-dropdown dropdown-append-to-body>
					      <button id="btn-append-to-body" type="button" class="btn btn-success btn-sm" uib-dropdown-toggle>
					        <i class="fa fa-download"></i> Download <span class="caret"></span>
					      </button>
					      <ul class="uib-dropdown-menu" role="menu" aria-labelledby="btn-append-to-body">
					        <li role="menuitem"><a href="'.$xlsUrl.'">Excel</a></li>
					        <li role="menuitem"><a href="'.$pdfUrl.'">Print to PDF</a></li>					      
					      </ul>
    				</div>
		      	</div>
			</div>
			
			<div class="col-sm-12 table-responsive">							
			<table class="table table-striped table-condensed table-bordered"'.Html::attributes($options).'>';

	return $html;
});