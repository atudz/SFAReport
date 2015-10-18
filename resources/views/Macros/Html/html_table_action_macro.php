<?php

/**
 * Macro template for actions button in 
 */
Html::macro('tableAction', function($tooltip_edit, $edit_url, $tooltip_del, $del_url){
	$edit = '<a tooltip="'.$tooltip_edit.'" href="'.$edit_url.'" class="edit-space"><i class="ti-pencil-alt"></i></a>';
	$delete = '<a tooltip="'.$tooltip_del.'" href="'.$del_url.'" class="edit-space"><i class="ti-trash"></i></a>';
	$html = $edit.$delete;
	return $html;
});