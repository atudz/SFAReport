{!!Html::breadcrumb(['User Management','Contact Us'])!!}
{!!Html::pageheader('Contact Us')!!}

<div class="row text-left">
    <div class="col-lg-12 text-left">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-sm-10 well">
                    {!!Html::error('error','error_list_contact')!!}
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','name','Name <span class="required">*</span>','', ['ng-model' => 'contact.name'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','mobile','Mobile Number. <span class="required">*</span>','', ['ng-model' => 'contact.mobile'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','telephone','Telephone Number. <span class="required">*</span>','', ['ng-model' => 'contact.telephone'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','email','Email <span class="required">*</span>','', ['ng-model' => 'contact.email'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::select('branch','Branch <span class="required">*</span>', $branch,'',['ng-model' => 'contact.branch'])!!}
                    </div>
                    <h4 style="margin-bottom: 20px; text-align:left" class="page-header">Best Time To Call</h4>
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','callFrom','From <span class="required">*</span>','', ['ng-model' => 'contact.callFrom'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::input('text','callTo','To <span class="required">*</span>','', ['ng-model' => 'contact.callTo'])!!}
                    </div>
                    <div class="row form-input-field text-left" style="margin-top: 40px;">
                        {!!Html::input('text','subject','Subject <span class="required">*</span>','', ['ng-model' => 'contact.subject'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::text('message','Message <span class="required">*</span>','', ['ng-model' => 'contact.message'])!!}
                    </div>
                </div>

                <div class="rs-mini-toolbar">
                    <div class="rs-toolbar-savebtn">
                        <a class="button-primary revgreen" ng-click="save()" id="button_save_slide-tb" original-title=""
                           style="display: block; cursor:pointer;">
                            <i class="fa fa-paper-plane"
                               style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>
                            Send
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
