/**
 * Application module list
 */

(function(){
	'use strict';
		
	angular.module('app', ['ngRoute','ngAnimate','xeditable','ui.bootstrap','ngTable'], function($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});
})();
