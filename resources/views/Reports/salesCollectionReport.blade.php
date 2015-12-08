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
				<tr ng-repeat="record in records|filter:query">
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
	
		</div>		
		</div>		
	</div>
</div>
