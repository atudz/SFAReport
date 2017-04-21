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
								{!!Html::input('text','invoice_start','Start Series <span class="required">*</span>',$invoice->invoice_start,['onblur'=>'validate(this)','hint'=>'Please input 0-9999999 only.'])!!}
							</div>						
							<div class="row form-input-field">
								{!!Html::input('text','invoice_end','End Series <span class="required">*</span>',$invoice->invoice_end,['onblur'=>'validate(this)','hint'=>'Please input 0-9999999 only.'])!!}
							</div>
							<div class="row form-input-field">
								{!!Html::select('status','Status <span class="required">*</span>', statuses(), 'Select Status',['onblur'=>'validate(this)'],$invoice->status)!!}
							</div>							
							<div class="col-md-4 col-md-offset-4">
								<button class="btn btn-info" onclick="preview()">Preview</button>
							</div>
						</div>
					</div>
					
					<div class="row @if(!$invoice->id) hidden @endif " style="padding-top:10px;" id="preview">
						<div class="col-md-6 col-md-offset-2 table-responsive">
							<h4>Invoice Series</h4>
							<table id="table_preview" class="table table-striped table-condensed table-bordered">
								<thead>
									<tr>
										<th style="text-align:center;" width="20%">#</th>
										<th style="text-align: center">Invoice No.</th>										
									</tr>								
								</thead>
								<tbody>	
									<?php $index = 1; ?>
									@if($invoice->invoice_start && $invoice->invoice_end)
										@for($i=$invoice->invoice_start; $i <=$invoice->invoice_end; $i++)
											<tr>
												<td style="text-align:center;" width="20%">{{$index}}</th>
												<td style="text-align: center">{{str_pad($i,8,'0',STR_PAD_LEFT)}}</td>										
											</tr>
											<?php $index++; ?>
										@endfor										
									@endif																	
								</tbody>								
							</table>						
						</div>	
					</div>
						
					<div class="col-md-4 col-md-offset-4" style="padding-top:10px;">
						@if($navigationActions['can_save'] || $navigationActions['can_update'])
							<button class="btn btn-success" ng-click="save()">Save</button>&nbsp;&nbsp;						
						@endif
						<a href="#invoiceseries.mapping" class="btn btn-warning">Cancel</a>&nbsp;&nbsp;
						@if($navigationActions['can_delete'])
							<button class="btn btn-danger" ng-click="remove()">Delete</button>&nbsp;&nbsp;
						@endif						
					</div>																		
			</div>		
		</div>
	</div>
</div>

@if($navigationActions['can_delete'])
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
@endif

<script>
	function preview()
	{
		
		var start = $('#invoice_start').val();
		var end = $('#invoice_end').val();

		if(start.length > 0){
			if(isNaN(parseFloat(start)) || !isFinite(start)) {
				$('#invoice_start').next('span').html('Must be numeric characters only.');
				$('#invoice_start').parent().parent().addClass('has-error');
			} else {
				$('#invoice_start').next('span').html('');
				$('#invoice_start').parent().parent().removeClass('has-error');
			}
			
		}

		if(end.length > 0){
			if(isNaN(parseFloat(end)) || !isFinite(end)){
				$('#invoice_end').next('span').html('Must be numeric characters only.');
				$('#invoice_end').parent().parent().addClass('has-error');
			} else {
				$('#invoice_end').next('span').html('');
				$('#invoice_end').parent().parent().removeClass('has-error');
			}
		}
		
				
		if(start.length > 0 && end.length > 0)
		{
			var i = parseInt(start);
			var e = parseInt(end);
			var valid = true;

			if(i < 0) {
				valid = false;
				$('#invoice_start').next('span').html('Must not be negative.');
				$('#invoice_start').parent().parent().addClass('has-error');
			} else {
				$('#invoice_start').next('span').html('');
				$('#invoice_start').parent().parent().removeClass('has-error');
			}
			
			if(e < 0){
				valid = false;
				$('#invoice_end').next('span').html('Must not be negative.');
				$('#invoice_end').parent().parent().addClass('has-error');
			} else {
				$('#invoice_end').next('span').html('');
				$('#invoice_end').parent().parent().removeClass('has-error');
			}

			if(valid) {
				if(e < i) {
					valid = false;
					$('#invoice_start').next('span').html('Start must be less than or equal end.');
					$('#invoice_start').parent().parent().addClass('has-error');
					$('#invoice_end').next('span').html('End must be greater or equal start.');
					$('#invoice_end').parent().parent().addClass('has-error');
				} else {
					$('#invoice_start').next('span').html('');
					$('#invoice_start').parent().parent().removeClass('has-error');
					$('#invoice_end').next('span').html('');
					$('#invoice_end').parent().parent().removeClass('has-error');
				}
				
			}
			

			if(valid) {
				$('#preview').removeClass('hidden');
				var rowCount = $('#myTable tr').length;
				$('#table_preview').find("tr:gt(0)").remove();
				while(i <= e)
				{				
					rowCount++;
					$row = '<tr><td align="center">'+rowCount+'</td><td align="center">'+i+'</td></tr>';
					$('#table_preview').append($row);
					i++;
				}
			}			
		}
		
	}
</script>

