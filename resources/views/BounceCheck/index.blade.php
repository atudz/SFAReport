{!!Html::breadcrumb(['Bounce Check Report'])!!}
{!!Html::pageheader('Bounce Check Report')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-6">	
						{!!Html::select('salesman_code','Salesman', $salesman,$isSalesman ? '' : 'All',['onchange'=>'set_customer(this)'])!!}
						{!!Html::select('area_code','Area', $areas)!!}
						{!!Html::select('customer_code','Customer Name', $customers)!!}
						{!!Html::input('text','txn_number','Transaction No.')!!}																					
					</div>			
					<div class="col-md-6">	
						{!!Html::datepicker('invoice_date','Invoice Date',false)!!}
						{!!Html::datepicker('dm_date','DM Date',false)!!}	
						{!!Html::input('text','reason','Reason')!!}										
					</div>
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen(['no_download'=>$isGuest2,'no_pdf'=>$isGuest1,'add_link'=>'bouncecheck.add'])!!}
					{!!Html::theader($tableHeaders)!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
							<td>[[record.txn_number]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.jr_salesman]]</td>
							<td>[[record.area_name]]</td>
							<td>[[record.customer_name]]</td>
							<td>[[record.original_amount]]</td>
							<td>[[record.balance_amount]]</td>
							<td>[[record.payment_amount]]</td>
							<td>
								<span ng-bind="payment_date = (formatDate(record.payment_date) | date:'MM/dd/yyyy hh:mm a')"></span>
							</td>
							<td>[[record.remarks]]</td>
							<td>[[record.dm_number]]</td>
							<td>
								<span ng-bind="dm_date = (formatDate(record.dm_date) | date:'MM/dd/yyyy hh:mm a')"></span>
							</td>
							<td>[[record.invoice_number]]</td>
							<td>
								<span ng-bind="invoice_date = (formatDate(record.invoice_date) | date:'MM/dd/yyyy hh:mm a')"></span>
							</td>
							<td>[[record.bank_name]]</td>							
							<td>[[record.cheque_number]]</td>
							<td>
								<span ng-bind="cheque_date = (formatDate(record.cheque_date) | date:'MM/dd/yyyy hh:mm a')"></span>
							</td>
							
							<td>[[record.account_number]]</td>														
							<td>[[record.reason]]</td>							
							<td>[[record.username]]</td>
							<td align="center">
								<a href="#bouncecheck.edit/[[record.id]]"><i class="fa fa-pencil-square-o fa-lg"></i></a>								
							</td>
						</tr>									
					</tbody>				
					{!!Html::tfooter(true,20)!!}
				{!!Html::tclose()!!}			
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
