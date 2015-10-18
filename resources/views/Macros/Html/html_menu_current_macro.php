<?php
/**
 * Macro template for currentMenu
*/

Html::macro('currentState', function($route){
	$url = Request::root().''.$route;
	return (Request::url() == $url) !== false ? 'current' : '';
});