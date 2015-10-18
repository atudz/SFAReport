<?php

Html::macro('filterValuesClose', function() {
	
	$displayLink = '';
	if(app('session')->has('filters'))
	{
		$data = app('session')->get('filters');
		if(isset($data[app('request')->getPathInfo()]) && $data[app('request')->getPathInfo()])
		{
			$link = Html::link(app('request')->url().'?clear_filter=1','Clear');
			$displayLink = Html::filterValue('Clear Filter',$link);
		}
	}
	
	return  $displayLink.'<br class="clear"></div>';
});