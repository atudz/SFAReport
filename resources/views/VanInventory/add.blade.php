{!!Html::breadcrumb(['Van Inventory','Stock Transfer', 'Add Row'])!!}
{!!Html::pageheader('Add Row')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<div class="row">
					<div class="col-md-12">
						<div class="pull-left">
							<h4>Stock Transfer</h4>
						</div>					
						<div class="pull-right">
				      		<a href="#vaninventory.stocktransfer" class="btn btn-success btn-sm">Back to Stock Transfer</a>
				      	</div>						
				    </div>
				</div>
				<div class="clearfix">
			
				<div class="col-md-12 well">															
					<div class ="col-md-8">
						<input type="hidden" name="type" id="type" value="1">
						<div id="new-details" class="hidden">
							<div class="row form-input-field">
								{!!Html::input('text','stock_transfer_number','Stock Transfer No. <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::datepicker('transfer_date','Transaction Date <span class="required">*</span>')!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','src_van_code','Source Van Code <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::input('text','dest_van_code','Dest Van Code <span class="required">*</span>','',['onblur'=>'validate(this)'])!!}
							</div>	
						</div>	
						<div id="existing-details">
							<div class="row form-input-field">
								<div class="form-group">
				 					<div class="col-xs-12 col-md-4 col-sm-3 control-label">
				 						<label for="stock_transfer_id" class="">Stock Transfer No. <span class="required">*</span></label>			 						
				 					</div>
				 					<div class="col-xs-12 col-sm-8	">
				 						{!!Form::select('stock_transfer_id',$stockTransfers,null,['id'=>'stock_transfer_id','class'=>'form-control'])!!}
				 						<span class="error help-block"></span>
				 						<a href="javascript:void(0);" style="color:#337ab7;" onclick="add()">Add New Stock Transfer</a>
				 					</div>
				 				</div>														
				 			</div>
						</div>				
						<div class="row form-input-field">
							{!!Html::select('item_code','Item <span class="required">*</span>', $items, 'Select Item',['onblur'=>'validate(this)'])!!}
						</div>					
						<div class="row form-input-field">
							{!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman, 'Select Salesman',['onblur'=>'validate(this)'])!!}
						</div>
						<div class="row form-input-field">
							{!!Html::select('uom_code','UOM <span class="required">*</span>', $uom, 'Select UOM',['onblur'=>'validate(this)'])!!}
						</div>
						<div class="row form-input-field">
							{!!Html::input('number','quantity','Quantity <span class="required">*</span>',null,['min'=>0,'onblur'=>'validateQty(this)'])!!}
						</div>
						
						<div class="col-md-4 col-md-offset-6" style="padding-top:10px;">
							@if($navigationActions['can_save'])
								<button class="btn btn-success" ng-click="save()">Save</button>&nbsp;&nbsp;
							@endif
							<a href="#vaninventory.stocktransfer" class="btn btn-warning">Cancel</a>
						</div>
					</div>										
			</div>			
		</div>
	</div>
</div>

<script>
	function add()
	{
		$('#new-details').removeClass('hidden');
		$('#existing-details').addClass('hidden');
		$('#type').val(0);		
	}
</script>