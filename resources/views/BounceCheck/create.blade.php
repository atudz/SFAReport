{!!Html::breadcrumb(['Bounce Check Report'])!!}
{!!Html::pageheader('Add Row')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<div class="row">
					<div class="col-md-12">
						<div class="pull-left">
							<h4>Bounce Check</h4>
						</div>					
						<div class="pull-right">
				      		<a href="#bounce.check" class="btn btn-success btn-sm">Back to Bounce Check Report</a>
				      	</div>
					</div>
				</div>
				<div class="clearfix">
				
				<div class="col-md-12 well">
					<div class="row">															
						<div class ="col-md-8">
							<input id="id" type="hidden" name="id" value="{{(int)$bounceCheck->id}}">
							<input id="area" type="hidden" name="id" value="{{$bounceCheck && $bounceCheck->area ? $bounceCheck->area->area_name : ''}}">
							<div class="row form-input-field">
								{!!Html::select('salesman_code','Sr. Salesman <span class="required">*</span>', $salesman, 'Select Sr. Salesman',['onblur'=>'validate(this)','onchange'=>'set_customer(this)'],$bounceCheck->salesman_code)!!}
							</div>							
							<div class="row form-input-field">
								{!!Html::input('text','jr_salesman_code','Jr. Salesman',$bounceCheck->id ? $bounceCheck->jr_salesman->fullname: 'No Jr.Salesman',['disabled'=>true])!!}								
							</div>													
							<div class="row form-input-field">
								@if($bounceCheck->id)
									{!!Html::select('customer_code','Customer <span class="required">*</span>', salesman_customer($bounceCheck->salesman_code), '',['onblur'=>'validate(this)','onchange'=>'set_area(this)'],$bounceCheck->customer_code)!!}
								@else
									{!!Html::select('customer_code','Customer <span class="required">*</span>', [], 'Customer',['onblur'=>'validate(this)','disabled'=>true,'onchange'=>'set_area(this)'])!!}
								@endif
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','dm_number','DM No. <span class="required">*</span>',$bounceCheck->dm_number,['onblur'=>'validate(this)'])!!}								
							</div>
							<div class="row form-input-field">								
								{!!Html::datepicker('dm_date','DM Date <span class="required">*</span>',false,false,$bounceCheck->dm_date)!!}
							</div>							
							<div class="row form-input-field">
								{!!Html::input('text','invoice_number','Invoice No. <span class="required">*</span>',$bounceCheck->invoice_number,['onblur'=>'validate(this)'])!!}								
							</div>
							<div class="row form-input-field">								
								{!!Html::datepicker('invoice_date','Invoice Date <span class="required">*</span>',false,false,$bounceCheck->dm_date)!!}
							</div>							
							<div class="row form-input-field">
								{!!Html::input('text','bank_name','Bank Name <span class="required">*</span>',$bounceCheck->bank_name,['onblur'=>'validate(this)'])!!}								
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','cheque_number','Check No. <span class="required">*</span>',$bounceCheck->cheque_number,['onblur'=>'validate(this)'])!!}								
							</div>
							<div class="row form-input-field">								
								{!!Html::datepicker('cheque_date','Check Date <span class="required">*</span>',false,false,$bounceCheck->cheque_date)!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','account_number','Account No. <span class="required">*</span>',$bounceCheck->account_number,['onblur'=>'validate(this)'])!!}								
							</div>							
							<div class="row form-input-field">
								{!!Html::input('text','reason','Reason <span class="required">*</span>',$bounceCheck->reason,['onblur'=>'validate(this)'])!!}								
							</div>
							<div class="row form-input-field">
								{!!Html::input('number','original_amount','Original Amount <span class="required">*</span>',$bounceCheck->original_amount,['onblur'=>'validate(this)','oninput'=>'compute_balance()'])!!}								
							</div>
							<div class="row form-input-field">
								{!!Html::input('number','payment_amount','Payment Amount <span class="required">*</span>',$bounceCheck->payment_amount,['onblur'=>'validate(this)','oninput'=>'compute_balance()'])!!}								
							</div>
							<div class="row form-input-field">								
								{!!Html::datepicker('payment_date','Payment Date <span class="required">*</span>',false,false,$bounceCheck->payment_date)!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','remarks','Remarks <span class="required">*</span>',$bounceCheck->remarks,['onblur'=>'validate(this)'])!!}								
							</div>
							<div class="row form-input-field">
								{!!Html::input('number','balance_amount','Balance Amount',(int)$bounceCheck->balance_amount,['onblur'=>'validate(this)','disabled'=>true])!!}								
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','txn_number','Transaction Number',$txn_code,['onblur'=>'validate(this)','disabled'=>true])!!}								
							</div>	
							<div class="row form-input-field">
								<div class="col-md-4 col-md-offset-4">
									<button class="btn btn-info" onclick="preview()">Preview</button> &nbsp;&nbsp;
									@if($bounceCheck->id)
										<button class="btn btn-info" onclick="add_payment()">Add Payment</button>
									@endif
								</div>
							</div>						
						</div>
					</div>
					
					<div class="hidden" id="preview">
					<h4>Table Preview</h4>					
					<div class="row" id="preview">
						<div class="col-md-12 table-responsive">
							<table class="table table-striped table-condensed table-bordered" id="table_items">
								<thead>
									<tr>
										@foreach($tableHeaders as $row)
											<th>{{$row['name']}}</th>
										@endforeach
									</tr>
								</thead>
								<tbody>
									
									@if(false)
										@foreach($replenishment->items as $k=>$item)
											<tr>
												<td class="txn_number"></td>
												<td class="salesman_code"></td>
												<td class="jr_salesman_code"></td>
												<td class="area"></td>
												<td class="customer_code"></td>																								
												<td class="original_amount"></td>
												<td class="balance_amount"></td>
												<td class="payment_amount"></td>
												<td class="payment_date_from"></td>
												<td class="remarks"></td>												
												<td class="dm_number"></td>
												<td class="dm_date_from"></td>
												<td class="invoice_date_from"></td>
												<td class="invoice_number"></td>												
												<td class="bank_name"></td>
												<td class="cheque_date_from"></td>
												<td class="cheque_number"></td>												
												<td class="account_number"></td>
												<td class="reason"></td>
											</tr>
										@endforeach
									@else
										<tr>
												<td class="txn_number"></td>
												<td class="salesman_code"></td>
												<td class="jr_salesman_code"></td>
												<td class="area"></td>
												<td class="customer_code"></td>												
												<td class="original_amount"></td>
												<td class="balance_amount"></td>
												<td class="payment_amount"></td>
												<td class="payment_date_from"></td>
												<td class="remarks"></td>												
												<td class="dm_number"></td>
												<td class="dm_date_from"></td>
												<td class="invoice_date_from"></td>
												<td class="invoice_number"></td>												
												<td class="bank_name"></td>
												<td class="cheque_date_from"></td>
												<td class="cheque_number"></td>												
												<td class="account_number"></td>
												<td class="reason"></td>
										</tr>
									@endif
								</tbody>								
							</table>						
						</div>
					</div>
					</div>
					
					<div class="col-md-4 col-md-offset-4" style="padding-top:10px;">
						<button class="btn btn-success" ng-click="save()">Save</button>&nbsp;&nbsp;						
						<a href="#bounce.check" class="btn btn-warning">Cancel</a>&nbsp;&nbsp;						
						@if($bounceCheck->id)
							<button class="btn btn-danger" ng-click="remove()">Delete</button>&nbsp;&nbsp;
						@endif						
					</div>															
			</div>		
		</div>
	</div>
</div>


<script type="text/ng-template" id="DeleteBounceCheck">
 	<div class="modal-body">
		<form class="form-horizontal">	 
			<h4>Deleting Bounce Check - [[params.txn_number]]</h4>       		 
			<div class="form-group">
				<label class="col-sm-3">Remarks:</label>
				<div class="col-sm-9">
					<textarea class="form-control inner-addon fxresize" maxlength="150" name="comment" rows="5" id="comment" onblur="validate(this)"></textarea>
					<span class="help-block"></span>
				</div>
			</div>						  
			<div class="form-group">
				<div class="col-sm-12">
					<div class="pull-right">	
						<button class="btn btn-success" type="button btn-sm" ng-click="save()">Submit</button>
						<button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>	
					</div>
				</div>
			</div>
		</form>										 					
	</div>			    			
</script>

<script>

	function set_area_by_code(code)
	{		
		var url = 'reports/customer/area/'+code;
		$.get(url,function(data){				
			if(data){										
				$('#area').val(data);										
			}			
		});			
	}

	function set_area(el)
	{
		var sel = $(el).val();	
		if(!sel){
			$('#area').val('');
		}
		else{
			var url = 'reports/customer/area/'+sel;
			$.get(url,function(data){				
				if(data){										
					$('#area').val(data);										
				}			
			});	
		}
		
	}


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

	function add_payment()
	{		
		$('#payment_amount').val('0.00');
		$('#payment_date_from').val('');		
		$('#remarks').val('');
		$('#id').val(0);
		var txn = $('#txn_number').val();
		var count = {{$max_count}} + 1;
		if(-1 == txn.indexOf('-')){
			$('#txn_number').val(txn+'-'+count);
		} else {
			var chunks = txn.split('-');
			var counter = parseInt(chunks[1]) + 1;
			$('#txn_number').val(chunks[0]+'-'+count);
		}
	}
	
	function compute_balance()
	{
		var payments = {{$payments}};
		var original_amount = parseFloat($('#original_amount').val());
		var payment_amount = parseFloat($('#payment_amount').val());
		var balance = original_amount - payment_amount - payments;		
		$('#balance_amount').val(balance.toFixed(2));
	}
	
	function preview()
	{
		$('#preview').removeClass('hidden');
		var tds = $('#table_items tr:nth-child(1)').find('td');
		$(tds).each(function(k,val){
			var id = $(this).attr('class');
			var val = $('#'+id).val();
			if(val) {
				$(this).text(val);
			}			
		});
	}
</script>

