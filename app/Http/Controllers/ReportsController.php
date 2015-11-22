<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;

class ReportsController extends ControllerCore
{

	/**
	 * Get records
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getRecords($type)
	{
		switch($type)
		{
			case 'salescollectionreport';
				return $this->getSalesCollectionReport();
				break;
			case 'salescollectionreport';
				return $this->getSalesCollectionReport();
				break;
			case 'salescollectionreport';
				return $this->getSalesCollectionReport();
				break;
		}
		return $this->getSalesCollectionReport();	
	}
	
	
	/**
	 * Get Sales & Collection Report records
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function getSalesCollectionReport()
	{
		//$data['message'] = 'Hello World';
		$data['records'] = [
				['Name'=>'Abner','Country'=>'Tudtud'],
				['Name'=>'Abner','Country'=>'Tudtud'],
				['Name'=>'Abner','Country'=>'Tudtud'],
				['Name'=>'Abner','Country'=>'Tudtud'],
				['Name'=>'Abner','Country'=>'Tudtud'],
		];
		return response()->json($data);
	}
	
	
}
