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
					{!!Html::select('customer_code','Customer Code', ['Name1','Name2'])!!}
					{!!Html::select('salesman','Salesman', ['Name1','Name2'])!!}							 			
					{!!Html::datepicker('posting_date','Posting Date','true')!!}
				</div>			
			{!!Html::fclose()!!}
			
			<div>
				<div class="col-sm-12">
					<div class="form-group col-sm-4">
				        <div class="inner-addon right-addon">
				          <i class="glyphicon glyphicon-search"></i>
				          <input type="text" class="form-control" placeholder="Search" />
				        </div>
	      			</div>
	      			
				</div>
				
				<div class="table-responsive">
				<!-- 	
					<div ng-controller="demoController as demo">
    <h2 class="page-header">Loading data - managed array</h2>
    <div class="bs-callout bs-callout-info">
      <h4>Overview</h4>
      <p>When you have the <em>entire</em> dataset available in-memory you can hand this to <code>NgTableParams</code> to manage the filtering, sorting and paging of that array</p>
    </div>
    <table ng-table="demo.tableParams" class="table table-condensed table-bordered table-striped">
      <tr ng-repeat="row in $data">
        <td data-title="'Name'" filter="{name: 'text'}" sortable="'name'">[[row.name]]</td>
        <td data-title="'Age'" filter="{age: 'number'}" sortable="'age'">[[row.age]]</td>
        <td data-title="'Money'" filter="{money: 'number'}" sortable="'money'">[[row.money]]</td>
      </tr>
    </table>
  </div> -->
  				
					
					
					
					
				</div>
			</div>
		</div>		
		</div>		
	</div>
</div>
