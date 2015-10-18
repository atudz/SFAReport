<?php
use App\Types\OrderType;
/**
 * Macro template for Order Status
 */

Form::macro('orderStatus', function($statusId, $options=[]){

	switch($statusId)
	{
		case OrderType::DELIVERED_STATUS :
				$class = 'label-delivered';
				break;
		case OrderType::PAYMENT_FAILED_STATUS :
				$class = 'label-failed';
				break;
		case OrderType::RECEIVED_STATUS :
				$class = 'label-recieved';
				break;
		default:
				$class = 'label-await';
				break;
									
	}
	
	$attributes = '';
	if($options)
	{
		$attributes = Html::attributes($options);	
	}
	
	return '<span class="label '.$class.'"'.$attributes.'>'.OrderType::getStatusValue($statusId).'</span>';
});