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
			case 'salescollectionposting';
				return $this->getSalesCollectionReport();
				break;
			case 'salescollectionsummary';
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
				['a1'=>'1000_10003574',
				 'a2' =>'1000_BARDS-Blue Ice Store',
				 'a3' =>'',
				 'a4' => 'CBA0011',
				 'a5' => '08/03/2015',
				 'a6' => '1,562.50',
				 'a7' => '',
				 'a8' => '31.25',
				 'a9' => '1,531.25',
				 'a10' => '1,562.50',
				 'a11' => '1,562.50',
				 'a12' => '1,562.50',
				 'a13' => '1,562.50',
				 'a14' => '1,562.50',
				 'a15' => '1,562.50',
				 'a16' => '1,562.50',
				 'a17' => '1,562.50',
				 'a18' => '1,562.50',
				 'a19' => '1,562.50',
				 'a20' => '1,562.50',
				 'a21' => '1,562.50',
				 'a22' => '1,562.50',
				 'a23' => '1,562.50',
				 'a24' => '1,562.50',
				 'a25' => '1,562.50',
				 'a26' => '1,562.50',
				 'a27' => '1,562.50'			
				], 
				
		];
		return response()->json($data);
	}
	
	
}
