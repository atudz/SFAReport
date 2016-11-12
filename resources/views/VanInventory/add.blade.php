{!!Html::breadcrumb(['Van Inventory','Stock Transfer', 'Add Row'])!!}
{!!Html::pageheader('Add Row')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<div class="col-md-12" style="margin-bottom:5px;padding-left:0px;padding-right:0px;">
					<div class="pull-left">
						<h4>Stock Transfer</h4>
					</div>					
					<div class="pull-right">
			      		<a href="#vaninventory.stocktransfer" class="btn btn-success btn-sm">Back to Stock Transfer</a>
			      	</div>						
			    </div>
			
				<div class="col-md-12 well">															
					<div class ="col-md-8">
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
							<button class="btn btn-success" ng-click="save()">Save</button>&nbsp;&nbsp;
							<a href="#vaninventory.stocktransfer" class="btn btn-warning">Cancel</a>
						</div>
					</div>										
			</div>			
		</div>
	</div>
</div>
