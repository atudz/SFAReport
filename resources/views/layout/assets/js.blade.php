<script type="text/javascript" src="{{ URL::asset('js/components/packages/jquery/dist/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular/angular.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-route/angular-route.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-bootstrap/ui-bootstrap-tpls.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-animate/angular-animate.min.js') }}"></script>     
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-smart-table/dist/smart-table.min.js') }}"></script>     
<script type="text/javascript" src="{{ URL::asset('js/components/packages/angular-xeditable/dist/js/xeditable.min.js') }}"></script>     

@if(auth()->user())
	<script src="{{ URL::asset('js/app/app.module.js') }}"></script>
	<script src="{{ URL::asset('js/app/app.routes.js') }}"></script>
	<script src="{{ URL::asset('js/app/app.controller.js') }}"></script>	
@endif

<script src="{{ URL::asset('js/custom-general.js') }}"></script>