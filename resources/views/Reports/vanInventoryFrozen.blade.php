{!!Html::breadcrumb(['Van Inventory','Canned & Mixes'])!!}
{!!Html::pageheader('Frozen & Kassel')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::datepicker('transaction_date','Transaction Date','true')!!}
						{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::select('salesman','Salesman', $salesman)!!}							 			
						{!!Html::datepicker('posting_date','Posting Date','true')!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen(['no_download'=>true])!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query">
							<td>[[record.customer_name]]</td>
							<td>[[record.invoice_date]]</td>
							<td>[[record.invoice_number]]</td>
							<td>[[record.return_slip_num]]</td>
							<td>[[record.replenishment_date]]</td>
							<td>[[record.replenishment_number]]</td>
						</tr>
					</tbody>
				{!!Html::tclose()!!}
				
			</div>			
		</div>
	</div>
</div>
