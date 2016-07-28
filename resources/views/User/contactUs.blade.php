{!!Html::breadcrumb(['User Management','Contact Us'])!!}
{!!Html::pageheader('Contact Us')!!}

<div class="row text-center">
    <div class="col-lg-12 text-center">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-sm-6 well">
                    {!!Html::error('error','error_list_contact')!!}
                    <div class="row form-input-field">
                        {!!Html::input('text','name','Name <span class="required">*</span>','', ['ng-model' => 'contact.name'])!!}
                    </div>
                    <div class="row form-input-field">
                        {!!Html::input('text','phone','Phone <span class="required">*</span>','', ['ng-model' => 'contact.phone'])!!}
                    </div>
                    <div class="row form-input-field">
                        {!!Html::input('text','email','Email <span class="required">*</span>','', ['ng-model' => 'contact.email'])!!}
                    </div>
                    <div class="row form-input-field">
                        {{--{!!Html::select('branch','Branch <span class="required">*</span>', '','')!!}--}}
                        {!!Html::input('text','branch','Branch <span class="required">*</span>','', ['ng-model' => 'contact.branch'])!!}
                    </div>
                    <h4 style="margin-bottom: 20px;">Best Time To Call</h4>
                    <div class="row form-input-field">
                        {!!Html::input('text','callFrom','From <span class="required">*</span>','', ['ng-model' => 'contact.callFrom'])!!}
                    </div>
                    <div class="row form-input-field">
                        {!!Html::input('text','callTo','To <span class="required">*</span>','', ['ng-model' => 'contact.callTo'])!!}
                    </div>
                    <div class="row form-input-field">
                        {!!Html::input('text','subject','Subject <span class="required">*</span>','', ['ng-model' => 'contact.subject'])!!}
                    </div>
                    <div class="row form-input-field">
                        {!!Html::input('text','comment','Comment <span class="required">*</span>','', ['ng-model' => 'contact.comment'])!!}
                    </div>
                </div>

                <div class="rs-mini-toolbar">
                    <div class="rs-toolbar-savebtn">
                        <a class="button-primary revgreen" ng-click="save()" id="button_save_slide-tb" original-title=""
                           style="display: block; cursor:pointer;">
                            <i class="fa fa-floppy-o"
                               style="display: inline-block;vertical-align: middle;width: 25px;height: 20px;background-repeat: no-repeat;"></i>
                            Save
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
