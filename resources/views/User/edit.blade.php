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
						<div class="form-group form-group-sm">
			 				<label for="fname" class="col-sm-3 control-label">First Name <span class="required">*</span></label>
			 				<div class="col-sm-6">
			 					<input placeholder="" class="form-control" id="fname" name="fname" type="text" ng-model="records.firstname">
			 				</div>
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
							<label for="lname" class="col-sm-3 control-label">Last Name</label>
				 			<div class="col-sm-6">
				 				<input placeholder="" class="form-control" id="lname" name="lname" type="text" ng-model="records.lastname">
				 			</div>				 								
				 		</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">						
							<label for="mname" class="col-sm-3 control-label">Middle Name</label>
			 				<div class="col-sm-6">
			 					<input placeholder="" class="form-control" id="mname" name="mname" type="text" ng-model="records.middlename">
			 				</div>			 				
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">						
							<label for="email" class="col-sm-3 control-label">Email <span class="required">*</span></label>
			 				<div class="col-sm-6">
			 					<input placeholder="" class="form-control" id="email" name="email" type="text" ng-model="records.email">
			 				</div>			 				
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">						
							<label for="username" class="col-sm-3 control-label">Username</label>
			 				<div class="col-sm-6">
			 					<input placeholder="" class="form-control" id="username" name="username" type="text" ng-model="records.username">
			 				</div>			 				
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">						
							<label for="password" class="col-sm-3 control-label">Password <span class="required">*</span></label>
			 				<div class="col-sm-6">
			 					<input class="form-control" id="password" name="password" type="password" placeholder="Leave this blank if no change">
			 				</div>			 				
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">						
							<label for="confirm_pass" class="col-sm-3 control-label">Confirm Password <span class="required">*</span></label>
			 				<div class="col-sm-6">
			 					<input class="form-control" id="confirm_pass" name="confirm_pass" type="password" placeholder="Leave this blank if no change">
			 				</div>			 				
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="gender" class="col-sm-3 control-label">Gender</label>
			 				<div class="col-sm-6">
			 					<select class="form-control" id="gender" name="gender" ng-model="records.gender">
			 					<option value="0">Not Specified</option>
			 						@foreach($gender as $id=>$val)
			 							<option value="{{$id}}">{{$val}}</option>			 						
			 						@endforeach
			 					</select>	
			 				</div>
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 			<label for="age" class="col-sm-3 control-label">Age <span class="required">*</span></label>
			 				<div class="col-sm-6">
			 					<input placeholder="" class="form-control" id="age" min="0" name="age" type="number" ng-model="age">
			 				</div>
			 			</div>
					</div>					
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="address" class="col-sm-3 control-label">Adddress</label>
			 				<div class="col-sm-6">
			 					<input placeholder="" class="form-control" id="address" name="address" type="text" ng-model="records.address1">
			 				</div>
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="telephone" class="col-sm-3 control-label">Telephone No.</label>
			 				<div class="col-sm-6">
			 					<input placeholder="" class="form-control" id="telephone" name="telephone" type="text" ng-model="records.telephone">
			 				</div>
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="mobile" class="col-sm-3 control-label">Mobile No.</label>
			 				<div class="col-sm-6"><input placeholder="" class="form-control" id="mobile" name="mobile" type="text" ng-model="records.mobile">	</div>
			 			</div>
					</div>
					
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="salesman_code" class="col-sm-3 control-label">Salesman Code*</label>
			 				<div class="col-sm-6"><input placeholder="" class="form-control" id="salesman_code" name="salesman_code" type="text" ng-model="records.salesman_code">	</div>
			 			</div>
					</div>									
				</div>
					
					
				<div class="pull-right col-sm-5 col-sm-offset-1 well">
					<h4 style="margin-bottom: 20px;">Access & Location</h4>
					{!!Html::error('locationInfoError','error_list_location')!!}
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="role" class="col-sm-3 control-label">Role <span class="required">*</span></label>
			 				<div class="col-sm-6">
			 					<select class="form-control" id="role" name="role" ng-model="records.user_group_id">
			 						@foreach($roles as $id=>$role)
			 							<option value="{{$id}}">{{$role}}</option>
			 						@endforeach			 						
			 					</select>	
			 					<p class="help-block hidden" id="admin_info">
			 						<i>Can add unlimited auditor users.</i><br>
			 						<i>Can add unlimited AIC users.</i><br>
			 						<i>Can add unlimited van salesman users.</i><br>
			 					</p>
			 					<p class="help-block hidden" id="auditor_info">
			 						<i>Can view reports all branches.</i><br>			 						
			 					</p>
			 					<p class="help-block hidden" id="aic_info">
			 						<i>Can only view their reports only (per branch).</i><br>
			 						<i>Can only filter their area only.</i><br>			 						
			 					</p>
			 					<p class="help-block hidden" id="salesman_info">
			 						<i>Can only view their reports only (per branch).</i><br>
			 						<i>Can only filter their area only.</i><br>
			 					</p>
			 				</div>
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="role" class="col-sm-3 control-label">Branch <span class="required">*</span></label>
			 				<div class="col-sm-6">
			 					<select class="form-control" id="area" name="area" ng-model="records.location_assignment_code">
			 						@foreach($areas as $id=>$area)
			 							<option value="{{$id}}">{{$area}}</option>
			 						@endforeach			 						
			 					</select>	
			 				</div>
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="role" class="col-sm-3 control-label">Assignment <span class="required">*</span></label>
			 				<div class="col-sm-6">
			 					<select class="form-control" id="assignment_type" name="assignment_type" ng-model="records.location_assignment_type">
			 						@foreach($assignmentOptions as $id=>$val)
			 							<option value="{{$id}}">{{$val}}</option>
			 						@endforeach			 						
			 					</select>	
			 				</div>
			 			</div>
					</div>
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
			 				<label for="assignment_date" class="col-sm-3 control-label">Date From &amp; To</label>
						 	<div class="col-sm-6" data-ng-controller="Calendar">
							 	<p class="input-group">
							 		<input type="text" id="assignment_date_from" name="assignment_date_from" show-weeks="true" ng-click="open($event,'assignment_date_from')" class="form-control" uib-datepicker-popup="MM/dd/yyyy" ng-model="from" is-open="assignment_date_from" datepicker-options="dateOptions" close-text="Close" placeholder="From" onkeydown="return false;">
							 		<span class="input-group-btn">
							 			<button type="button" class="btn btn-default btn-sm" ng-click="open($event,'assignment_date_from')"><i class="glyphicon glyphicon-calendar"></i></button>
							 		</span>
							 	</p>
							    <p class="input-group">
				              		<input type="text" id="assignment_date_to" name="assignment_date_to" show-weeks="true" ng-click="open($event,'assignment_date_to')" class="form-control" uib-datepicker-popup="MM/dd/yyyy" ng-model="to" is-open="assignment_date_to" datepicker-options="dateOptions" close-text="Close" placeholder="To" onkeydown="return false;"><!-- ngIf: isOpen -->
				              		<span class="input-group-btn">
				                		<button type="button" class="btn btn-default btn-sm" ng-click="open($event,'assignment_date_to')"><i class="glyphicon glyphicon-calendar"></i></button>
				              		</span>
				                </p>
				                <p class="indent error hide" id="assignment_date_error">Invalid date range.</p>				
                			</div>
             			</div>							
					</div>												
				</div>
				
				<div class="rs-mini-toolbar">
					<div class="rs-toolbar-savebtn">
						<a class="button-primary revgreen" ng-click="save(true)" id="button_save_slide-tb" original-title="" style="display: block; cursor:pointer;">
							<i class="fa fa-floppy-o" style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>
							Save
						</a>
					</div>					
				</div>
													
			</div>			
		</div>
	</div>
</div>
