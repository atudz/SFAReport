<?php

Html::macro('pageheader', function($title) {

	$html = '<div class="row">
			 <div class="col-lg-12">
				<h4 class="page-header">'.$title.'</h4>
			 </div>
			 </div>';

	return $html;
});