{!!Html::breadcrumb(['User Guide/ Auditor'])!!}
{!!Html::pageheader('Auditor User Guide')!!}

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="text-left col-md-12 alert alert-success" ng-show="success" id="divSuccess"
                     style="margin-bottom:10px;padding-left:0px;">
                    <button type="button" class="close" aria-label="Close" ng-click="success = !success"><span
                                aria-hidden="true">&times;</span></button>
                    <div class="error-list">Successfully sent.</div>
                </div>
                {!!Html::error('error','error_user_guide')!!}
                <div class="row">
                    <div class="col-sm-12 text-center">
                        @if($role->file)
                            <a href="{{ url('/controller/user/userguide/download/'. $role->file->id)  }}"
                               class="btn btn-success" target="_self" id="downloadFile">Download Now</a>
                        @endif
                        <label class="btn btn-info" for="userGuideFile"
                               ng-show="user.group.name == 'Admin'" id="lblUpload">Upload New User Guide</label>
                        <input class="btn btn-info hidden form-control" type="file" name="file" id="userGuideFile"
                               onchange="angular.element(this).scope().readFile(this.files)">
                    </div>
                </div>
                <div class="row hidden" id="submitFile" style="padding-top: 10px">
                    <div class="col-sm-12 text-left">
                        <button class="btn btn-success col-md-2" type="button" ng-click="submit()" style="margin-right: 5px">Submit</button>
                        <button class="btn btn-default col-md-2" type="reset" ng-click="resetFile()">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
