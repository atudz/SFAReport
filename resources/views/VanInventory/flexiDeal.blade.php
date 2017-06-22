{!!Html::breadcrumb(['Van Inventory','Flexi Deal'])!!}
{!!Html::pageheader('Flexi Deal')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-6">
							{!!Html::select('salesman_code','Salesman', $salesman,$isSalesman ? '' : 'All')!!}
							{!!Html::select('company_code','Company Code', $companyCode)!!}						
							{!!Html::select('area_code','Area', $areas)!!}												
							{!!Html::select('customer_code','Customer', $customers)!!}												 																															
						</div>					
						<div class="col-md-6">	
							{!!Html::datepicker('invoice_date','Invoice Date',true)!!}
							{!!Html::select('item_code','Regular Item Code', $items)!!}						
						</div>			
					{!!Html::fclose()!!}
					<!-- End Filter -->
				@endif
				@if($navigationActions['show_table'])
					{!!Html::topen([
						'show_download'   => $navigationActions['show_download'],
						'show_print'      => $navigationActions['show_print'],
						'show_search'     => $navigationActions['show_search_field'],
					])!!}
					{!!Html::theader($tableHeaders,[
						'can_sort' => $navigationActions['can_sort_columns']
					])!!}
					<tbody>
						<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>							
							<td>[[record.area_name]]</td>
							<td>[[record.salesman_code]]</td>
							<td>[[record.salesman_name]]</td>
							<td>[[record.customer_name]]</td>
							<td>[[record.invoice_number]]</td>														
							<td>
								<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
							</td>
							<td>[[record.customer_address]]</td>
							<td>[[record.item_code]]</td>
							<td>[[record.item_desc]]</td>
							<td>[[record.regular_order_qty]]</td>
							<td>[[record.trade_item_code]]</td>
							<td>[[record.deal_item_desc]]</td>
							<td>[[record.trade_order_qty]]</td>
							<td>[[record.gross_order_amount]]</td>							
						</tr>
						
						<!-- Summary -->
						<tr id="total_summary">
							<td class="bold">Total</td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>							
							<td></td>
							<td></td>
							<td class="bold">[[summary.regular_order_qty]]</td>							
							<td></td>
							<td></td>
							<td class="bold">[[summary.trade_order_qty]]</td>							
							<td class="bold">[[summary.gross_order_amount]]</td>									
						</tr>									
					</tbody>				
					{!!Html::tfooter(true,14)!!}
					{!!Html::tclose()!!}			
				@endif
			</div>			
		</div>
	</div>
</div>
