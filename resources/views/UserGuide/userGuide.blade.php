{!!Html::breadcrumb(['User Guide'])!!}
{!!Html::pageheader('User Guide')!!}
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="text-left col-md-12 alert alert-success" ng-show="alerts.success" id="divSuccess"
                     style="margin-bottom:10px;padding-left:0px;">
                    <button type="button" class="close" aria-label="Close" ng-click="alerts.success = !alerts.success"><span
                                aria-hidden="true">&times;</span></button>
                    <div class="error-list">Successfully sent.</div>
                </div>
                <div class="text-left col-md-12 alert alert-danger" ng-show="alerts.error" id="error_user_guide"
                     style="margin-bottom:10px;padding-left:0px;">
                    <div class="error-list">[[ alerts.errorMessage ]]</div>
                </div>
                {!!Html::topen(['no_download'=>true,'no_search'=>true])!!}
                {!!Html::theader($tableHeaders)!!}
                <tbody>
                <tr ng-repeat="record in records">
                    <td>[[record.name]]</td>
                    <td>[[(record.file) ? record.file.filename : '--']]</td>
                    <td>
                        <div class="row" ng-show="!uploading">
                            <div class="[[ logged.group.name == 'Supper Admin' ? 'col-sm-6' : 'col-sm-12' ]] text-center">
                                <a href="/controller/user/userguide/download/[[record.file.id]]">
                                    <span><i class="fa fa-download text-success"></i></span>
                                </a>
                            </div>
                            <div class="col-sm-6" ng-if="logged.group.name == 'Supper Admin'">
                                <label for="[[record.name]]" id="lblUpload">
                                    <i class="fa fa-upload text-primary"></i>
                                </label>
                                <input class="btn btn-info hidden form-control" type="file" name="file"
                                       id="[[record.name]]"
                                       onchange="angular.element(this).scope().readFile(this.files, this.id)">
                            </div>
                        </div>
                        <div class="row" ng-show="uploading">
                            <div class="col-sm-12">
                                <div class="text-center">
                                    <span class="text-success"><i class="fa fa-spinner fa-lg fa-pulse"></i> Uploading....</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
                {!!Html::tfooter(true,3)!!}
                {!!Html::tclose(false)!!}
            </div>
        </div>
    </div>
</div>
