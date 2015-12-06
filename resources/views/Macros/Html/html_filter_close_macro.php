<?php

Html::macro('fclose', function() {

	$html = '<div class="form-group">
		     <div class="col-sm-offset-4 col-sm-6">
		     	<button type="button" class="btn btn-info btn-sm">Submit</button>
				&nbsp;<button type="reset" class="btn btn-info btn-sm">Reset</button>
		     </div>
		  	 </div>						 
			 </form>			 	
			 </div>
			 </div>
			 </div>';

	return $html;
});