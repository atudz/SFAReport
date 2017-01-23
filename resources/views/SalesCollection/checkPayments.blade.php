{!!Html::breadcrumb(['Sales & Collection','Check Payments'])!!}
{!!Html::pageheader('Check Payments')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-6">	
						{!!Html::select('salesman','Salesman', $salesman,'')!!}
						{!!Html::select('company_code','Company Code', $companyCode,'')!!}
						{!!Html::select('area_code','Area', $areas)!!}
						{!!Html::select('customer_code','Customer Name', $customers)!!}																										
					</div>			
					<div class="col-md-6">	
						{!!Html::datepicker('invoice_date','Invoice Date',true)!!}
						{!!Html::datepicker('or_date','Or Date',true)!!}									
					</div>
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen(['no_download'=>$isGuest2,'no_pdf'=>($isGuest1 || $isManager)])!!}
				{!!Html::theader($tableHeaders)!!}
				<tbody>
				<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">[[record.customer_code]]</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">[[record.customer_name]]</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">[[record.customer_address]]</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">[[ record.remarks ]]</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">[[ record.invoice_number | uppercase ]]</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>	  					
					</td>					
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="record.total_invoice_net_amount_formatted = negate(record.total_invoice_net_amount)"></span>
					</td>					
					<td>
						<span ng-bind="record.or_date_formatted = (formatDate(record.or_date) | date:'MM/dd/yyyy')"></span>	  					
					</td>
					<td>[[record.or_number | uppercase]]</td>
					<td>
						<span ng-bind="record.cm_date_formatted = (formatDate(record.cm_date) | date:'MM/dd/yyyy')"></span>
					</td>
					<td>[[record.bank | uppercase]]</td>
					<td>[[record.check_number | uppercase]]</td>
					<td>
						<span ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
					</td>
					<td>
						@if($isAdmin || $isAuditor)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','payment_amount',record.collection_detail_id,record.payment_amount,$index,'Payment Amount','payment_amount')">
	    						<span ng-bind="record.payment_amount_formatted = formatNumber(record.payment_amount)"></span>
	  						</a>						
	  					@else
	  						<span ng-bind="record.payment_amount_formatted = formatNumber(record.payment_amount)"></span>
	  					@endif
						
					</td>									
				</tr>
				
				<!-- Summary -->
				<tr id="total_summary">
					<td class="bold">Total</td>
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
					<td class="bold">
						<span ng-bind="summary.payment_amount = negate(summary.payment_amount)"></span>						
					</td>									
				</tr>
				</tbody>
				{!!Html::tfooter(true,14)!!}
			{!!Html::tclose(false)!!}
						
			</div>			
		</div>
	</div>
</div>
