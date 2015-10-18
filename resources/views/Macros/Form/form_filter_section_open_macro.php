<?php

Form::macro('filterSectionOpen', function($side='left') {
	return '<div class="filter-'.$side.'">';
});