(function(){
	'use strict';

	var app = angular.module('app');

	/*Table Injection Reflow*/
	app.factory('EditableFixTable',function(){
        return {
            eft: function(){
                var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 20;

    			$("table.table").floatThead('reflow');
				console.log('Load Editable Factory. Scroll value: '+scrollpos);

                $(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
            }
        };
    });

	/*Table Injection*/
	app.factory('TableFix',function(){
        return {
            tableload: function(){
      		
    			$("table.table").floatThead({
				    position: "absolute",
				    autoReflow: true,
				    zIndex: "2",
				    scrollContainer: function($table){
				        return $table.closest(".wrapper");
				    }
				});
    			console.log('Load TableFix Factory!');

            }
        };
    });

    /*Table Injection*/
	app.factory('InventoryFixTable',function(){
        return {
            ift: function(){
      		
    			$("table.table").floatThead({
				    position: "absolute",
				    autoReflow: true,
				    zIndex: "2",
				    scrollContainer: function($table){
				        return $table.closest(".wrapper");
				    }
				});
    			console.log('Load Inventory Factory!');

            }
        };
    });


})();