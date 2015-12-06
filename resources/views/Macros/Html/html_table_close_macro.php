<?php

Html::macro('tclose', function($paginate=true) {

	$html = '</table>';

	if($paginate)
	{
		$html .= '<div class="col-sm-12 fixed-table-pagination">
				<div class="pull-left pagination-detail">
				<span class="pagination-info">Showing 1 to 0 of 0 rows&nbsp;</span>
				<span class="page-list">
					<span class="btn-group dropup">
						<button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
							<span class="page-size">10</span> 
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li class="active"><a href="javascript:void(0)">10</a></li>
							<li><a href="javascript:void(0)">25</a></li>
							<li><a href="javascript:void(0)">50</a></li>
							<li><a href="javascript:void(0)">100</a></li>
						</ul>
					</span> records per page
				</span>
				</div>	
				
				<div class="pull-right pagination">
					<ul class="pagination">
						<li class="page-first disabled"><a href="javascript:void(0)">&lt;&lt;</a></li>
						<li class="page-pre disabled"><a href="javascript:void(0)">&lt;</a></li>
						<li class="page-next disabled"><a href="javascript:void(0)">&gt;</a></li>
						<li class="page-last disabled"><a href="javascript:void(0)">&gt;&gt;</a></li>
					</ul>
				</div>
			</div>';
	}
			
	$html .= '</div>';

	return $html;
});