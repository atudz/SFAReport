{!!Html::breadcrumb(['User Management','Summary of Incident Report','Status Reply Form'])!!}
{!!Html::pageheader('Status Reply Form')!!}

<div class="row text-center">
    <div class="col-lg-12 text-center">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="col-sm-6 well">
                    {!!Html::error('error','error_list_status_reply')!!}
                    <div class="row form-input-field text-left" style="margin-top: 40px;">
                        {!!Html::input('text','subject','Subject <span class="required">*</span>','', ['ng-model' => 'reply.subject'])!!}
                    </div>
                    <div class="row form-input-field text-left">
                        {!!Html::text('message','Message <span class="required">*</span>','', ['ng-model' => 'reply.message'])!!}
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
