{!!Html::breadcrumb(['Sales & Collection','Check Payments'])!!}
{!!Html::pageheader('Check Payments')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
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
						{!!Html::datepicker('or_date','Collection Date',true)!!}									
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
						@if($isAdmin || $isAuditor)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','bank',record.collection_detail_id,record.bank,$index,'Bank Name','bank')">
	    						[[record.bank | uppercase]]
	  						</a>
	  					@else
	  						[[record.bank | uppercase]]
	  					@endif
					</td>
					<td>
						@if($isAdmin || $isAuditor)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','check_number',record.collection_detail_id,record.check_number,$index,'Check No','check_number')">
	    						[[record.check_number]]
	  						</a>
	  					@else
	  						[[record.check_number]]
	  					@endif
					</td>
					<td>
						@if($isAdmin || $isAuditor)
							<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_detail','check_date',record.collection_detail_id,record.check_date,$index,'Check Date','check_date')">
	    						<span ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
	  						</a>						
	  					@else
	  						<span ng-bind="record.check_date_formatted = (formatDate(record.check_date) | date:'MM/dd/yyyy')"></span>
	  					@endif	
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
					<td>[[ record.delete_remarks ]]</td>									
				</tr>
				
				<!-- Summary -->
				<tr id="total_summary">
					<td class="bold">Total</td>
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
						<span>[[formatNumber(summary.payment_amount)]]</span>						
					</td>			
					<td></td>						
				</tr>
				</tbody>
				{!!Html::tfooter(true,14)!!}
			{!!Html::tclose(false)!!}
						
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
					$('#customer_code').append($("<option></option>").attr("value", '').text('All'));
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
