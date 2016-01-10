<?php

Html::macro('topen', function($options=[]) {

	$no_download = isset($options['no_download']);
	
	$no_search = isset($options['no_search']);
	$html = '<div class="col-sm-12 table-options">';
	
	if(!$no_search)
	{
		$html .= '				
					<div class="pull-left">
						<div class="inner-addon left-addon">
						<i class="glyphicon glyphicon-search"></i>
							<input type="text" class="form-control input-sm" placeholder="Search" ng-model="query.$"/>
						</div>
			      	</div>';
	}
	if(!$no_download)
	{						
		$html.= '<div class="pull-right">					
		      		<div class="btn-group" uib-dropdown dropdown-append-to-body>
					      <button id="btn-append-to-body" type="button" class="btn btn-success btn-sm" uib-dropdown-toggle>
					        <i class="fa fa-download"></i> Download <span class="caret"></span>
					      </button>
					      <ul class="uib-dropdown-menu" role="menu" aria-labelledby="btn-append-to-body">
							';
		if(!isset($options['no_xls']))
			$html .= '<li role="menuitem"><a href="" ng-click="download(\'xlsx\')">Excel</a></li>';
		if(!isset($options['no_pdf']))
			$html .= '<li role="menuitem"><a href="" ng-click="download(\'pdf\')">Print to PDF</a></li>';
							      
		$html .= '	      </ul>
    				</div>
		      	</div>';
	}
	
	$html .= '<div class="col-sm-7 col-sm-offset-5 show" id="loading_div">
					<span><i class="fa fa-spinner fa-lg fa-pulse"></i> Loading..</span>
				</div>				

				<script type="text/ng-template" id="exportModal">
        			<div class="modal-header">
            			<h3 class="modal-title">[[params.title]]</h3>
        			</div>
			        <div class="modal-body">
						<p class="indent">
							<em>The data exceed the maximum limit of [[params.limit]] records. Please choose the appropriate range of data to export below.</em>
						</p>
			            <ul class="list-inline list-unstyled">
			                <li ng-repeat="item in params.chunks">
			                    <div class="radio">
			  						<label>
			    						<input type="radio" ng-click="selectItem([[item.from]])"> [[item.from]] - [[item.to]]
			  						</label>
								</div>
			                </li>
			            </ul>
			        </div>
			        <div class="modal-footer">
			            <button class="btn btn-success" type="button" ng-click="download()">Download</button>
			            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
			        </div>
    			</script>

    			<script type="text/javascript">
				$(function() {
				 	$("table.table").floatThead({
					    position: "absolute",
					    autoReflow: true,
					    scrollContainer: function($table){
					        return $table.closest(".wrapper");
					    }
					});
				});
				</script>
    
			</div>			
			<div class="wrapper">							
			<table class="table table-striped table-condensed table-bordered"'.Html::attributes($options).'>';

	return $html;
});