{!!Html::breadcrumb(['My Profile'])!!}
{!!Html::pageheader('My Profile')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<h4>Personal Information</h4>
				<br />
				{!!Form::open(['url'=>'/controller/changepassword','class'=>'changepassword-form'])!!}
					<div class="form-group row">
						<label class="col-sm-2" for="firstname">First Name</label>
						<div class="col-sm-5">
					      <input type="text" name="firstname" id="firstname" class="form-control" placeholder="">
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="middlename">Middle Name</label>
						<div class="col-sm-5">
					      <input type="text" name="middlename" id="middlename" class="form-control" placeholder="">
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="lastname">Last Name</label>
						<div class="col-sm-5">
					      <input type="text" name="lastname" id="lastname" class="form-control" placeholder="">
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="address">Address</label>
						<div class="col-sm-5">
					      <input type="text" name="address" id="address" class="form-control" placeholder="">
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="email">Email Address</label>
						<div class="col-sm-5">
					      <input type="text" name="email" id="email" class="form-control" placeholder="">
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="telno">Tel No.:</label>
						<div class="col-sm-5">
					      <input type="text" name="telno" id="telno" class="form-control" placeholder="">
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="mobileno">Mobile No.:</label>
						<div class="col-sm-5">
					      <input type="text" name="mobileno" id="mobileno" class="form-control" placeholder="">
					    </div>
					</div>

					<hr />

					<h4>Credentials</h4>

					<div class="form-group row">
						<label class="col-sm-2" for="username">Username</label>
						<div class="col-sm-5">
							<input type="text" name="username" id="username" class="form-control" placeholder="">
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="username">Change Password</label>
						<div class="col-sm-5">
							<a href="#profile.changepassword">Click here to change password</a>
					    </div>
					</div>

					<hr />

					<h4>Access &amp; Location</h4>

					<div class="form-group row">
						<label class="col-sm-2" for="role">Role</label>
						<div class="col-sm-5">
								<select id="role" class="form-control">
									<option>Select</option>
								</select>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="branch">Branch</label>
						<div class="col-sm-5">
								<select id="branch" class="form-control">
									<option>Select</option>
								</select>
					    </div>
					</div>

					<div class="form-group row">
						<label class="col-sm-2" for="status">Status</label>
						<div class="col-sm-5">
								<select id="status" class="form-control">
									<option>Select</option>
								</select>
					    </div>
					</div>

					<hr />

					<h4>Assignment Options</h4>

					<div class="form-group row">
						<label class="col-sm-2" for="assignment">Option</label>
						<div class="col-sm-5">
								<select id="assignment" class="form-control">
									<option>Permanent</option>
									<option>Reassigned</option>
									<option>Temporary</option>
								</select>
					    </div>
					</div>


					<div class="rs-mini-toolbar">
						<div class="rs-toolbar-savebtn">
							<a class="button-primary revgreen" href="javascript:void(0)" id="button_save_slide-tb" original-title="" style="display: block;"><i class="fa fa-floppy-o" style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>Save Profile</a>
						</div>					
					</div>

				{!!Form::close()!!}
			</div>
		</div>
	</div>
</div>
