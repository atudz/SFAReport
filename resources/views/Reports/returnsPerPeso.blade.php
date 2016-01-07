{!!Html::breadcrumb(['Sales Report','Returns (Per Peso)'])!!}
{!!Html::pageheader('Returns (Per Peso)')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::datepicker('posting_date','Posting Date',true)!!}
						{!!Html::datepicker('return_date','Return Date',true)!!}
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::select('salesman_code','Salesman', $salesman)!!}
						{!!Html::select('area','Area', $areas)!!}
						{!!Html::select('company_code','Company', $companyCode)!!}													 			
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
					<tr ng-repeat="record in records|filter:query" class=[[record.updated]]>
						<td>[[record.return_txn_number]]</td>
						<td>[[record.reference_num]]</td>
						<td>[[record.activity_code]]</td>
						<td>[[record.customer_code]]</td>
						<td>[[record.customer_name]]</td>
						<td>[[record.remarks]]</td>
						<td>[[record.van_code]]</td>
						<td>[[record.device_code]]</td>
						<td>[[record.salesman_code]]</td>
						<td>[[record.salesman_name]]</td>
						<td>[[record.area]]</td>
						<td>[[record.return_slip_num]]</td>
						<td>
							<span ng-bind="formatDate(record.return_date) | date:'MM/dd/yyyy'"></span>
						</td>
						<td>
							<span ng-bind="formatDate(record.return_posting_date) | date:'MM/dd/yyyy'"></span>
						</td>
						<td>
							<span ng-bind="formatNumber(record.gross_seved_amount)"></span>
						</td>
						<td>
							<span ng-bind="formatNumber(record.vat_amount)"></span>
						</td>
						<td>[[record.discount_rate]]</td>
						<td>
							<span ng-bind="formatNumber(record.discount_amount)"></span>
						</td>
						<td>[[record.collective_discount_rate]]</td>
						<td>
							<span ng-bind="formatNumber(record.collective_discount_amount)"></span>
						</td>
						<td>[[record.discount_reference_num]]</td>
						<td>[[record.discount_remarks]]</td>						
						<td>
							<span ng-bind="formatNumber(record.total_invoice)"></span>
						</td>
					</tr>
					
					<!-- Summary Total -->
					<tr id="total_summary">
						<th>Total</th>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>						
						<td></td>												
						<td></td>
						<th>
							<span ng-bind="formatNumber(summary.gross_seved_amount)"></span>
						</th>
						<th>
							<span ng-bind="formatNumber(summary.vat_amount)"></span>
						</th>
						<td></td>
						<th>
							<span ng-bind="formatNumber(summary.discount_amount,true)"></span>
						</th>
						<td>[[record.collective_discount_rate]]</td>
						<th>
							<span ng-bind="formatNumber(summary.collective_discount_amount,true)"></span>
						</th>
						<td></td>
						<td></td>						
						<th>
							<span ng-bind="formatNumber(summary.total_invoice)"></span>
						</th>
					</tr>
					
					</tbody>
					{!!Html::tfooter(true,23)!!}
				{!!Html::tclose()!!}
			
			</div>			
		</div>
	</div>
</div>
