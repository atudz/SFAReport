{!!Html::breadcrumb(['Sales & Collection','Reports'])!!}
{!!Html::pageheader('Sales & Collection Report')!!}

<div class="row" data-ng-controller="SalesCollectionReport">
	<div class="col-sm-12">
		<div class="panel panel-default">
		<div class="panel-body">		
			<!-- Filter -->
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
			<!-- End Filter -->
			
			{!!Html::topen(['st-table'=>'records'])!!}
				{!!Html::theader($tableHeaders)!!}
				<tbody>
				<tr ng-repeat="record in records" st-select-row="row" st-select-mode="multiple">
					<td>[[record.a1]]</td>
					<td>[[record.a2]]</td>
					<td>[[record.a3]]</td>
					<td>[[record.a4]]</td>
					<td>[[record.a5]]</td>
					<td>[[record.a6]]</td>
					<td>[[record.a7]]</td>
					<td>[[record.a8]]</td>
					<td>[[record.a9]]</td>
					<td>[[record.a10]]</td>
					<td>[[record.a11]]</td>
					<td>[[record.a12]]</td>
					<td>[[record.a13]]</td>
					<td>[[record.a14]]</td>
					<td>[[record.a15]]</td>
					<td>[[record.a16]]</td>
					<td>[[record.a17]]</td>
					<td>[[record.a18]]</td>
					<td>[[record.a19]]</td>
					<td>[[record.a20]]</td>
					<td>[[record.a21]]</td>
					<td>[[record.a22]]</td>
					<td>[[record.a23]]</td>
					<td>[[record.a24]]</td>
					<td>[[record.a25]]</td>
					<td>[[record.a26]]</td>
					<td>[[record.a27]]</td>									
				</tr>
				</tbody>
			{!!Html::tclose()!!}
			<div class="col-sm-12 fixed-table-pagination">
				<div class="pull-left pagination-detail">
				<span class="pagination-info">Showing 1 to 0 of 0 rows&nbsp;</span>
				<span class="page-list">
					<span class="btn-group dropup">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
							<span class="page-size">10</span> 
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li class="active"><a href="javascript:void(0)">10</a></li>
							<li><a href="javascript:void(0)">25</a></li>
							<li><a href="javascript:void(0)">50</a></li>
							<li><a href="javascript:void(0)">100</a></li>
						</ul>
					</span> records per page
				</span>
				</div>	
				
				<div class="pull-right pagination">
					<ul class="pagination">
						<li class="page-first disabled"><a href="javascript:void(0)">&lt;&lt;</a></li>
						<li class="page-pre disabled"><a href="javascript:void(0)">&lt;</a></li>
						<li class="page-next disabled"><a href="javascript:void(0)">&gt;</a></li>
						<li class="page-last disabled"><a href="javascript:void(0)">&gt;&gt;</a></li>
					</ul>
				</div>
			</div>				
		</div>		
		</div>		
	</div>
</div>
