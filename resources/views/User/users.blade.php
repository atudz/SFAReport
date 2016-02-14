{!!Html::breadcrumb(['User Management','User List'])!!}
{!!Html::pageheader('User List')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6 col-xs-12">
						{!!Html::input('text','fullname','Full Name')!!}
						{!!Html::select('user_group_id','Role', $roles)!!}
						{!!Html::select('location_assignment_code','Branch', $areas)!!}						
					</div>					
					<div class="pull-right col-sm-6 col-xs-12">
						{!!Html::datepicker('created_at','Date Created',true)!!}		
						{!!Html::select('location_assignment_type','Assignment', $assignmentOptions)!!}				
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
			      		<a href="#user.add" class="btn btn-success btn-sm">Add New User</a>
			      	</div>
			    </div>
				{!!Html::topen(['no_search'=>true,'no_download'=>true])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
						<!-- Record list -->
						<tr ng-repeat="record in records|filter:query" id="[[record.id]]">
							<td>[[record.fullname]]</td>
							<td>[[record.email]]</td>
							<td>[[record.role]]</td>
							<td>[[record.area_name]]</td>
							<td>[[record.assignment]]</td>
							<td>[[record.created_at]]</td>
							<td>
								<a href="#user.edit/[[record.id]]" uib-tooltip="Edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
								<a style="cursor:pointer" id="active_link" ng-show="!record.active" ng-click="activate(record.id,$index)"><i class="fa fa-unlock-alt fa-lg" uib-tooltip="Activate"></i></a>
								<a style="cursor:pointer" id="inactive_link" ng-show="record.active" ng-click="deactivate(record.id,$index)"><i class="fa fa-lock fa-lg" uib-tooltip="Deactivate"></i></a>
								<a style="cursor:pointer" ng-click="remove(record.id)"><i class="fa fa-times fa-lg" uib-tooltip="Delete"></i></a>
							</td>
						</tr>						
					</tbody>
					{!!Html::tfooter(true,7)!!}					
				{!!Html::tclose()!!}
				
				
			</div>			
		</div>
	</div>
</div>
