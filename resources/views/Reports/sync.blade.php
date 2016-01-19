{!!Html::breadcrumb(['Sync Data'])!!}
{!!Html::pageheader('Sync Data')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-2 col-sm-offset-2">
						<button class="btn btn-success" ng-click="sync()">Sync Now</button>&nbsp;&nbsp;&nbsp;
						<span ng-show="showLoading"><i class="fa fa-spinner fa-pulse fa-2x"></i></span>										
					</div>					
				</div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-2" style="padding-top:10px;margin-top:10px;">
						<p class="alert-success" ng-show="showSuccess">Success!!!</p>
						<p class="alert-warning" ng-show="showError">Failed!!!</p>
						<pre>[[syncLogs]]</pre>																
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
