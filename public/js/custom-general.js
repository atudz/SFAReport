(function(){
	
	'use strict';
	
	angular.module('app').directive("collapseNav", function($log){
	  var b = {
	  restrict: "A",
	  link: function(a,b){

		$(document).on("click","ul.nav li.parent a", function(){
			var parent = $(this).parent(); 
			$(parent).find('em:first').toggleClass("glyphicon-minus");
			var id = $(parent).attr('href');
			$(parent).find(id).stop().slideToggle().toggleClass('in');

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


			$(document).on("click","button.navbar-toggle-2", function(e){		  
				e.preventDefault();

				var sc = $('#sidebar-collapse').width();
				var os = $('#sidebar-collapse').offset().left;

				if(os == 0) {
					$('#sidebar-collapse').stop('true','true').css({ "left": "-="+sc+"px" });
					$('.main').removeClass('col-sm-offset-3 col-lg-offset-2 col-lg-10 col-sm-9');
					$('.main').addClass('col-lg-12 col-sm-12');

					//head table
					var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 5;
					$("table.table").floatThead('reflow');
					$(".floatThead-wrapper .wrapper").stop('true','true').animate({scrollLeft: scrollpos}, 800);
					
	                

				} else {
					$('#sidebar-collapse').stop('true','true').css({ "left": "+="+sc+"px" });
					$('.main').addClass('col-sm-offset-3 col-lg-offset-2 col-lg-10 col-sm-9');
					$('.main').removeClass('col-lg-12 col-sm-12');

					//table head
					var scrollpos = $(".floatThead-wrapper .wrapper").scrollLeft() - 5;
					$("table.table").floatThead('reflow');
                	$(".floatThead-wrapper .wrapper").stop('true','true').animate({scrollLeft: scrollpos}, 800);
					
	    			
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
				//console.log('Trigger Menu reBuild Table. Scroll value: '+scrollpos);

                $(".floatThead-wrapper .wrapper").animate({scrollLeft: scrollpos}, 800);
			}
		});
		  var idleTime = 0;
		  $(document).click(function () {
			  $('.dropdown-toggle').parent().removeClass('open');
		  });

		  $(document).ready(function () {
			  //Increment the idle time counter every minute.
			  var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

			  //Zero the idle timer on mouse movement.
			  $(this).mousemove(function (e) {
				  idleTime = 0;
			  });
			  $(this).keypress(function (e) {
				  idleTime = 0;
			  });
		  });

		  function timerIncrement() {
			  idleTime = idleTime + 1;
			  if (idleTime > 30) { // 19 minutes
				  window.location.href = '/logout';
			  }
		  }

	  	}
	  };
	  return b
	});

})();




