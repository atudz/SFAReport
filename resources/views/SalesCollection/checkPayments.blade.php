{!!Html::breadcrumb(['Sales & Collection','Check Payments'])!!}
{!!Html::pageheader('Check Payments')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">	
							{!!Html::select('salesman','Salesman', $salesman,'',['onchange'=>'set_customer(this)'])!!}
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
				@endif

				@if($navigationActions['show_table'])
					{!!Html::topen([
						'show_download' => $navigationActions['show_download'],
						'show_print'    => $navigationActions['show_print'],
						'show_search'   => $navigationActions['show_search_field'],
					])!!}
						{!!Html::theader($tableHeaders)!!}
						<tbody>
							<tr ng-repeat="record in records|filter:query" id=[[$index]]>
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
								<td id="[[$index]]-bank_updated" class=[[record.bank_updated]]>
									@if($isAdmin || $isAuditor)
										<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','bank',record.collection_detail_id,record.bank,$index,'Bank Name','bank','','','','bank_updated','check-payments')">
				    						<span ng-if="record.bank.trim() != '' || record.bank != null">[[record.bank | uppercase]]</span>
		    								<span ng-if="record.bank.trim() == '' || record.bank == null">Edit Bank Name</span>
				  						</a>
				  					@else
				  						[[record.bank | uppercase]]
				  					@endif
								</td>
								<td>[[record.check_number | uppercase]]</td>
								<td>
									<span ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
								</td>
								<td id="[[$index]]-payment_amount_updated" class=[[record.payment_amount_updated]]>
									@if($navigationActions['show_check_amount_column'] && $navigationActions['edit_check_amount_column'])
										<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','payment_amount',record.collection_detail_id,record.payment_amount,$index,'Payment Amount','payment_amount','','','','payment_amount_updated','check-payments')" ng-if="record.closed_period == 0">
				    						<span ng-if="record.payment_amount.trim() != '' || record.payment_amount > 0 || record.payment_amount != null" ng-bind="record.payment_amount_formatted = formatNumber(record.payment_amount)"></span>
    										<span ng-if="record.payment_amount.trim() == '' || record.payment_amount == 0 || record.payment_amount == null">Edit Payment Amount</span>
				  						</a>						
			    						<span ng-if="record.closed_period == 1" ng-bind="record.payment_amount_formatted = formatNumber(record.payment_amount)"></span>
				  					@endif
				  					@if($navigationActions['show_check_amount_column'] && !$navigationActions['edit_check_amount_column'])
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
								<td class="bold">
									<span>[[formatNumber(summary.total_invoice_net_amount)]]</span>
								</td>
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
				@endif
			</div>			
		</div>
	</div>
</div>

<script>
	function set_customer(el)
	{
		var sel = $(el).val();
		if(!sel){
			$('#customer_code').empty();
			$('#customer_code')
				.append($("<option></option>")
				.attr("value", '').text('Select Salesman'));
			$('#customer_code').attr('disabled',true);
			$('#jr_salesman_code').val('No Jr. Salesman');
			$('#area').val('');			
		}
		else{
			var url = 'reports/salesman/customer/'+sel;
			$.get(url,function(data){
				if(data){
					$('#customer_code').empty();
					$.each(data, function(k,v){
						$('#customer_code')
							.append($("<option></option>")
							.attr("value", k).text(v));
					});
					$('#customer_code').removeAttr('disabled');
				}			
			});
	
			var url2 = 'reports/salesman/jr/'+sel;
			$.get(url2,function(data){				
				if(data){
					$('#jr_salesman_code').val(data);
				} else {
					$('#jr_salesman_code').val('No Jr. Salesman');
				}			
			});
	
			$('#customer_code').trigger('change');
		}
	}	

</script>
