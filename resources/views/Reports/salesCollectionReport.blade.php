<div class="row">
	<ol class="breadcrumb">
		<li><a href="#"><span class="glyphicon glyphicon-home"></span></a></li>
		<li class="active">Sales & Collection</li>
		<li class="active">Report</li>
	</ol>
</div><!--/.row-->

<div class="row">
	<div class="col-lg-12">
		<h4 class="page-header">Sales & Collection Report</h4>
	</div>
</div><!--/.row-->

<div class="row" data-ng-controller="SalesCollectionReport">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<h5>Filter Options</h5>
				<div class="filter">
					<form class="form-inline">
					  <div class="form-group">
					    <label class="sr-only" for="exampleInputEmail3">Email address</label>
					    <input type="email" class="form-control" id="exampleInputEmail3" placeholder="Email">
					  </div>
					  <div class="form-group">
					    <label class="sr-only" for="exampleInputPassword3">Password</label>
					    <input type="password" class="form-control" id="exampleInputPassword3" placeholder="Password">
					  </div>
					</form>
					<form class="form-inline">
					  <div class="form-group">
					    <label class="sr-only" for="exampleInputEmail3">Salesman</label>
					    <input type="text" class="form-control" id="exampleInputEmail3" placeholder="Salesman">
					  </div>
					  <div class="form-group">
					    <label class="sr-only" for="exampleInputPassword3">Company Code</label>
					    <input type="text" class="form-control" id="exampleInputPassword3" placeholder="Company Code">
					  </div>
					  <button type="submit" class="btn btn-default">Filter</button>
					</form>
				</div>
			</div>		
			
			
			<table>
			  <tr data-ng-repeat="x in records">
			    <td>[[ x.0 ]]</td>
			    <td>[[ x.1 ]]</td>
			  </tr>
			</table>
		</div>
	</div>
</div>
