<?php

Html::macro('topen', function(array $options) {

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
					        Download <span class="caret"></span>
					      </button>
					      <ul class="uib-dropdown-menu" role="menu" aria-labelledby="btn-append-to-body">
					        <li role="menuitem"><a href="#">Excel</a></li>
					        <li role="menuitem"><a href="#">Print to PDF</a></li>					      
					      </ul>
    				</div>
		      	</div>
			</div>
			
			<div class="col-sm-12 table-responsive">							
			<table class="table table-striped table-condensed table-bordered"'.Html::attributes($options).'>';

	return $html;
});