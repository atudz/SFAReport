{!!Html::breadcrumb(['Sales & Collection','Reports'])!!}
{!!Html::pageheader('Sales & Collection Report')!!}

<div class="row" data-ng-controller="SalesCollectionReport">
	<div class="col-sm-12">
		<div class="panel panel-default">
		<div class="panel-body">		
			{!!Html::fopen('Toggle Filter')!!}
				<div class="pull-left col-sm-6">
					{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
					{!!Html::datepicker('collection_date','Collection Date','true')!!}
				</div>					
				<div class="pull-right col-sm-6">	
					{!!Html::select('customer_code','Customer Code', $customerCode)!!}
					{!!Html::select('salesman','Salesman', $salesman)!!}							 			
					{!!Html::datepicker('posting_date','Posting Date','true')!!}
				</div>			
			{!!Html::fclose()!!}
			
			<div class="col-sm-12">
							
				<table st-table="displayedCollection" st-safe-src="rowCollection" class="table table-striped table-condensed">
					<thead>
					<tr>
						<th colspan="5">
							<div class="form-group col-sm-3 filter">
						        <div class="inner-addon right-addon">
						          <i class="glyphicon glyphicon-search"></i>
						          <input type="text" st-search="" class="form-control" placeholder="Search" />
						        </div>
			      			</div>
						</th>
					</tr>
					<tr>
						<th st-sort="firstName">first name</th>
						<th st-sort="lastName">last name</th>
						<th st-sort="birthDate">birth date</th>
						<th st-sort="balance">balance</th>
					</tr>			
					</thead>
					<tbody>
					<tr ng-repeat="row in displayedCollection" st-select-row="row" st-select-mode="multiple">
						<td>[[row.firstName]]</td>
						<td>[[row.lastName]]</td>
						<td>[[row.birthDate]]</td>
						<td>[[row.balance]]</td>
						<td>
						<button type="button" ng-click="removeItem(row)" class="btn btn-sm btn-danger">
							<i class="glyphicon glyphicon-remove-circle">
							</i>
						</button>
						</td>
					</tr>
					</tbody>
				</table>
				
			</div>
		</div>		
		</div>		
	</div>
</div>
