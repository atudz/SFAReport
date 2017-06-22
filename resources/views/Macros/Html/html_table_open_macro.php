<?php

Html::macro('topen', function($options=[]) {

	$show_download = isset($options['show_download']) && $options['show_download'];
	
	$loading = isset($options['no_loading']) && $options['no_loading'] ? 'hide' : 'show';

	$html = '<div class="col-sm-12 form-group row">';
	
	if(array_key_exists('show_search', $options) && $options['show_search'])
	{
		$html .= '				
					<div class="pull-left">
						<div class="inner-addon left-addon">
						<i class="glyphicon glyphicon-search"></i>
							<input type="text" class="form-control input-sm" placeholder="Search" ng-model="query.$"/>
						</div>
			      	</div>';
	}

	if(array_key_exists('show_add_button', $options) && $options['show_add_button'])
	{
		$html .= '
						<div class="pull-left" style="padding:0px 5px 0px 10px">
							<a href="#'.$options['add_link'].'" class="btn btn-primary btn-sm">Add</a>
				      	</div>';
	}
	
	if(isset($options['edit_link']))
	{
		$hide = isset($options['edit_hide']) ? $options['edit_hide'] : '';
		$html .= '
						<div class="pull-left" style="padding:0px 5px 0px 5px">
							<a href="'.$options['edit_link'].'" class="btn btn-info btn-sm '.$hide.'">Edit</a>
				      	</div>';
	}
	
	if(isset($options['save_controller']))
	{
		$html .= '
						<div class="pull-left" style="padding:0px 5px" ng-controller="'.$options['save_controller'].'">
							<button type="button" class="btn btn-warning btn-sm">Save</button>
				      	</div>';
	}
	if(array_key_exists('show_download', $options) && $options['show_download'])	
	{						
		$label = isset($options['execute']) ? '<i class="fa fa-cog"></i> Actions' : '<i class="fa fa-download"></i> Download';
		$html.= '<div class="pull-right">					
		      		<div class="btn-group">
					      <button id="btn-append-to-body" data-toggle="dropdown" type="button" class="btn btn-success btn-sm dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
					       '.$label.' <span class="caret"></span>
					      </button>
					      <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-append-to-body" role="menu">
							';
		if(!isset($options['no_xls']) || !$options['no_xls'])
			$html .= '<li role="menuitem"><a href="" ng-click="download(\'xlsx\')">Excel</a></li>';
		if(array_key_exists('show_print', $options) && $options['show_print'])
			$html .= '<li role="menuitem"><a href="" ng-click="download(\'pdf\')">Print to PDF</a></li>';
		
		if(isset($options['execute']) && $options['execute'])
		{
			$html .= '
					<li role="separator" class="divider"></li>
					<li><a href="" ng-click="seedHeader()">Seed Header</a></li>
					<li><a href="" ng-click="seedData()">Seed Detail</a></li>
    				<li><a href="" ng-click="exportXls()">Seed Excel File</a></li>
					<li><a href="" ng-click="postData()">Seed Post</a></li>
					<li><a href="" ng-click="clearData()">Seed Clear</a></li>
				';
		}
							      
		$html .= '	      </ul>
    				</div>
		      	</div>
		      	';
	}
	
	

	if(array_key_exists('show_mass_edit_button', $options) && $options['show_mass_edit_button'])
	{
		$html .= '
						<div class="pull-left" style="padding:0px 5px 0px 10px">
							<a id="mass-edit-btn" class="btn btn-primary btn-sm" ng-click="showMassEditPage()" ng-disabled="!hasChecked">Edit</a>
				      	</div>';
	}

	$html .= '<div class="col-sm-7 col-sm-offset-5 '.$loading.'" id="loading_div">
					<span><i class="fa fa-spinner fa-lg fa-pulse"></i> Loading..</span>
				</div>				
				<div class="text-center alert alert-success hide" id="table_success"></div>
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
			    						<input type="radio" name="exportdoc" ng-click="selectItem([[item.from]])"> [[item.from]] - [[item.to]]
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
			</div>			
			<div class="wrapper">							
			<table class="table table-striped table-condensed table-bordered"'.Html::attributes($options).'>';
	return $html;
});