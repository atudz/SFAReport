{!!Html::breadcrumb(['User Management','Add User'])!!}
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
						{!!Html::input('text','fname','First Name <span class="required">*</span>')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','lname','Last Name <span class="required">*</span>')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','mname','Middle Name')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','email','Email <span class="required">*</span>','',['ng-keyup'=>'regExemail()','id'=>'email'])!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','username','Username <span class="required">*</span>')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('password','password','Password <span class="required">*</span>')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('password','confirm_pass','Confirm Password <span class="required">*</span>')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::select('gender','Gender', $gender, '')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('number','age','Age <span class="required">*</span>','',['min'=>18])!!}
					</div>					
					<div class="row form-input-field">
						{!!Html::input('text','address','Address')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','telephone','Telephone No.','',['pattern'=>'[0-9]*'])!!}
					</div>
					<div class="row form-input-field">
						{!!Html::input('text','mobile','Mobile No.')!!}
					</div>					
					<div class="row form-input-field">
						{!!Html::input('text','salesman_code','Salesman Code <span id="span_salesman" class="required hidden">*</span>')!!}
					</div>
					<div class="row form-input-field">
						<div class="form-group">
							<div class="col-xs-12 col-md-4 col-sm-4 control-label">
								<label for="jr_salesman_code" class="">Jr. Salesman Code</label>
							</div>
							<div class="col-xs-5">
								<div class="checkbox checkbox-inline" style="margin-top: auto;">
									<input disabled type="checkbox" id="checkbox_jr_salesman" style="margin-top: auto;">
									<span id="label_jr_salesman_code" style="display: inline-block; margin: auto;">
										[[ jr_salesman_code ]]
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
					
					
				<div class="pull-right col-sm-5 col-sm-offset-1 well">
					<h4 style="margin-bottom: 20px;">Access & Location</h4>
					{!!Html::error('locationInfoError','error_list_location')!!}
					<div class="row form-input-field">
						{!!Html::select('role','Role <span class="required">*</span>', $roles,'')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::select('area','Branch <span class="required">*</span>', $areas, '')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::select('assignment_type','Assignment <span class="required">*</span>', $assignmentOptions, '')!!}
					</div>
					<div class="row form-input-field">
						{!!Html::datepicker('assignment_date','Date From & To', true)!!}							
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
