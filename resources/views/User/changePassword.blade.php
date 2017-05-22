{!!Html::breadcrumb(['My Account: '.Auth::User()->firstname.' '.Auth::User()->lastname,'Change Password'])!!}
{!!Html::pageheader('Change Password')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				{!!Html::error('error','error_list')!!}
				<div class="pull-left col-sm-12 alert-success" ng-show="success" style="margin-bottom:10px">
					<div class="error-list">Password changed successfully.</div>						
				</div>
				<div class="form-group row" style="margin-top:10px">
					<label class="col-sm-2" for="old_password">Old Password</label>
					<div class="col-sm-5">
				      <input type="password" class="form-control" id="old_password" placeholder="">
				    </div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2" for="old_password">New Password</label>
					<div class="col-sm-5">
				      <input type="password" class="form-control" id="new_password" placeholder="">
				    </div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2" for="old_password">Confirm Password</label>
					<div class="col-sm-5">
				      <input type="password" class="form-control" id="confirm_password" placeholder="">
				    </div>
				</div>
				@if($navigationActions['can_change_password'])
					<div class="form-group row">
					    <div class="col-sm-offset-2 col-sm-5">
					      <button type="button" class="btn btn-success" ng-click="submit()">Submit</button>
					    </div>
				 	</div>
			 	@endif
			</div>
		</div>
	</div>
</div>
