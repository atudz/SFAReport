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

<div class="row">
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
			
			<div class="bootstrap-table"><div class="fixed-table-toolbar"><div class="columns btn-group pull-right"><button class="btn btn-default" type="button" name="refresh" title="Refresh"><i class="glyphicon glyphicon-refresh icon-refresh"></i></button><button class="btn btn-default" type="button" name="toggle" title="Toggle"><i class="glyphicon glyphicon glyphicon-list-alt icon-list-alt"></i></button><div class="keep-open btn-group" title="Columns"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-th icon-th"></i> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li><label><input type="checkbox" data-field="id" value="1" checked="checked"> Item ID</label></li><li><label><input type="checkbox" data-field="name" value="2" checked="checked"> Item Name</label></li><li><label><input type="checkbox" data-field="price" value="3" checked="checked"> Item Price</label></li></ul></div></div><div class="pull-right search"><input class="form-control" type="text" placeholder="Search"></div></div><div class="fixed-table-container"><div class="fixed-table-header"><table></table></div><div class="fixed-table-body"><div class="fixed-table-loading" style="top: 37px; display: none;">Loading, please wait…</div><table data-toggle="table" data-url="tables/data1.json" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc" class="table table-hover">
						    <thead>
						    <tr><th class="bs-checkbox " style="width: 36px; "><div class="th-inner "><input name="btSelectAll" type="checkbox"></div><div class="fht-cell"></div></th><th style=""><div class="th-inner sortable">Item ID</div><div class="fht-cell"></div></th><th style=""><div class="th-inner sortable">Item Name<span class="order"><span class="caret" style="margin: 10px 5px;"></span></span></div><div class="fht-cell"></div></th><th style=""><div class="th-inner sortable">Item Price</div><div class="fht-cell"></div></th></tr>
						    </thead>
						<tbody><tr class="no-records-found"><td colspan="4">No matching records found</td></tr></tbody></table></div><div class="fixed-table-pagination"><div class="pull-left pagination-detail"><span class="pagination-info">Showing 1 to 0 of 0 rows</span><span class="page-list"><span class="btn-group dropup"><button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="page-size">10</span> <span class="caret"></span></button><ul class="dropdown-menu" role="menu"><li class="active"><a href="javascript:void(0)">10</a></li><li><a href="javascript:void(0)">25</a></li><li><a href="javascript:void(0)">50</a></li><li><a href="javascript:void(0)">100</a></li></ul></span> records per page</span></div><div class="pull-right pagination"><ul class="pagination"><li class="page-first disabled"><a href="javascript:void(0)">&lt;&lt;</a></li><li class="page-pre disabled"><a href="javascript:void(0)">&lt;</a></li><li class="page-next disabled"><a href="javascript:void(0)">&gt;</a></li><li class="page-last disabled"><a href="javascript:void(0)">&gt;&gt;</a></li></ul></div></div></div></div><div class="clearfix"></div>
		</div>
	</div>
</div>
