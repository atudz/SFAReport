<?php

Html::macro('topen', function(array $options) {

	$html = '<div class="col-sm-12 table-responsive">							
			<table class="table table-striped table-condensed"'.Html::attributes($options).'>';

	return $html;
});