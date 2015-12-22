{!!Html::breadcrumb(['Unpaid Invoice'])!!}
{!!Html::pageheader('Unpaid Invoice')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::select('company_code','Company', $companyCode)!!}
						{!!Html::select('salesman','Salesman', $salesman)!!}											
						{!!Html::select('customer','Customer', $customers)!!}
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
				
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
					</tbody>
					{!!Html::tfooter(true,8)!!}
				{!!Html::tclose()!!}				
			</div>			
		</div>
	</div>
</div>
