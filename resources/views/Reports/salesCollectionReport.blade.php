{!!Html::breadcrumb(['Sales & Collection','Reports'])!!}
{!!Html::pageheader('Sales & Collection Report')!!}

<div class="row" data-ng-controller="SalesCollectionReport">
	<div class="col-sm-12">
		<div class="panel panel-default">
		<div class="panel-body">
		
		{!!Html::fopen('Toggle Filter')!!}
			<div class="pull-left col-sm-6">
				{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
				{!!Html::datepicker('collection_date','Collection Date','true')!!}
			</div>					
			<div class="pull-right col-sm-6">	
				<div class="form-group form-group-sm">
							 	<label for="inputPassword" class="col-sm-3 control-label">Customer Code</label>
								<div class="col-sm-8">
									<input type="password" class="form-control" id="inputPassword" placeholder="Password">
								</div>
							 </div>
							 <div class="form-group form-group-sm">
							    	<label for="salesman" class="col-sm-3 control-label">Salesman</label>
								    <div class="col-sm-8">
								      <select class="form-control" id="salesman">
								      	<option>Man1</option>
								      	<option>Man2</option>
								      </select>
								    </div>
							 </div>			
				{!!Html::datepicker('posting_date','Posting Date','true')!!}
			</div>			
		{!!Html::fclose()!!}
				



		</div>		
		</div>		
	</div>
</div>
