<?php

Html::macro('fclose', function() {

	$html = '<div class="form-group button-filter">
		     <div class="col-sm-offset-4 col-sm-6 col-xs-12 container">
		     	<button type="button" class="btn btn-info btn-sm" ng-click="filter()">Submit</button>
				&nbsp;<button type="reset" class="btn btn-info btn-sm" ng-click="reset()">Reset</button>
		     </div>
		  	 </div>						 
			 </form>			 	
			 </div>
			 </div>
			 </div>';

	return $html;
});