/**
 * Application configuration list
 */

(function(){
	'use strict';
		
	var app = angular.module('app');
	
	app.run(function(editableOptions, editableThemes) {
		  editableThemes.bs3.inputClass = 'input-sm';
		  editableThemes.bs3.buttonsClass = 'btn-sm';
		  editableOptions.theme = 'bs3';
	});
	
})();