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

		<div class="table-responsive">
				<div class="columns btn-group pull-left"><button class="btn btn-default" type="button" name="refresh" title="Refresh"><i class="glyphicon glyphicon-refresh icon-refresh"></i></button><button class="btn btn-default" type="button" name="toggle" title="Toggle"><i class="glyphicon glyphicon glyphicon-list-alt icon-list-alt"></i></button><div class="keep-open btn-group" title="Columns"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th icon-th"></i> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><label><input type="checkbox" data-field="id" value="1" checked="checked"> Item ID</label></li><li><label><input type="checkbox" data-field="name" value="2" checked="checked"> Item Name</label></li><li><label><input type="checkbox" data-field="price" value="3" checked="checked"> Item Price</label></li></ul></div></div>
				<div class="pull-left search"><input class="form-control" type="text" placeholder="Search"></div>				
				<table st-table="records" class="table table-bordered table-condensed table-striped">
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
						    <td><a href="#" editable-text="x.a1" onbeforesave="update(this)">[[ x.a1 || 'empty' ]]</a></td>
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
