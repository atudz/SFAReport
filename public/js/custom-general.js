(function(){
	
	'use strict';
	
	angular.module('app').directive("collapseNav", function($log){
	  var b = {
	  restrict: "A",
	  link: function(a,b){

		$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
			$(this).find('em:first').toggleClass("glyphicon-minus");
			var id = $(this).attr('href');
			$(this).parent().parent().find(id).slideToggle().toggleClass('in');

		}); 
		$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");

		$(document).on("click","button.navbar-toggle", function(){		  
			$('#sidebar-collapse').slideToggle().toggleClass('show');
		}); 

		$(document).on("click",".dropdown-toggle", function(e){
			e.stopPropagation();		  
			$(this).parent().toggleClass('open')
		}); 

		$(document).click(function(){
		   $('.dropdown-toggle').parent().removeClass('open');
		});

	  	}
	  };
	  return b
	});

})();




