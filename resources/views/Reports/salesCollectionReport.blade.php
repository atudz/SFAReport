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

				<div class="clearfix"><br /></div>
		<div style="width:100%; overflow-x:scroll; overflow-y:hidden;">
				<table class="table table-bordered">
					<thead>
						<tr>
							<td>Customer Code</td>
							<td>Customer Name</td>
							<td>Remarks</td>
							<td>Invoice Number</td>
							<td>Invoice Date</td>
							<td>Total Invoice Gross Amt</td>
							<td>Invoice Discount Amount 1</td>
							<td>Invoice Discount Amount 2</td>
							<td>Total Invoice Amount</td>
							<td>CM Number</td>
							<td>Other Deduction Amount</td>
							<td>Return Slip Number</td>
							<td>Total Return Amount</td>
							<td>Return Discount Amount</td>
							<td>Return net amount</td>
							<td>Total Invoice Net Amount</td>
							<td>Collection Date</td>
							<td>OR Number</td>
							<td>Cash</td>
							<td>Cehck Amount</td>
							<td>Bank Name</td>
							<td>Check No</td>
							<td>Check Date</td>
							<td>CM No</td>
							<td>CM Date</td>
							<td>CM Amount</td>
							<td>Total Collected Amount</td>
						</tr>
					</thead>
					<tbody>
						<tr data-ng-repeat="x in records">
						    <td>[[ x.a1 ]]</td>
						    <td>[[ x.a2 ]]</td>
						    <td>[[ x.a3 ]]</td>
						    <td>[[ x.a4 ]]</td>
						    <td>[[ x.a5 ]]</td>
						    <td>[[ x.a6 ]]</td>
						    <td>[[ x.a7 ]]</td>
						    <td>[[ x.a8 ]]</td>
						    <td>[[ x.a9 ]]</td>
						    <td>[[ x.a10 ]]</td>
						    <td>[[ x.a11 ]]</td>
						    <td>[[ x.a12 ]]</td>
						    <td>[[ x.a13 ]]</td>
						    <td>[[ x.a14 ]]</td>
						    <td>[[ x.a15 ]]</td>
						    <td>[[ x.a16 ]]</td>
						    <td>[[ x.a17 ]]</td>
						    <td>[[ x.a18 ]]</td>
						    <td>[[ x.a19 ]]</td>
						    <td>[[ x.a20 ]]</td>
						    <td>[[ x.a21 ]]</td>
						    <td>[[ x.a22 ]]</td>
						    <td>[[ x.a23 ]]</td>
						    <td>[[ x.a24 ]]</td>
						    <td>[[ x.a25 ]]</td>
						    <td>[[ x.a26 ]]</td>
						    <td>[[ x.a27 ]]</td>
				  		</tr>			  
				  	</tbody>
				</table>
			</div>



			</div>		
		</div>
		
	</div>
</div>
