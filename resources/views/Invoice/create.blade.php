{!!Html::breadcrumb(['Invocie Series Mapping'])!!}
{!!Html::pageheader('Add Row')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<div class="row">
					<div class="col-md-12">
						<div class="pull-left">
							<h4>Invoice Series Mapping</h4>
						</div>					
						<div class="pull-right">
				      		<a href="#invoiceseries.mapping" class="btn btn-success btn-sm">Back to Invoice Series Mapping</a>
				      	</div>
					</div>
				</div>
				<div class="clearfix">
				
				<div class="col-md-12 well">
					<div class="row">															
						<div class ="col-md-8">
							<input id="id" type="hidden" name="id" value="{{$invoice->id}}">
							<div class="row form-input-field">
								{!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman, 'Select Salesman',['onblur'=>'validate(this)'],$invoice->salesman_code)!!}
							</div>							
							<div class="row form-input-field">
								{!!Html::input('text','invoice_start','Start Series <span class="required">*</span>',$invoice->invoice_start,['onblur'=>'validate(this)'])!!}
							</div>						
							<div class="row form-input-field">
								{!!Html::input('text','invoice_end','End Series <span class="required">*</span>',$invoice->invoice_end,['onblur'=>'validate(this)'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::select('status','Status <span class="required">*</span>', statuses(), 'Select Status',['onblur'=>'validate(this)'],$invoice->status)!!}
							</div>
						</div>
					</div>
					
					<div class="col-md-4 col-md-offset-4" style="padding-top:10px;">
						<button class="btn btn-success" ng-click="save()">Save</button>&nbsp;&nbsp;						
						<a href="#invoiceseries.mapping" class="btn btn-warning">Cancel</a>&nbsp;&nbsp;
						@if($invoice->id)
							<button class="btn btn-danger" ng-click="remove()">Delete</button>&nbsp;&nbsp;
						@endif						
					</div>															
			</div>		
		</div>
	</div>
</div>


<script type="text/ng-template" id="DeleteInvoiceSeries">
 	<div class="modal-body">
		<form class="form-horizontal">	 
			<h4>Deleting Invoice Series</h4>       		 
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

