<?php

Html::macro('mass_edit', function($select_options) {
    $html =       '<div ng-if="showMassEdit">';
    $html .=          '<div class="row">';
    $html .=              '<div class="col-sm-6">';
    $html .=                  '<form class="form-horizontal">';
    $html .=                      '<div class="form-group">';
    $html .=                          '<label class="col-sm-3">Mass Edit Field:</label>';
    $html .=                          '<div class="col-sm-9">';
    $html .=                              '<select class="form-control" ng-model="mass_edit.edit_field">';

                                          foreach ($select_options as $option) {
    $html .=                                  '<option value="' . $option['value'] . '">'. $option['name'] .'</option>';
                                          }

    $html .=                              '</select>';
    $html .=                          '</div>';
    $html .=                      '</div>';
    $html .=                      '<div class="form-group">';
    $html .=                          '<label class="col-sm-3">Remarks:</label>';
    $html .=                          '<div class="col-sm-9">';
    $html .=                              '<textarea class="form-control inner-addon fxresize" maxlength="150" ng-model="mass_edit.comment" name="comment" rows="5" id="mass-edit-comment"></textarea>';
    $html .=                          '</div>';
    $html .=                      '</div>';
    $html .=                      '<div class="form-group button-filter">';
    $html .=                          '<button type="button" class="btn btn-info btn-sm" ng-click="submitMassEdit()">Submit</button>';
    $html .=                          '&nbsp;<button type="button" class="btn btn-info btn-sm" ng-click="hideMassEditPage()">Cancel</button>';
    $html .=                      '</div>';
    $html .=                  '</form>';
    $html .=              '</div>';
    $html .=          '</div>';
    $html .=      '</div>';
    return $html;
});