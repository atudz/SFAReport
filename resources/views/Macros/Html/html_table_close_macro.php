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
							    <label class="col-sm-3">Remarks:</label>
							    <div class="col-sm-9">
							      	<textarea class="form-control inner-addon fxresize" maxlength="150" ng-model="params.comment" name="comment" rows="5" id="comment" ng-change="commentChange()">[[params.comment]]</textarea>
							    </div>
						  </div>
						  <div class="form-group" ng-show="params.commentLists.length">
						  	<div>
								<label class="control-label" style="padding-left: 20px">Remarks List:</label>
							</div>
							<table class="borderless">
                                <tbody>
                                    <tr>
                                        <td colspan="1">
                                            <div class="scrollit" style="padding-left:20px;">
                                                <table class="borderless">
                                                    <tbody>
                                                        <tr ng-repeat="list in params.commentLists track by $index">
                                                            <td>
                                                                [[ list ]]
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
						  </div>
						  <div class="form-group">
						    <div class="col-sm-12">
								<div class="pull-right">	
									<button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub" disabled="disabled">Submit</button>
									<button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>	
								</div>
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
						    <label class="col-sm-3">Remarks:</label>
						    <div class="col-sm-9">
						      	<textarea class="form-control inner-addon fxresize" maxlength="150" ng-model="params.comment" name="comment" rows="5" id="comment" ng-change="commentChange()">[[params.comment]]</textarea>
						    </div>
						</div>
						<div class="form-group" ng-show="params.commentLists.length">
							<div>
								<label class="control-label" style="padding-left: 20px">Remarks List:</label>
							</div>
							<table class="borderless">
                                <tbody>
                                    <tr>
                                        <td colspan="1">
                                            <div class="scrollit" style="padding-left:20px;">
                                                <table class="borderless">
                                                    <tbody>
                                                        <tr ng-repeat="list in params.commentLists track by $index">
                                                            <td>
                                                                [[ list ]]
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
						 </div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="pull-right">
									<button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub" disabled="disabled">Submit</button>
									<button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>
								</div>
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
						    <label class="col-sm-3">Remarks:</label>
						    <div class="col-sm-9">
						      	<textarea class="form-control inner-addon fxresize" maxlength="150" ng-model="params.comment" name="comment" rows="5" id="comment" ng-change="commentChange()">[[params.comment]]</textarea>
						    </div>
						</div>
						<div class="form-group" ng-show="params.commentLists.length">
							<div>
								<label class="control-label" style="padding-left: 20px">Remarks List:</label>
							</div>
						 	<table class="borderless">
                                <tbody>
                                    <tr>
                                        <td colspan="1">
                                            <div class="scrollit" style="padding-left:20px;">
                                                <table class="borderless">
                                                    <tbody>
                                                        <tr ng-repeat="list in params.commentLists track by $index">
                                                            <td>
                                                                [[ list ]]
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<div class="pull-right">
									<button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub" disabled="disabled">Submit</button>
									<button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>
								</div>
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
			
			<script type="text/ng-template" id="ConfirmPost">
        		<div class="modal-body">		
					<p><h5>You are uploading data to Van Inventory, Please confirm that all your data are correct.</h5></p>		
					<form class="form-inline">				         
						 <button class="btn btn-danger" type="button btn-sm" ng-click="ok()">Confirm</button>
						 <button class="btn btn-default" type="button btn-sm" ng-click="cancel()">Cancel</button>					 		
					</form>   										 					
				</div>			    			
    		</script>

    		<script type="text/ng-template" id="MassEdit">
			    <div class="modal-header">
			        <h3 class="modal-title" id="modal-title">Mass Edit</h3>
			    </div>
			    <div class="modal-body">
			        <form class="form-horizontal">
			            <div class="form-group">
			                <label class="control-label col-sm-3"></label>
			                <div class="col-sm-9">
			                    <select class="form-control" ng-model="mass_edit.edit_field" ng-options="option.name for option in options track by option.value" ng-change="setDataToChange()"></select>
			                </div>
			            </div>
			            <div class="form-group" ng-if="mass_edit.edit_field" ng-repeat="record in checkedRecords track by $index">
			                <label class="control-label col-sm-3">Date [[ $index+1 ]]:</label>
			                <div class="col-sm-9">
			                <input type="hidden" id="atayui" value=""/>
			                    <p class="input-group col-sm-12">
			                        <input type="date" id="hdate_value" class="form-control ng-hide"/>
			                        <input required type="text" id="date_value[[ $index+1 ]]" name="date_value[[ $index+1 ]]" show-weeks="true" ng-click="open($event, $index)" class="form-control" uib-datepicker-popup="[[format]]" ng-model="record.dateFrom" is-open="record.opened" datepicker-options="{formatYear: \'yy\', startingDay: 0, initDate: record.dateFrom}" close-text="Close" onkeydown="return false;" ng-change="change($index,record.dateFrom)"/>
			                        <span class="input-group-btn">
			                            <button style="height:34px" type="button" class="btn btn-default btn-sm" ng-click="open($event, $index)" ><i class="glyphicon glyphicon-calendar"></i></button>
			                        </span>
			                    </p>
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-sm-3">Remarks:</label>
			                <div class="col-sm-9">
			                    <textarea class="form-control inner-addon fxresize" maxlength="150" ng-model="mass_edit.comment" name="comment" rows="5" id="comment"></textarea>
			                </div>
			            </div>
			            <div class="form-group">
			                <div class="col-sm-12">
			                    <div class="pull-right">
			                        <button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub" ng-disabled="disabledButton() || !mass_edit.hasOwnProperty(\'comment\')">Submit</button>
			                        <button class="btn btn-warning" type="button btn-sm" ng-click="cancelMassEdit()">Cancel</button>
			                    </div>
			                </div>
			            </div>
			        </form>
			    </div>
			</script>

    		<script type="text/ng-template" id="ConfirmationTemplate">
			    <div class="modal-header">
			        <h3 class="modal-title" id="modal-title">Confirmation</h3>
			    </div>
			    <div class="modal-body" ng-bind-html="params.message">
			    </div>
		        <div class="modal-footer">
		            <button class="btn btn-primary" type="button" ng-click="ok()">Confirm</button>
		            <button class="btn btn-warning" type="button" ng-click="cancelConfirmation()">Cancel</button>
		        </div>
			</script>

			<script type="text/ng-template" id="AddedTotal">
			    <div class="modal-header">
			        <h3 class="modal-title" id="modal-title">Added Total</h3>
			    </div>
			    <div class="modal-body">
			        <form class="form-horizontal">
			            <div class="form-group">
			                <label class="col-sm-3">Remarks:</label>
			                <div class="col-sm-9">
			                    <textarea class="form-control inner-addon fxresize" maxlength="150" ng-model="params.remarks" name="comment" rows="5" id="comment"></textarea>
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-sm-3">Summary Date:</label>
			                <div class="col-sm-9">
			                <input type="hidden" id="atayui" value=""/>
			                    <p class="input-group col-sm-12">
			                        <input type="date" id="hdate_value"  class="form-control ng-hide"/>
			                        <input type="text" id="date_value" name="date_value" show-weeks="true" ng-click="open($event)" class="form-control" uib-datepicker-popup="MM/yyyy" ng-model="params.summary_date" is-open="params.open" datepicker-options="{minMode: \'month\'}" close-text="Close" onkeydown="return false;" ng-change="change()"/>
			                         <span class="input-group-btn">
			                             <button style="height:34px" type="button" class="btn btn-default btn-sm" ng-click="open($event,\'date_value\')"><i class="glyphicon glyphicon-calendar"></i></button>
			                         </span>
			                    </p>
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-sm-3">Total Collected Amount:</label>
			                <div class="col-sm-9">
			                    <input type="text" ng-model="params.total_collected_amount" placeholder="0.00" class="form-control regEx">
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-sm-3">Sales Tax:</label>
			                <div class="col-sm-9">
			                    <input type="text" ng-model="params.sales_tax" placeholder="0.00" class="form-control regEx">
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-sm-3">Amount Subject To Commission:</label>
			                <div class="col-sm-9">
			                    <input type="text" ng-model="params.amount_for_commission" placeholder="0.00" class="form-control regEx">
			                </div>
			            </div>
			            <div class="form-group">
			                <div class="col-sm-12">
			                    <div class="pull-right">
			                        <button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub">Submit</button>
			                        <button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>
			                    </div>
			                </div>
			            </div>
			        </form>
			    </div>
			</script>

			<script type="text/ng-template" id="AddedNotes">
			    <div class="modal-header">
			        <h3 class="modal-title" id="modal-title">Added Notes</h3>
			    </div>
			    <div class="modal-body">
			        <form class="form-horizontal">
			            <div class="form-group">
			                <label class="col-sm-3">Remarks:</label>
			                <div class="col-sm-9">
			                    <textarea class="form-control inner-addon fxresize" maxlength="150" ng-model="params.notes" name="comment" rows="5" id="comment"></textarea>
			                </div>
			            </div>
			            <div class="form-group">
			                <label class="col-sm-3">Summary Date:</label>
			                <div class="col-sm-9">
			                <input type="hidden" id="atayui" value=""/>
			                    <p class="input-group col-sm-12">
			                        <input type="date" id="hdate_value"  class="form-control ng-hide"/>
			                        <input type="text" id="date_value" name="date_value" show-weeks="true" ng-click="open($event)" class="form-control" uib-datepicker-popup="MM/yyyy" ng-model="params.summary_date" is-open="params.open" datepicker-options="{minMode: \'month\'}" close-text="Close" onkeydown="return false;" ng-change="change()"/>
			                         <span class="input-group-btn">
			                             <button style="height:34px" type="button" class="btn btn-default btn-sm" ng-click="open($event,\'date_value\')"><i class="glyphicon glyphicon-calendar"></i></button>
			                         </span>
			                    </p>
			                </div>
			            </div>
			            <div class="form-group">
			                <div class="col-sm-12">
			                    <div class="pull-right">
			                        <button class="btn btn-success" type="button btn-sm" ng-click="save()" id="btnsub">Submit</button>
			                        <button class="btn btn-warning" type="button btn-sm" ng-click="cancel()">Cancel</button>
			                    </div>
			                </div>
			            </div>
			        </form>
			    </div>
			</script>

			<script type="text/ng-template" id="exportModalSFI">
        			<div class="modal-header">
            			<h3 class="modal-title">Export Modal SFI</h3>
        			</div>
			        <div class="modal-body">
						<p class="indent">
							<em>Please choose the appropriate range of data to export below.</em>
						</p>
			            <ul class="list-inline list-unstyled">
			                <li ng-repeat="item in params.range track by $index">
			                    <div class="radio">
			  						<label>
			    						<input type="radio" name="exportdoc" value="[[$index]]"> [[item.from]] - [[item.to]]
			  						</label>
								</div>
			                </li>
			            </ul>
			        </div>
			        <div class="modal-footer">
			            <button class="btn btn-success" type="button" ng-click="download()">Download</button>
			            <button class="btn btn-warning" type="button" ng-click="cancel()">Cancel</button>
			        </div>
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