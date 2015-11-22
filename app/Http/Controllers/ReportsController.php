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
				 'a10' => '',
				 'a11' => '-',
				 'a12' => 'MBA0001',
				 'a13' => '107.8',
				 'a14' => '(2.16)',
				 'a15' => '105.64',
				 'a16' => '08/03/2015',
				 'a17' => 'CBA0011',
				 'a18' => '423.45',
				 'a19' => ' 1,000.00',
				 'a20' => 'MBTC Lahug',
				 'a21' => '133455',
				 'a22' => '08/15/2015',
				 'a23' => '',
				 'a24' => '',
				 'a25' => '',
				 'a26' => '',
				 'a27' => '1,423.45'			
				],

				['a1'=>'1000_10003615',
				'a2' =>'1000_BARDS-Dela Peña Store ',
				'a3' =>'',
				'a4' => 'CBA0012',
				'a5' => '08/03/2015',
				'a6' => '1,562.50',
				'a7' => '',
				'a8' => '31.25',
				'a9' => '1,531.25',
				'a10' => '',
				'a11' => '-',
				'a12' => 'MBA0002',
				'a13' => '210.70',
				'a14' => '(4.21)',
				'a15' => '206.49',
				'a16' => '08/03/2015',
				'a17' => 'CBA0012',
				'a18' => '423.45',
				'a19' => '1000<br>320.55',
				'a20' => 'BPI Carcar<br>BPI Pacific Mall',
				'a21' => '133455',
				'a22' => '08/15/2015',
				'a23' => '',
				'a24' => '',
				'a25' => '',
				'a26' => '',
				'a27' => '1,423.45'
						],
				
				
				['a1'=>'Total',
				'a2' =>'',
				'a3' =>'',
				'a4' => '',
				'a5' => '',
				'a6' => ' 3,125.00',
				'a7' => '',
				'a8' => '62.50',
				'a9' => ' 3,062.50',
				'a10' => '-',
				'a11' => '-',
				'a12' => '-',
				'a13' => ' 318.50',
				'a14' => ' (6.37)',
				'a15' => ' 312.13',
				'a16' => ' ',
				'a17' => '',
				'a18' => '-',
				'a19' => ' 423.45',
				'a20' => ' 2,320.55',
				'a21' => '',
				'a22' => '',
				'a23' => '',
				'a24' => '',
				'a25' => '',
				'a26' => '',
				'a27' => ' 2,744.00'
						],
				
		];
		return response()->json($data);
	}
	
	
}
