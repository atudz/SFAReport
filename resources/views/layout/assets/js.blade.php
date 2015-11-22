<script src="{{ URL::asset('js/plugin/jquery-1.11.1.min.js') }}"></script>
<script src="{{ URL::asset('js/plugin/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('js/plugin/bootstrap-datepicker.js') }}"></script>
<script src="{{ URL::asset('js/plugin/bootstrap-table.js') }}"></script>
<script src="{{ URL::asset('js/plugin/angular/angular.min.js') }}"></script>
<script src="{{ URL::asset('js/plugin/angular-route/angular-route.min.js') }}"></script>	
<script src="{{ URL::asset('js/custom-general.js') }}"></script>
@if(auth()->user())
	<script src="{{ URL::asset('js/app/app.module.js') }}"></script>
	<script src="{{ URL::asset('js/app/app.routes.js') }}"></script>	
@endif

<script type="text/javascript">
            $(function () {
                $('#datetimepicker1').datetimepicker();
            });
        </script>