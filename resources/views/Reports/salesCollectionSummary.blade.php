{!!Html::breadcrumb(['Sales & Collection','Monthly Summary of Sales'])!!}
{!!Html::pageheader('Monthly Summary of Sales')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-6">
						{!!Html::select('salesman','Salesman', $salesman,'')!!}
						{!!Html::select('company_code','Company Code', $customerCode,'')!!}											
						{!!Html::select('area','Area', $area)!!}						
					</div>					
					<div class="col-md-6">														 			
						{!!Html::datepicker('invoice_date','Month',false,true)!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen()!!}
				<thead>
					<tr>
						<th rowspan="2" class="sortable" ng-click="sort('scr_number')" id="scr_number">SCR# <i class="fa fa-sort"></i></th>
						<th colspan="2" align="center">Invoice Number</th>
						<th rowspan="2" class="sortable" ng-click="sort('invoice_date')" id="invoice_date">Invoice Date <i class="fa fa-sort"></i></th>
						<th rowspan="2">Total Collected Amount</th>
						<th rowspan="2">12% Sales Tax</th>
						<th rowspan="2">Amount Subject To Commission</th>
					</tr>
					<tr>
						<th style="width:10%">From</th>
						<th style="width:10%">To</th>
					</tr>
				
				</thead>
					<tbody>
						<tr ng-repeat="record in records|filter:query | orderBy:propertyName:reverse">
							<td>[[record.scr_number]]</td>
							<td>[[record.invoice_number_from | uppercase]]</td>
							<td>[[record.invoice_number_to | uppercase]]</td>
							<td>
								<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
							</td>
							<td>
								<span ng-bind="record.total_collected_amount_formatted = negate(record.total_collected_amount)"></span>
							</td>
							<td>
								<span ng-bind="record.sales_tax_formatted = negate(record.sales_tax)"></span>
							</td>
							<td>
								<span ng-bind="record.amt_to_commission_formatted = negate(record.amt_to_commission)"></span>
							</td>
															
						</tr>	
						
						<!-- Summary -->
						<tr id="total_summary">
							<td class="bold">Total</td>
							<td></td>
							<td></td>
							<td></td>
							<td class="bold">
								<span ng-bind="record.total_collected_amount_formatted = negate(summary.total_collected_amount)"></span>
							</td>
							<td class="bold">
								<span ng-bind="record.sales_tax_formatted = negate(summary.sales_tax)"></span>
							</td>
							<td class="bold">
								<span ng-bind="record.amt_to_commission_formatted = negate(summary.amt_to_commission)"></span>
							</td>										
						</tr>
					</tbody>
					{!!Html::tfooter(true,8)!!}
				{!!Html::tclose()!!}
			</div>			
		</div>
	</div>
</div>
