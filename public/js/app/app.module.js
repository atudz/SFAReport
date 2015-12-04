/**
 * Application module list
 */

(function(){
	'use strict';
		
	angular.module('app', ['ngRoute','ngAnimate','xeditable','ui.bootstrap'], function($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});
})();
