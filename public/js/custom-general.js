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

		var windowWD = $(window).width();

		if(windowWD >= 750) {
			$(document).on("click","button.navbar-toggle-2", function(){		  
				
				var sc = $('#sidebar-collapse').width();
				var os = $('#sidebar-collapse').offset().left;
				
				if(os == 0) {
					$('#sidebar-collapse').animate({ "left": "-="+sc+"px" }, "fast" );
					$('.main').removeClass('col-sm-offset-3 col-lg-offset-2 col-lg-10 col-sm-9');
					$('.main').addClass('col-lg-12 col-sm-12');
					var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 5;

	    			$("table.table").floatThead('reflow');
					console.log('Trigger Menu reBuild Table. Scroll value: '+scrollpos);

	                $(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);

				} else {
					$('#sidebar-collapse').animate({ "left": "+="+sc+"px" }, "600" );
					$('.main').addClass('col-sm-offset-3 col-lg-offset-2 col-lg-10 col-sm-9');
					$('.main').removeClass('col-lg-12 col-sm-12');
					var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 5;

	    			$("table.table").floatThead('reflow');
					console.log('Trigger Menu reBuild Table. Scroll value: '+scrollpos);

	                $(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
				}

			});
		}

		$(window).resize(function() {
			var wd = $(this).width();
			if(wd >= 750) {
				$('#sidebar-collapse').css({"left": "0px", "display":"block"});
				$('.main').addClass('col-sm-offset-3 col-lg-offset-2 col-lg-10 col-sm-9');
				$('.main').removeClass('col-lg-12 col-sm-12');
				var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 5;

    			$("table.table").floatThead('reflow');
				console.log('Trigger Menu reBuild Table. Scroll value: '+scrollpos);

                $(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
			}
		});

		$(document).click(function(){
		   $('.dropdown-toggle').parent().removeClass('open');
		});

	  	}
	  };
	  return b
	});

})();




