/**
 * Application module list
 */

(function(){
	'use strict';
		
	angular.module('app', ['ngRoute','ngAnimate','ngResource','xeditable','ui.bootstrap','ngTable','dc.endlessScroll','toaster'], function($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});
})();
