<?php

Html::macro('tclose', function($paginate=true) {

	$html = '</table>';

	if($paginate)
	{
		$html .= '<div class="col-sm-12 fixed-table-pagination" id="pagination_div">
					<div class="pull-left pagination-detail">
					<span class="pagination-info">Showing [[((perpage*page)-perpage)+1]] to [[perpage*page]] of [[total]] rows&nbsp;</span>
					<span class="page-list">
						<div class="btn-group" uib-dropdown dropdown-append-to-body>
					      <button id="btn-append-to-body" type="button" class="btn btn-default btn-sm" uib-dropdown-toggle>
					        [[perpage]] <span class="caret"></span>
					      </button>
					      <ul class="uib-dropdown-menu" role="menu" aria-labelledby="btn-append-to-body">
					        <li role="menuitem" class="active" id="limit10" ng-click="paginate(10)"><a href="">10</a></li>
					        <li role="menuitem"><a href="" id="limit25" ng-click="paginate(25)">25</a></li>
					        <li role="menuitem"><a href="" id="limit50" ng-click="paginate(50)">50</a></li>					        
					        <li role="menuitem"><a href="" id="limit100" ng-click="paginate(100)">100</a></li>
					      </ul>
					    </div>
						 records per page
					</span>
					<input type="hidden" name="perpage" id="perpage" value="10">
				</div>	
				
				<div class="pull-right pagination">
					<ul class="pagination">
						<li class="page-first"><a href="" ng-click="pager(1,1)">&lt;&lt;</a></li>
						<li class="page-pre"><a href="" ng-click="pager(-1)">&lt;</a></li>
						<li class="page-next"><a href="" ng-click="pager(1)">&gt;</a></li>
						<li class="page-last"><a href="" ng-click="pager(1,0,1)">&gt;&gt;</a></li>
						<input type="hidden" name="page" id="page" value="1">
					</ul>
				</div>
			</div>';
	}
			
	$html .= '</div>';

	return $html;
});