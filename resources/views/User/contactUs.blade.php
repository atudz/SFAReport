{!!Html::breadcrumb(['Support Page','Contact Us'])!!}
{!!Html::pageheader('Contact Us')!!}

<div class="row text-left">
    <div class="col-lg-12 text-left">
        <div class="panel panel-default">
            <div class="panel-body contact-file-form">
                <div class="col-sm-8 well">
                    <div class="pull-left col-md-12 alert alert-success" ng-show="success"
                         style="margin-bottom:10px;padding-left:0px;">
                        <button type="button" class="close" aria-label="Close" ng-click="success = !success"><span
                                    aria-hidden="true">&times;</span></button>
                        <div class="error-list">Successfully sent.</div>
                    </div>
                    <div class="pull-left col-md-12 alert alert-info" ng-show="loading"
                         style="margin-bottom:10px;padding-left:0px;">
                        <span><i class="fa fa-spinner fa-lg fa-pulse"></i> Sending email please wait for a while.</span>
                    </div>
                    {!!Html::error('error','error_list_contact')!!}
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','name','Name <span class="required">*</span>','', ['ng-model' => 'contact.name', 'data-required' => 'true'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','mobile','Mobile Number <span class="required">*</span>','', ['ng-model' => 'contact.mobile', 'data-required' => 'true'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','telephone','Telephone Number <span class="required">*</span>','', ['ng-model' => 'contact.telephone', 'data-required' => 'true'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','email','Email <span class="required">*</span>','', ['ng-model' => 'contact.email', 'data-required' => 'true'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::select('branch','Branch <span class="required">*</span>', $branch,'',['ng-model' => 'contact.branch', 'data-required' => 'true'])!!}
                    </div>
                    <h4 style="margin-bottom: 20px; text-align:center" class="page-header">Best Time To Call</h4>
                    <div class="row form-input-field text-left">
                        <div class="form-group">
                            <div class="col-xs-12 col-md-4 col-sm-4 control-label">
                                <label for="name" class="">Call From <span class="required">*</span></label>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <input class="timepicker text-center form-control" name="time_from" id="callFrom"
                                       data-required="true">
                            </div>
                        </div>
                    </div>
                    <div class="row form-input-field text-left">
                        <div class="form-group">
                            <div class="col-xs-12 col-md-4 col-sm-4 control-label">
                                <label for="name" class="">Call To <span class="required">*</span></label>
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <input class="timepicker text-center form-control" name="time_to" id="callTo"
                                       data-required="true">
                            </div>
                        </div>
                    </div>
                    <div class="row form-input-field text-left" style="margin-top: 40px;">
                        {!!Html::input('text','subject','Subject <span class="required">*</span>','', ['ng-model' => 'contact.subject', 'data-required' => 'true'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::text('message','Message <span class="required">*</span>','', ['ng-model' => 'contact.message', 'data-required' => 'true'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        <div class="col-xs-12 col-md-4 col-sm-4 control-label">
                            <label for="name" class="">Attach File</label>
                        </div>
                        <div class="col-xs-12 col-sm-8">
                            <input type="file" name="file" id="contactFile"
                                   onchange="angular.element(this).scope().readFile(this.files)"
                                   class="form-control"/>
                        </div>
                    </div>
                    <div class="row pull-right">
                        <div class="col-xs-12 col-md-3 col-sm-4">
                            <button type="reset" class="btn btn-primary" ng-click="resetFile()">reset file</button>
                        </div>
                    </div>      
                    <div class="clearfix"></div>                                  
					<div class="col-md-4 col-md-offset-4" style="padding-top:10px;">
						<button class="btn btn-success" ng-click="save()"><i class="fa fa-paper-plane"></i> &nbsp;Send</button>					
					</div>
                </div>                
                
            </div>
        </div>
    </div>
</div>
