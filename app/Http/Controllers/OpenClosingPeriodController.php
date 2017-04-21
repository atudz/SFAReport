<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use Illuminate\Http\Request;

class OpenClosingPeriodController extends ControllerCore
{
    /**
     * Update the status of a certain period to close/open
     * @param  Request [retrieves route parameters or variables]
     * @return json
     */
    public function updateStatus(Request $request)
    {
        try{
            $request_data = $request->all();

            ModelFactory::getInstance('Period')
                ->whereId($request_data['period_id'])
                ->update([
                    'period_status' => $request_data['period_status']
                ]);

            return response()->json(['success'=>true,'data'=>$request_data]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update the date of a certain period to close/open
     * If period not yet found the system creates it
     * @param  Request [retrieves route parameters or variables]
     * @return json
     */
    public function updateDate(Request $request)
    {
        try{
            $request_data = $request->all();
            $dates = $request_data['dates'];
            unset($request_data['dates']);

            if(is_null($request_data['period_id'])){
                $period = ModelFactory::getInstance('Period')->create([
                    'company_code' => $request_data['company_code'],
                    'period_month' => $request_data['period_month'],
                    'period_year' => $request_data['period_year'],
                    'navigation_id' => $request_data['navigation_id'],
                    'period_status' => 'open'
                ]);
                $request_data['period_id'] = $period->id;
            }

            foreach ($dates as $key_date => $value_date) {
                if(ModelFactory::getInstance('PeriodDate')->wherePeriodId($request_data['period_id'])->wherePeriodDate($key_date)->first()){
                    ModelFactory::getInstance('PeriodDate')
                        ->wherePeriodId($request_data['period_id'])
                        ->wherePeriodDate($key_date)
                        ->update(['period_date_status' => $value_date]);
                } else {
                    ModelFactory::getInstance('PeriodDate')
                        ->create([
                            'period_id' => $request_data['period_id'],
                            'period_date' => $key_date,
                            'period_date_status' => $value_date
                        ]);
                }
            }

            $request_data['dates'] = $dates;
            return response()->json(['success'=>true,'data'=>$request_data]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }
}