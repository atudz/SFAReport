{!!Html::breadcrumb(['My Profile'])!!}
{!!Html::pageheader('My Profile')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body" style="overflow: hidden; position: relative;">

				<div class="visible-md-block visible-lg-block" style="width: 400px; height: 400px; position: absolute; right: -22px; top: 0;">
					<div id="chart-div"></div>
					<div class="btn-group" style="position: absolute; bottom: 0; left: 156px;">
					    <button id="btn-append-to-body" data-toggle="dropdown" type="button" class="btn btn-success btn-sm dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
					        <i class="fa fa-download"></i> Download<span class="caret"></span>
					    </button>
					    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-append-to-body" role="menu">
					    	<li role="menuitem"><a href="" ng-click="downloadUserStatistics()">Print to PDF</a></li>
					    </ul>
			        </div>
				</div>
				<div style="width: 400px; height: 400px; position: absolute; right: 11px; top: 0; display: none;">
					<img id="chart-image-div" src="" alt="">
				</div>

				<h4>Personal Information</h4>
				{!!Html::error('personalInfoError','error_list_personal')!!}
				<div class="pull-left col-sm-12 alert-success" ng-show="success" style="margin-bottom:10px">
					<div class="error-list">User record saved successfully.</div>						
				</div>
				<br />
				{!!Form::open(['class'=>'changepassword-form'])!!}
					<div class="form-group row">
						<label class="col-sm-2" for="fname">First Name *</label>
						<div class="col-sm-5">
					      <input ng-model="records.firstname" type="text" name="fname" id="fname" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="mname">Middle Name</label>
						<div class="col-sm-5">
					      <input ng-model="records.middlename" type="text" name="mname" id="mname" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="lname">Last Name</label>
						<div class="col-sm-5">
					      <input ng-model="records.lastname" type="text" name="lname" id="lname" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-2" for="status">Gender</label>
						<div class="col-sm-5">
								<select id="gender" name="gender" class="form-control" ng-model="records.gender" {{$readOnly}}>
									@foreach($gender as $k=>$val)
										<option value="{{$k}}">{{$val}}</option>
									@endforeach									
								</select>
					    </div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-2" for="age">Age *</label>
						<div class="col-sm-5">
					      <input ng-model="age" type="number" name="age" id="age" class="form-control" placeholder="" min="0" {{$readOnly}}>
					    </div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-2" for="address">Address</label>
						<div class="col-sm-5">
					      <input ng-model="records.address1" type="text" name="address" id="address" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="email">Email Address *</label>
						<div class="col-sm-5">
					      <input ng-model="records.email" type="text" name="email" id="email" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="telephone">Tel No.:</label>
						<div class="col-sm-5">
					      <input ng-model="records.telephone" type="text" name="telephone" id="telephone" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="mobile">Mobile No.:</label>
						<div class="col-sm-5">
					      <input ng-model="records.mobile" type="text" name="mobile" id="mobile" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>
					
					<div class="form-group row">
						<label class="col-sm-2" for="mobile">Salesman Code</label>
						<div class="col-sm-5">
					      <input ng-model="records.salesman_code" type="text" name="mobile" id="mobile" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>

					<div class="visible-sm visible-xs-block" style="position: relative; overflow: scroll;">
						<div id="chart-mobile-div"></div>
						<div class="btn-group" style="position: absolute; bottom: 0; left: 156px;">
						    <button id="btn-append-to-body" data-toggle="dropdown" type="button" class="btn btn-success btn-sm dropdown-toggle" type="button" aria-haspopup="true" aria-expanded="false">
						        <i class="fa fa-download"></i> Download<span class="caret"></span>
						    </button>
						    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="btn-append-to-body" role="menu">
						    	<li role="menuitem"><a href="" ng-click="downloadUserStatistics()">Print to PDF</a></li>
						    </ul>
				        </div>
					</div>
					<hr />

					<h4>Credentials</h4>

					<div class="form-group row">
						<label class="col-sm-2" for="username">Username</label>
						<div class="col-sm-5">
							<input ng-model="records.username" type="text" name="username" id="username" class="form-control" placeholder="" {{$readOnly}}>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="password">Change Password</label>
						<div class="col-sm-5">
							<a href="#profile.changepassword">Click here to change password</a>
					    </div>
					</div>

					<hr />

					<h4>Access &amp; Location</h4>

					<div class="form-group row">
						<label class="col-sm-2" for="role">Role</label>
						<div class="col-sm-5">
								<select id="role" id="role" class="form-control" ng-model="records.user_group_id" {{$readOnly}}>
									@foreach($roles as $k=>$val)
										<option value="{{$k}}">{{$val}}</option>
									@endforeach
								</select>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="area">Branch</label>
						<div class="col-sm-5">
								<select id="area" class="form-control" ng-model="records.location_assignment_code" {{$readOnly}}> 
									@foreach($areas as $k=>$val)
										<option value="{{$k}}">{{$val}}</option>
									@endforeach
								</select>
					    </div>
					</div>					
					
					<div class="form-group row">
						<label class="col-sm-2" for="assignment_type">Assignment</label>
						<div class="col-sm-5">
								<select id="assignment_type" class="form-control" ng-model="records.location_assignment_type" {{$readOnly}}>
									@foreach($assignmentOptions as $k=>$val)
										<option value="{{$k}}">{{$val}}</option>
									@endforeach
								</select>
					    </div>
					</div>
					
					<div class="row form-input-field">
						<div class="form-group form-group-sm">
						 	<label for="assignment_date" class="col-sm-2 control-label">Date From &amp; To</label>
						 	<div class="col-sm-5 ng-scope" data-ng-controller="Calendar">
						 	<p class="input-group">
						 		<input type="text" id="assignment_date_from" name="assignment_date_from" show-weeks="true" ng-click="open($event,'assignment_date_from')" class="form-control ng-pristine ng-untouched ng-valid ng-isolate-scope ng-valid-date" uib-datepicker-popup="MM/dd/yyyy" ng-model="from" is-open="assignment_date_from" datepicker-options="dateOptions" close-text="Close" placeholder="From" onkeydown="return false;" {{$readOnly}}><!-- ngIf: isOpen -->
						 		<span class="input-group-btn">
						 			<button @if($readOnly) disabled @endif type="button" class="btn btn-default btn-sm" ng-click="open($event,'assignment_date_from')"><i class="glyphicon glyphicon-calendar"></i></button>
						 		</span>
						 	</p>
						    <p class="input-group">
			              		<input type="text" id="assignment_date_to" name="assignment_date_to" show-weeks="true" ng-click="open($event,'assignment_date_to')" class="form-control ng-pristine ng-untouched ng-valid ng-isolate-scope ng-valid-date" uib-datepicker-popup="MM/dd/yyyy" ng-model="to" is-open="assignment_date_to" datepicker-options="dateOptions" close-text="Close" placeholder="To" onkeydown="return false;" {{$readOnly}}><!-- ngIf: isOpen -->
			              		<span class="input-group-btn">
			                		<button @if($readOnly) disabled @endif type="button" class="btn btn-default btn-sm" ng-click="open($event,'assignment_date_to')"><i class="glyphicon glyphicon-calendar"></i></button>
			              		</span>
			                </p>
			                <p class="indent error hide" id="assignment_date_error">Invalid date range.</p>				
			                </div>
             			</div>											
					</div>

					@if($navigationActions['can_save_profile'])
					<div class="rs-mini-toolbar">
						<div class="rs-toolbar-savebtn">
							<a ng-click="save(true,true)" class="button-primary revgreen" href="javascript:void(0)" id="button_save_slide-tb" original-title="" style="display: block;"><i class="fa fa-floppy-o" style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>Save Profile</a>
						</div>					
					</div>
					@endif
				{!!Form::close()!!}
			</div>
		</div>
	</div>
</div>

@piechart('Desktop', 'chart-div')
@piechart('Mobile', 'chart-mobile-div')
