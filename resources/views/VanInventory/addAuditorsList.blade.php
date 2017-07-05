{!!Html::breadcrumb(['Van Inventory','Auditors List', $state])!!}
{!!Html::pageheader($state)!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <h4>Auditors List</h4>
                        </div>                  
                        <div class="pull-right">
                            <a href="#auditors.list" class="btn btn-success btn-sm">Back to Auditors List</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                
                    <div class="col-sm-12">
                    
                    </div>

                    <div class="pull-left col-sm-6 well">
                        <div class="row form-input-field">
                            {!!Html::select('auditor_id','Auditor <span class="required">*</span>', $auditors,'')!!}
                        </div>

                        <div class="row form-input-field">
                            {!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman,'',[])!!}
                        </div>

                        <div class="row form-input-field">
                            {!!Html::select('area_code','Area <span class="required">*</span>', $areas,'')!!}
                        </div>

                        <div class="row form-input-field">
                            {!!Html::select('type','Type <span class="required">*</span>',['canned' => 'Canned & Mixes', 'frozen' => 'Frozen & Kassel'],'')!!}
                        </div>

                        <div class="row form-input-field">
                            {!!Html::datepicker('period','Period <span class="required">*</span>','true')!!}
                        </div>
                    </div>

                    @if($navigationActions['can_save'])
                        <div class="rs-mini-toolbar">
                            <div class="rs-toolbar-savebtn">
                                <a class="button-primary revgreen" ng-click="save()" id="button_save_slide-tb" original-title="" style="display: block; cursor:pointer;">
                                    <i class="fa fa-floppy-o" style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>
                                    Save
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>