{!!Html::breadcrumb(['Van Inventory','Actual Count Replenishment', 'Add Row'])!!}
{!!Html::pageheader('Add Row')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<div class="row">
					<div class="col-md-12">
						<div class="pull-left">
							<h4>Actual Count Replenishment</h4>
						</div>					
						<div class="pull-right">
				      		<a href="#vaninventory.stocktransfer" class="btn btn-success btn-sm">Back to Actual Count Replenishment</a>
				      	</div>
					</div>
				</div>
				<div class="clearfix">
				
				<div class="col-md-12 well">
					<div class="row">															
						<div class ="col-md-8">
							<div class="row form-input-field">
								{!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman, 'Select Salesman',['onblur'=>'validate(this)','onchange'=>'setSalesmanDetails(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::select('jr_salesman','Jr Salesman', $jrSalesmans, 'No Jr. Salesman',['disabled'=>1])!!}
							</div>						
							<div class="row form-input-field">
								{!!Html::select('van_code','Van Code', $vanCodes, 'No Van Code',['disabled'=>1])!!}
							</div>						
							<div class="row form-input-field">
								{!!Html::datepicker('replenishment_date','Count date/time <span class="required">*</span>')!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','reference_num','Count Sheet No. <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','counted','Counted <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','confirmed','Confirmed <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_sr','Last SR <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_rprr','Last RPRR <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_cash_slip','Last Cash Slip <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_delivery_receipt','Last Delivery Receipt <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_ddr','Last DDR <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>						
						</div>
					</div>
					
					<h4>Replenishment Items</h4>					
					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-condensed table-bordered" id="table_items">
								<thead>
									<tr>
										<th>Material Code</th>
										<th>Material Description</th>
										<th>Material Quantity</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="row in rows">
										<td>
											<div class="form-group">			 								
				 								<div class="col-xs-12 col-sm-8">
				 									{!!Form::select('item_code[]',$itemCodes,null,['class'=>'form-control','onchange'=>'setItem(this)'])!!}
				 								</div>
				 							</div>										
										</td>
										<td>
											<div class="form-group">			 								
				 								<div class="col-xs-12 col-sm-8">
				 									{!!Form::select('item[]',$items,null,['class'=>'form-control','disabled'=>true])!!}
				 								</div>
				 							</div>		
										</td>
										<td>
											<div class="form-group">			 								
				 								<div class="col-xs-12 col-sm-8">
				 									<input class="form-control" id="quantity" name="quantity[]" type="number" min="0"  value="0" onblur="validateQty(this)">
				 									<span class="help-block"></span>
				 								</div>
				 							</div>
										</td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3">
											<div class="text-center">
												<button class="btn btn-info" ng-click="add()">Add More</button>&nbsp;&nbsp;
											</div>
										</td>
									</tr>
								</tfoot>
							</table>						
						</div>
					</div>
					
					<div class="col-md-4 col-md-offset-3" style="padding-top:10px;">
						<button class="btn btn-success" ng-click="save()">Save</button>&nbsp;&nbsp;
						<a href="#vaninventory.replenishment" class="btn btn-warning">Cancel</a>
					</div>															
			</div>		
		</div>
	</div>
</div>


<script>
	$(document).ready(function(){
		$('select[name^="item_code"]').each(function(){
			setItem($(this));
		});

		$('input[name^=quantity]').keyup(function(){
			console.log($(this).val());
		});		
	});
	
	function setItem(el)
	{
		var sel = $(el).val();
		$(el).parent().parent().parent().next().find('select').val($(el).val())
	}

	function setSalesmanDetails(el)
	{
		var jrSalesman = [];
		@foreach($jrSalesmans as $k => $val)
			jrSalesman.push('{{ $k }}');
		@endforeach
		var vanCodes = [];
		@foreach($vanCodes as $k => $val)
			vanCodes.push('{{ $k }}');
		@endforeach

		var sel = $(el).val();
		if(-1 !== $.inArray(sel,jrSalesman)) {			
			$('select[name=jr_salesman]').val(sel);
		} else {
			$('select[name=jr_salesman]').val('');
		}

		if(-1 !== $.inArray(sel,vanCodes)) {			
			$('select[name=van_code]').val(sel);
		} else {
			$('select[name=van_code]').val('');
		}
			
	}

</script>

