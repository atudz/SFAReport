{!!Html::breadcrumb(['Sales & Collection','Monthly Summary'])!!}
{!!Html::pageheader('Sales & Collection Monthly Summary')!!}

<div class="row" data-ng-controller="SalesCollectionSummary">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
			
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::select('salesman','Salesman', $salesman)!!}
						{!!Html::select('customer_code','Customer Code', $customerCode)!!}
						{!!Html::select('area','Area', $area)!!}
						
					</div>					
					<div class="pull-right col-sm-6">														 			
						{!!Html::datepicker('posting_date','Posting Date','true')!!}
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen()!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
					
					</tbody>
				{!!Html::tclose()!!}
			</div>			
		</div>
	</div>
</div>
