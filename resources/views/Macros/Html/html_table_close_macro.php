<?php
Html::macro('tclose', function($paginate=true) {

	$html = '</table>';
	$html .= '</div>';

	$html .= '
			<script type="text/ng-template" id="Synchronizing">
        		<div class="modal-body">			
					<p class="text-center bold required">Synchronization on progess, please wait till its finished to edit.</p>									 					
				</div>			    			
    		</script>
			
			<script type="text/ng-template" id="EditColumnText">
        		<div class="modal-body">
	        		 <form class="form-horizontal">
	        		 <p class="text-center bold required error-edit" id="editError">Please input remarks to proceed.</p>
	        		 <p class="text-center bold required error-edit" id="editErrorInvoice">Please input invoice prefix to proceed.</p>
	        		 <p  class="bold">[[params.report_type]] <span> ([[params.name]])</span></p>
						  <div class="form-group">
							    <input type="[[params.type]]" id="hval" ng-model="params.oldval" min="0" class="form-control ng-hide" step="[[params.step]]">
							    <label class="control-label col-sm-3"></label>
							    <div class="col-sm-9">
							      	<input type="[[params.type]]" ng-model="params.value" id="regExpr" ng-change="change()" min="0" class="form-control regEx" step="[[params.step]]">
							    </div>
						  </div>
						  <div class="form-group">
							    <label class="control-label col-sm-3">Remarks:</label>
							    <div class="col-sm-9">
							      	<textarea class="form-control inner-addon fxresize" ng-model="params.comment" name="comment" rows="5" id="comment" ng-change="commentChange()">[[params.comment]]</textarea>
							    </div>
						  </div>
						  <div class="form-group">
						    <div class="col-sm-offset-3 col-sm-9">
						      	<button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub" disabled="disabled">Submit</button>
								<button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>
						    </div>
						  </div>
					</form>										 					
				</div>			    			
    		</script>
			
			<script type="text/ng-template" id="EditColumnSelect">
        		<div class="modal-body">
        			<form class="form-horizontal">
        			<p class="text-center bold required error-edit" id="editError">Please input remarks to proceed.</p>
        			<p class="text-center bold required error-edit" id="editErrorInvoice">Please input invoice prefix to proceed.</p>
	        		 	<p  class="bold">[[params.report_type]] <span> ([[params.name]])</span></p>
						<div class="form-group">
						    <label class="control-label col-sm-3"></label>
						    <div class="col-sm-9">
						      	<select class="form-control ng-hide" id="oldSelected">
								  	<option ng-repeat="option in params.selectOptions">[[option]]</option>							  
								</select>
						      	<select class="form-control" ng-model="params.value"  id="newSelected" ng-change="change()">
								  	<option ng-repeat="option in params.selectOptions">[[option]]</option>							  
								</select>
						    </div>
						</div>
						<div class="form-group">
						    <label class="control-label col-sm-3">Remarks:</label>
						    <div class="col-sm-9">
						      	<textarea class="form-control inner-addon fxresize" ng-model="params.comment" name="comment" rows="5" id="comment" ng-change="commentChange()">[[params.comment]]</textarea>
						    </div>
						</div>
						<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
						  	<button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub" disabled="disabled">Submit</button>
							<button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>
						</div>
						</div>
					</form>  										 					
				</div>			    			
    		</script>

			<script type="text/ng-template" id="EditColumnDate">
        		<div class="modal-body">
        			<form class="form-horizontal">
        			<p class="text-center bold required error-edit" id="editError">Please input remarks to proceed.</p>
        			<p class="text-center bold required error-edit" id="editErrorInvoice">Please input invoice prefix to proceed.</p>
	        		 	<p  class="bold">[[params.report_type]] <span> ([[params.name]])</span></p>
						<div class="form-group">
						    <label class="control-label col-sm-3"></label>
						    <div class="col-sm-9" data-ng-controller="EditableColumnsCalendar">
						    <input type="hidden" id="atayui" value=""/>
						      	<p class="input-group col-sm-12">
									<input type="date" id="hdate_value"  class="form-control ng-hide"/>
									<input required type="text" id="date_value" name="date_value" show-weeks="true" ng-click="open($event,\'date_value\')" class="form-control" uib-datepicker-popup="[[format]]" ng-model="dateFrom" is-open="date_value" datepicker-options="dateOptions" close-text="Close" onkeydown="return false;" ng-change="change()"/>
							 		<span class="input-group-btn">
							 			<button style="height:34px" type="button" class="btn btn-default btn-sm" ng-click="open($event,\'date_value\')"><i class="glyphicon glyphicon-calendar"></i></button>
							 		</span>
							 	</p>
						    </div>
						</div>
						<div class="form-group">
						    <label class="control-label col-sm-3">Remarks:</label>
						    <div class="col-sm-9">
						      	<textarea class="form-control inner-addon fxresize"  ng-model="params.comment" name="comment" rows="5" id="comment" ng-change="commentChange()">[[params.comment]]</textarea>
						    </div>
						</div>
						<div class="form-group">
						<div class="col-sm-offset-3 col-sm-9">
						  	<button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub" disabled="disabled">Submit</button>
						 	<button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>
						</div>
						</div>
					</form>   										 					
				</div>			    			
    		</script>
			
			
			<script type="text/ng-template" id="Confirm">
        		<div class="modal-body">		
					<p class="bold">[[params.message]]</p>		
					<form class="form-inline">				         
						 <button class="btn btn-danger" type="button btn-sm" ng-click="ok()">Yes</button>
						 <button class="btn btn-default" type="button btn-sm" ng-click="cancel()">No</button>					 		
					</form>   										 					
				</div>			    			
    		</script>
			
			<script type="text/ng-template" id="Info">
        		<div class="modal-body">										
					<form class="form-inline">				         
						<p class="text-center"><strong>[[params.message]]</strong>&nbsp;&nbsp;&nbsp;<button class="btn btn-default" type="button btn-sm" ng-click="cancel()">Ok</button></p>					 		
					</form>   										 					
				</div>			    			
    		</script>

   			 <script type="text/javascript">
			// 	$(function() {
			// 	 	$("table.table").floatThead({
			// 		    position: "absolute",
			// 		    autoReflow: true,
			// 		    zIndex: "2",
			// 		    scrollContainer: function($table){
			// 		        return $table.closest(".wrapper");
			// 		    }
			// 		});
			// 	});
			</script>
			
			
			';
	if($paginate)
	{
		$html .= '<div ng-if="total > 0" class="col-sm-12 fixed-table-pagination" id="pagination_div">
					<div class="pull-left pagination-detail">
					<span class="pagination-info">Showing [[((perpage*page)-perpage)+1]] to [[(perpage*page) > total ? total:perpage*page]] of [[total]] rows&nbsp;</span>
					<span class="page-list">
					    <div class="btn-group dropup">
					      <button id="btn-append-to-body" type="button" class="dropdown-toggle btn btn-default btn-sm" data-toggle="dropdown">
					        [[perpage]] <span class="caret"></span>
					      </button>
					      <ul class="dropdown-menu" role="menu" aria-labelledby="selectDropdown">
					        <li style="display:none" role="menuitem"  id="limit10" ng-click="paginate(10)"><a href="">10</a></li>
					        <li ng-if="total > 25 || total > 10" role="menuitem" class="active"><a href="" id="limit25" ng-click="paginate(25)">25</a></li>
					        <li ng-if="total > 50 || total > 25" role="menuitem"><a href="" id="limit50" ng-click="paginate(50)">50</a></li>					        
					        <li ng-if="total > 100 || total > 50" role="menuitem"><a href="" id="limit100" ng-click="paginate(100)">100</a></li>
					      </ul>
					    </div>
						 records per page
					</span>
					<input type="hidden" name="perpage" id="perpage" value="10">
				</div>	
				
				<div class="pull-right pagination">
					<ul class="pagination">
						<li class="page-first"><a href="" ng-click="pager(1,1)">First</a></li>
						<li class="page-pre"><a href="" ng-click="pager(-1)">Prev</a></li>
						<li class="page-next"><a href="" ng-click="pager(1)">Next</a></li>
						<li class="page-last"><a href="" ng-click="pager(1,0,1)">Last</a></li>
						<input type="hidden" name="page" id="page" value="1">
					</ul>
				</div>
			</div>';
	}

	return $html;
});