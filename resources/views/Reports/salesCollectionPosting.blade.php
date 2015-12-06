{!!Html::breadcrumb(['Sales & Collection','Posting'])!!}
{!!Html::pageheader('Sales & Collection Posting')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
						{!!Html::datepicker('collection_date','Collection Date','true')!!}
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::select('customer_code','Customer Code', $customerCode)!!}
						{!!Html::select('salesman','Salesman', $salesman)!!}							 			
						{!!Html::datepicker('posting_date','Posting Date','true')!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			</div>			
		</div>
	</div>
</div>
