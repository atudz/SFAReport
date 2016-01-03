{!!Html::breadcrumb(['User List','Add User'])!!}
{!!Html::pageheader('Add User')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<div class="col-sm-12" style="margin-bottom:5px;padding-left:0px;padding-right:0px;">
					<div class="pull-left col-sm-6 alert-success no-padding" ng-show="success">
						<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<div class="error-list">User record saved successfully.</div>						
					</div>
					<div class="pull-right">
			      		<a href="#user.list" class="btn btn-success btn-sm">Back to User List</a>
			      	</div>
			    </div>
				
				<div class="col-sm-12">
				
				</div>
			
				<div class="pull-left col-sm-6 well">
					<h4 style="margin-bottom: 20px;">Personal Information</h4>
					{!!Html::error('personalInfoError','error_list_personal')!!}
					<div class="row form-input-field">
						{!!Html::input('text','fname','First Name *')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','lname','Last Name')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','mname','Middle Name')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','email','Email *')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','username','Username')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('password','password','Password *')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('password','confirm_pass','Confirm Password *')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','address','Adddress')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','telephone','Telephone No.')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','mobile','Mobile No.')!!}
					</div>									
				</div>
					
					
				<div class="pull-right col-sm-5 col-sm-offset-1 well">
					<h4 style="margin-bottom: 20px;">Access & Location</h4>
					{!!Html::error('locationInfoError','error_list_location')!!}
					<div class="row form-input-field">
						{!!Html::select('role','Role *', $roles, '')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::select('area','Branch *', $areas, '')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::select('status','Status *', $statuses, '')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::select('assignment_type','Assignment *', $assignmentOptions, '')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::datepicker('assignment_date','Date From & To*', true)!!}							
					</div>												
				</div>
				
				<div class="rs-mini-toolbar">
					<div class="rs-toolbar-savebtn">
						<a class="button-primary revgreen" ng-click="save()" id="button_save_slide-tb" original-title="" style="display: block; cursor:pointer;">
							<i class="fa fa-floppy-o" style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>
							Save
						</a>
					</div>					
				</div>
													
			</div>			
		</div>
	</div>
</div>
