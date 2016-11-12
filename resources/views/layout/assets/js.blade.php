<script type="text/javascript" src="{{ URL::asset('js/components/packages/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular/angular.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-resource/angular-resource.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-route/angular-route.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-bootstrap/ui-bootstrap-tpls.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-animate/angular-animate.min.js') }}"></script>     
<script type="text/javascript" src="{{ URL::asset('js/components/packages/ng-table/dist/ng-table.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-smart-table/dist/smart-table.min.js') }}"></script>     
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-xeditable/dist/js/xeditable.min.js') }}"></script>  
<script type="text/javascript" src="{{ URL::asset('js/components/packages/floatThead/dist/jquery.floatThead.min.js') }}"></script>  
<script type="text/javascript" src="{{ URL::asset('js/components/packages/floatThead/dist/jquery.floatThead-slim.min.js') }}"></script> 
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-endless-scroll/dist/angular-endless-scroll.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/jquery-timepicker-wvega/jquery.timepicker.js') }}"></script>

@if(auth()->user())
	<script src="{{ URL::asset('js/app/app.module.js') }}"></script>
	<script src="{{ URL::asset('js/app/app.config.js') }}"></script>
	<script src="{{ URL::asset('js/app/app.routes.js') }}"></script>
	<script src="{{ URL::asset('js/app/app.directive.js') }}"></script>
	<script src="{{ URL::asset('js/app/app.factory.js') }}"></script>
	<script src="{{ URL::asset('js/app/app.controller.js') }}"></script>
@endif

<script src="{{ URL::asset('js/custom-general.js') }}"></script>

<script type="text/javascript">
	$(document).ready(function () {
        $(".nav ul li a").click(function () {
            $(".nav ul li a").removeClass("active");
            $(this).addClass("active");
        });
    });

	function validateQty(el)
	{
		var val = $(el).val();
		if(val.length == 0) {
			$(el).next('span').html('This field is required.');
			$(el).parent().parent().addClass('has-error');
		}
		else if(val >=0){
			$(el).next('span').html('');
			$(el).parent().parent().removeClass('has-error');
		} else {
			$(el).next('span').html('Quantity must not be negative.');
			$(el).parent().parent().addClass('has-error');	
		}
	}

	function validate(el)
	{
		var id = $(el).attr('id');

		if(-1 !== id.indexOf('_from')){
			console.log('test');
			if($(el).val()){
				$('[id='+id+']').parent().next('.help-block').html('');
				$('[id='+id+']').parent().parent().parent().removeClass('has-error');
			} else {
				$('[id='+id+']').parent().next('.help-block').html('This field is required.');
				$('[id='+id+']').parent().parent().parent().addClass('has-error');
			}
				 
		} else {		
			if($(el).val()){
				$(el).next('span').html('');
				$(el).parent().parent().removeClass('has-error');
			} else {
				$(el).next('span').html('This field is required.');
				$(el).parent().parent().addClass('has-error');
			}
		}
	}
</script>

<script>
	var user = @if(Auth::user()) {!! Auth::user()->load('group') !!} @endif 
</script>