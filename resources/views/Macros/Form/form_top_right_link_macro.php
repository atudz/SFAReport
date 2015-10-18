<?php

/**
 * Macro template for top right link
 */
Form::macro('topRightLink', function($name,$link){

	$openDiv = '<div class="top-right-menu-body">';
	$link = '<a href="'.$link.'" class="btn btn-success btn-table-list">'.$name.'</a>';
	$closeDiv = '</div>';
	$html = $openDiv.$link.$closeDiv;
	return $html;
});