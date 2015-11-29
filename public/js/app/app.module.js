/**
 * Application module list
 */

(function(){
	'use strict';
		
	angular.module('app', ['ngRoute','ui.bootstrap'], function($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});
})();
