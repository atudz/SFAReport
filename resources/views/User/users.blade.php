{!!Html::breadcrumb(['User Management','User List'])!!}
{!!Html::pageheader('User List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::input('text','fullname','Full Name')!!}
						{!!Html::select('user_group_id','Role', $roles)!!}
					</div>					
					<div class="pull-right col-sm-6">
						{!!Html::datepicker('created_at','Date Created',true)!!}						
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				<div class="col-sm-12 table-options">
					<div class="pull-left">
						<div class="inner-addon left-addon">
						<i class="glyphicon glyphicon-search"></i>
							<input type="text" class="form-control input-sm" placeholder="Search" ng-model="query.$"/>
						</div>
			      	</div>
			      	
			      	<div class="pull-right">
			      		<a href="#user.add" class="btn btn-success btn-sm">New User</a>
			      	</div>
			    </div>
				{!!Html::topen(['no_search'=>true,'no_download'=>true])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
						<!-- Record list -->
						<tr ng-repeat="record in records|filter:query">
							<td>[[record.fullname]]</td>
							<td>[[record.role]]</td>
							<td>[[record.created_at]]</td>
							<td>
								<a href=""><i class="fa fa-pencil-square-o fa-lg"></i></a>
								<a href=""><i class="fa fa-lock fa-lg"></i></a>
								<a href=""><i class="fa fa-times fa-lg"></i></a>
							</td>
						</tr>						
					</tbody>
					{!!Html::tfooter(true,4)!!}					
				{!!Html::tclose()!!}
				
				
			</div>			
		</div>
	</div>
</div>
