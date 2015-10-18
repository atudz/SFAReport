<?php
/**
 * Macro template for activeMenu
*/

Html::macro('activeState', function($route){
	$url = Request::root().''.$route;
	return strpos(Request::url(), $url) !== false ? 'active' : '';
});