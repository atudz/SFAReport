{!!Html::breadcrumb(['Remittance/Expense Report', $state])!!}
{!!Html::pageheader($state)!!}


<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <h4>Remittance/Expense Report</h4>
                        </div> 
                        <div class="pull-right">
                            <a href="#remittance.expenses.report" class="btn btn-success btn-sm">Back to Remittance/Expense Report</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="col-sm-12">
                    </div>

                    <div class="form">
                        <div class="well filter col-sm-12" ng-show="form.remittance">
                            <h4 style="margin-top: 0; padding-left: 15px;">Remittance</h4>
                            <div class="col-md-6">
                                {!!Html::select('form_salesman_code','Salesman <span class="required">*</span>', $salesman, 'Select Salesman',['onblur'=>'validate(this)','onchange'=>'setSalesmanDetails(this,"form_jr_salesman")'])!!}
                                {!!Html::select('form_jr_salesman','Jr Salesman', $jrSalesmans, 'No Jr. Salesman',['disabled'=>1])!!}
                                {!!Html::input('text','form_cash_amount','Total Cash <span class="required">*</span>','',['ng-model' => 'remittance.cash_amount','ng-change' => 'totalAmount()'])!!}
                                {!!Html::input('text','form_check_amount','Total Check <span class="required">*</span>','',['ng-model' => 'remittance.check_amount','ng-change' => 'totalAmount()'])!!}
                                {!!Html::input('text','total_amount','Total Amount','',['disabled' => 'disabled'])!!}
                            </div>
                            <div class="col-md-6">
                                {!!Html::datepicker('form_date','Date <span class="required">*</span>','true')!!}
                            </div>

                            <div class="col-sm-offset-4 col-sm-6 col-xs-12 container">
                                <button type="button" class="btn btn-success btn-sm" ng-click="next_expenses()">Next</button>
                            </div>
                        </div>

                        <div class="well col-sm-12" ng-show="form.expenses">
                            <h4 style="margin-top: 0;">Expenses Report</h4>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-striped table-condensed table-bordered" id="expenses_items">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Amount</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="update_expense in remittance.expenses track by $index">
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input class="form-control" id="description" name="description" ng-model="update_expense.expense" type="text">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input class="form-control" id="amount" name="amount" ng-model="update_expense.amount" type="text">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success" uib-tooltip="Update" ng-click="updateExpense($index,update_expense)"><i class="fa fa-floppy-o"></i></button>
                                                    <button class="btn btn-primary" uib-tooltip="Delete" ng-click="deleteExpense($index,update_expense)"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr ng-repeat="create_expense in createExpense track by $index">
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input class="form-control" id="description" name="description" ng-model="create_expense.expense" type="text">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input class="form-control" id="amount" name="amount" ng-model="create_expense.amount" type="text">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success" uib-tooltip="Save" ng-click="saveExpense($index,create_expense,remittance.id)"><i class="fa fa-floppy-o"></i></button>
                                                    <button class="btn btn-primary" uib-tooltip="Delete" ng-click="removeExpense($index)"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center">
                                                        <button class="btn btn-info" ng-click="addExpense()">Add More</button>&nbsp;&nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-sm-offset-4 col-sm-6 col-xs-12 container">
                                    <button type="button" class="btn btn-danger btn-sm" ng-click="back_remittance()">Back</button>
                                    &nbsp;<button type="button" class="btn btn-success btn-sm" ng-click="next_cash_breakdown()" ng-if="remittance.expenses.length > 0">Next</button>
                                </div>
                            </div>
                        </div>

                        <div class="well col-sm-12" ng-show="form.cash_breakdown">
                            <h4 style="margin-top: 0;">Cash Breakdown</h4>
                            <div class="row">
                                <div class="col-md-12 table-responsive">
                                    <table class="table table-striped table-condensed table-bordered" id="cash_breakdown_items">
                                        <thead>
                                            <tr>
                                                <th>Denomination</th>
                                                <th>No. of Pieces</th>
                                                <th>Amount</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="update_cash_breakdown in remittance.cash_breakdown track by $index">
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input class="form-control" id="denomination" name="denomination" type="text" ng-model="update_cash_breakdown.denomination" ng-change="breakDownTotalAmount($index,'update',update_cash_breakdown)">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input class="form-control" id="pieces" name="pieces" type="text" ng-model="update_cash_breakdown.pieces" ng-change="breakDownTotalAmount($index,'update',update_cash_breakdown)">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input id="update-amount-[[update_cash_breakdown.id]]" class="form-control" id="amount" name="amount" type="text" disabled="disabled" ng-model="update_cash_breakdown.amount">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success" uib-tooltip="Save" ng-click="updateCashBreakdown($index,update_cash_breakdown)"><i class="fa fa-floppy-o"></i></button>
                                                    <button class="btn btn-primary" uib-tooltip="Delete" ng-click="deleteCashBreakdown($index,update_cash_breakdown)"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr ng-repeat="create_cash_breakdown in createCashBreakdown track by $index">
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input class="form-control" id="denomination" name="denomination" type="text" ng-model="create_cash_breakdown.denomination" ng-change="breakDownTotalAmount($index,'create',create_cash_breakdown)">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input class="form-control" id="pieces" name="pieces" type="text" ng-model="create_cash_breakdown.pieces" ng-change="breakDownTotalAmount($index,'create',create_cash_breakdown)">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <div class="form-group">
                                                         <div class="col-xs-12 col-sm-12">
                                                             <input id="create-amount-[[$index]]" class="form-control" id="amount" name="amount" type="text" disabled="disabled" ng-model="create_cash_breakdown.amount">
                                                         </div>
                                                     </div>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success" uib-tooltip="Save" ng-click="saveCashBreakdown($index,create_cash_breakdown,remittance.id)"><i class="fa fa-floppy-o"></i></button>
                                                    <button class="btn btn-primary" uib-tooltip="Delete" ng-click="removeCashBreakdown($index)"><i class="fa fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center">
                                                        <button class="btn btn-info"  ng-click="addCashBreakdown()">Add More</button>&nbsp;&nbsp;
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-sm-offset-4 col-sm-6 col-xs-12 container">
                                    <button type="button" class="btn btn-danger btn-sm" ng-click="back_expenses()">Back</button>
                                    &nbsp;<a class="btn btn-info btn-sm" target="_blank" href="/controller/remittance-expenses-report/[[remittance.id]]?preview=true" ng-if="remittance.cash_breakdown.length > 0">Preview</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function setSalesmanDetails(el,target_el)
    {
        var jrSalesman = [];
        @foreach($jrSalesmans as $k => $val)
            jrSalesman.push('{{ $k }}');
        @endforeach

        var sel = $(el).val();
        if(-1 !== $.inArray(sel,jrSalesman)) {
            $('select[name=' + target_el + ']').val(sel);
        } else {
            $('select[name=' + target_el + ']').val('');
        }
    }
</script>