{!!Html::breadcrumb(['Sync Data'])!!}
{!!Html::pageheader('Sync Data')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="row">
					<div style="margin-left: 38%;margin-right: 62%;width: 6em">
						<button class="btn btn-success" ng-click="sync()">Sync Now</button>&nbsp;&nbsp;&nbsp;															
					</div>					
				</div>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-2" style="padding-top:10px;margin-top:10px;">
						<p class="text-center" ng-show="showLoading"><i class="fa fa-spinner fa-pulse fa-4x"></i></p>
						<h2><p class="alert alert-success text-center" ng-show="showSuccess">Success!!</p></h2>
						<h2><p class="alert alert-error text-center" ng-show="showError">Failed!!</p></h2>																				
						<h2><p class="alert alert-warning text-center" ng-show="showWarning">Synchornization is still on progress.. Please wait for a moment.</p></h2>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
