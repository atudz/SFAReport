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
				      		<a href="#vaninventory.actualcount" class="btn btn-success btn-sm">Back to Actual Count Replenishment</a>
				      	</div>
					</div>
				</div>
				<div class="clearfix">
				
				<div class="col-md-12 well">
					<div class="row">															
						<div class ="col-md-8">
							<input id="id" type="hidden" name="id" value="{{(int)$replenishment->id}}">
							<div class="row form-input-field">
								{!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman, 'Select Salesman',['onblur'=>'validate(this)','onchange'=>'setSalesmanDetails(this)'],$replenishment->modified_by)!!}
							</div>
							<div class="row form-input-field">
								{!!Html::select('jr_salesman','Jr Salesman', $jrSalesmans, 'No Jr. Salesman',['disabled'=>1],van_salesman($replenishment->van_code))!!}
							</div>						
							<div class="row form-input-field">
								{!!Html::select('van_code','Van Code', $vanCodes, 'No Van Code',['disabled'=>1],van_salesman($replenishment->van_code))!!}
							</div>						
							<div class="row form-input-field">
								{!!Html::datepicker('replenishment_date','Count date/time <span class="required">*</span>','','',$replenishment->replenishment_date)!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','reference_number','Count Sheet No. <span class="required">*</span>',$replenishment->reference_number,['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','counted','Counted <span class="required">*</span>',$replenishment->counted,['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','confirmed','Confirmed <span class="required">*</span>',$replenishment->confirmed,['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_sr','Last SR <span class="required">*</span>',$replenishment->last_sr,['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_rprr','Last RPRR <span class="required">*</span>',$replenishment->last_rprr,['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_cs','Last Cash Slip <span class="required">*</span>',$replenishment->last_cs,['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_dr','Last Delivery Receipt <span class="required">*</span>',$replenishment->last_dr,['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','last_ddr','Last DDR <span class="required">*</span>',$replenishment->last_ddr,['onblur'=>'validate(this)'])!!}
							</div>						
						</div>
					</div>
					
					<h4>Actual Count Items</h4>					
					<div class="row">
						<div class="col-md-12 table-responsive">
							<table class="table table-striped table-condensed table-bordered" id="table_items">
								<thead>
									<tr>
										<th>Material Code</th>
										<th>Material Description</th>
										<th>Material Quantity</th>
										<th>&nbsp;</th>
									</tr>
								</thead>
								<tbody>
									
									@if(count($replenishment->items) > 0)
										@foreach($replenishment->items as $k=>$item)
											<tr>
												<td>
													<div class="form-group">			 								
						 								<div class="col-xs-12 col-sm-12">
						 									{!!Form::select('item_code[]',$itemCodes,$item->item_code,['class'=>'form-control','onchange'=>'setItem(this)'])!!}
						 								</div>
						 							</div>										
												</td>
												<td>
													<div class="form-group">			 								
						 								<div class="col-xs-12 col-sm-12">
						 									{!!Form::select('item[]',$items,$item->item_code,['class'=>'form-control','disabled'=>true],$item->item_code)!!}
						 								</div>
						 							</div>		
												</td>
												<td>
													<div class="form-group">			 								
						 								<div class="col-xs-12 col-sm-12">
						 									<input class="form-control" id="quantity" name="quantity[]" type="number" min="0"  value="{{$item->quantity}}" onblur="validateQty(this)">
						 									<span class="help-block"></span>
						 								</div>
						 							</div>
												</td>
												<td>
													<button class="btn btn-primary" uib-tooltip="Delete" onclick="removeTd(this)"><i class="fa fa-trash"></i></button>	
												</td>
											</tr>
										@endforeach
									@else
										<tr>
											<td>
												<div class="form-group">			 								
					 								<div class="col-xs-12 col-sm-12">
					 									{!!Form::select('item_code[]',$itemCodes,null,['class'=>'form-control','onchange'=>'setItem(this)'])!!}
					 								</div>
					 							</div>										
											</td>
											<td>
												<div class="form-group">			 								
					 								<div class="col-xs-12 col-sm-12">
					 									{!!Form::select('item[]',$items,null,['class'=>'form-control','disabled'=>true])!!}
					 								</div>
					 							</div>		
											</td>
											<td>
												<div class="form-group">			 								
					 								<div class="col-xs-12 col-sm-12">
					 									<input class="form-control" id="quantity" name="quantity[]" type="number" min="0"  value="0" onblur="validateQty(this)">
					 									<span class="help-block"></span>
					 								</div>
					 							</div>
											</td>
											<td>
												<button class="btn btn-primary" uib-tooltip="Delete" onclick="removeTd(this)"><i class="fa fa-trash"></i></button>
											</td>
										</tr>
									@endif
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4">
											<div class="text-center">
												<button class="btn btn-info" onclick="addTd()">Add More</button>&nbsp;&nbsp;
											</div>
										</td>
									</tr>
								</tfoot>
							</table>						
						</div>
					</div>
					
					<div class="col-md-4 col-md-offset-4" style="padding-top:10px;">
						<button class="btn btn-success" ng-click="save()">Save</button>&nbsp;&nbsp;						
						<a href="#vaninventory.actualcount" class="btn btn-warning">Cancel</a>&nbsp;&nbsp;
						@if($replenishment->id)
							<button class="btn btn-danger" ng-click="remove()">Delete</button>&nbsp;&nbsp;
						@endif
					</div>															
			</div>		
		</div>
	</div>
</div>


<script type="text/ng-template" id="DeleteActualcount">
 	<div class="modal-body">
		<form class="form-horizontal">	 
			<h4>Deleting Actual Count Replenishment - [[params.reference_num]]</h4>       		 
			<div class="form-group">
				<label class="col-sm-3">Remarks:</label>
				<div class="col-sm-9">
					<textarea class="form-control inner-addon fxresize" maxlength="150" name="remarks" rows="5" id="remarks" onblur="validate(this)"></textarea>
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
	$(document).ready(function(){
		$('select[name^="item_code"]').each(function(){
			setItem($(this));
		});
	});


	function addTd() {
		var tr = $('#table_items > tbody > tr:last').clone();
		$('#table_items > tbody > tr:last').after(tr);
		
	}
	
	function removeTd(item) {
		var length = $('#table_items > tbody > tr').length;
		if(length > 1)
			$(item).parent().parent().detach();
	}
	
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

