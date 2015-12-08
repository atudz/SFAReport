{!!Html::breadcrumb(['BIR'])!!}
{!!Html::pageheader('BIR')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<!-- Filter -->
				{!!Html::fopen('Toggle Filter')!!}
					<div class="pull-left col-sm-6">
						{!!Html::select('area','Area', $area)!!}
						{!!Html::select('salesman','Salesman', $salesman)!!}											
					</div>					
					<div class="pull-right col-sm-6">	
						{!!Html::datepicker('document_date','Document Date','true')!!}
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
