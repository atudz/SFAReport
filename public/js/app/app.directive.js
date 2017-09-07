/**
 * 
 */

(function(){
	'use strict';
		
	var app = angular.module('app');
	
	app.directive('price', [function () {
	    return {
	        require: 'ngModel',
	        link: function (scope, element, attrs, ngModel) {
	            attrs.$set('ngTrim', "false");
	            
	            var formatter = function(str, isNum) {
	                str = String( Number(str || 0) / (isNum?1:100) );
	                str = (str=='0'?'0.0':str).split('.');
	                str[1] = str[1] || '0';
	                return str[0].replace(/(\d)(?=(\d\d\d)+(?!\d))/g, '$1,') + '.' + (str[1].length==1?str[1]+'0':str[1]);
	            }
	            var updateView = function(val) {
	                scope.$applyAsync(function () {
	                    ngModel.$setViewValue(val || '');
	                    ngModel.$render();
	                });
	            }
	            var parseNumber = function(val) {
	                var modelString = formatter(ngModel.$modelValue, true);
	                var sign = {
	                    pos: /[+]/.test(val),
	                    neg: /[-]/.test(val)
	                }
	                sign.has = sign.pos || sign.neg;
	                sign.both = sign.pos && sign.neg;
	                
	                if (!val || sign.has && val.length==1 || ngModel.$modelValue && Number(val)===0) {
	                    var newVal = (!val || ngModel.$modelValue && Number()===0?'':val);
	                    if (ngModel.$modelValue !== newVal)
	                        updateView(newVal);
	                    
	                    return '';
	                }
	                else {
	                    var valString = String(val || '');
	                    var newSign = (sign.both && ngModel.$modelValue>=0 || !sign.both && sign.neg?'-':'');
	                    var newVal = valString.replace(/[^0-9]/g,'');
	                    var viewVal = newSign + formatter(angular.copy(newVal));

	                    if (modelString !== valString)
	                        updateView(viewVal);

	                    return (Number(newSign + newVal) / 100) || 0;
	                }
	            }
	            var formatNumber = function(val) {
	                if (val) {
	                    var str = String(val).split('.');
	                    str[1] = str[1] || '0';
	                    val = str[0] + '.' + (str[1].length==1?str[1]+'0':str[1]);
	                }
	                return parseNumber(val);
	            }
	            
	            ngModel.$parsers.push(parseNumber);
	            ngModel.$formatters.push(formatNumber);
	        }
	    };
	}]);
	
})();
