/**
 * Application module list
 */

(function(){
	'use strict';
		
	angular.module('app', ['ngRoute','xeditable'], function($interpolateProvider) {
	    $interpolateProvider.startSymbol('[[');
	    $interpolateProvider.endSymbol(']]');
	});
})();
