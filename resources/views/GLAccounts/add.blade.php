{!!Html::breadcrumb(['GL Accounts', $state])!!}
{!!Html::pageheader($state)!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="pull-left">
                            <h4>GL Accounts</h4>
                        </div>
                        <div class="pull-right">
                            <a href="#gl.accounts" class="btn btn-success btn-sm">Back to GL Accounts</a>
                        </div>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="col-sm-12">
                    </div>

                    <div class="col-md-12 well">
                        <div class="row">
                            <div class ="col-md-8">
                                <div class="row form-input-field">
                                    {!!Html::input('text','code','Code')!!}
                                </div>
                                <div class="row form-input-field">
                                    {!!Html::input('text','description','Description')!!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rs-mini-toolbar">
                        <div class="rs-toolbar-savebtn">
                            <a class="button-primary revgreen" ng-click="save()" id="button_save_slide-tb" original-title="" style="display: block; cursor:pointer;">
                                <i class="fa fa-floppy-o" style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>
                                Save
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>