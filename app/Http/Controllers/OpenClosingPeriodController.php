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
        $request_data = $request->all();
        $period = ModelFactory::getInstance('Period')->whereId($request_data['period_id'])->first();
        $navigation = ModelFactory::getInstance('Navigation')->where('id','=', $period->navigation_id)->first();

        try{
            ModelFactory::getInstance('Period')
                ->whereId($request_data['period_id'])
                ->update([
                    'period_status' => $request_data['period_status']
                ]);

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                'action'        => 'updating status - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($period->period_year .'-' . $period->period_month . '-01')) . ' to ' . $request_data['period_status']
            ]);

            return response()->json(['success'=>true,'data'=>$request_data]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                'action'        => 'error updating status - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($period->period_year .'-' . $period->period_month . '-01')) . ' to ' . $request_data['period_status']
            ]);

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
        $request_data = $request->all();
        $dates = $request_data['dates'];
        unset($request_data['dates']);
        $navigation = ModelFactory::getInstance('Navigation')->where('id','=',$request_data['navigation_id'])->first();

        try{
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                'action'        => 'processing ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-01'))
            ]);

            if(is_null($request_data['period_id'])){
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'       => auth()->user()->id,
                    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                    'action'        => 'not found - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-01'))
                ]);

                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'       => auth()->user()->id,
                    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                    'action'        => 'creating - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-01'))
                ]);

                $period = ModelFactory::getInstance('Period')->create([
                    'company_code'  => $request_data['company_code'],
                    'period_month'  => $request_data['period_month'],
                    'period_year'   => $request_data['period_year'],
                    'navigation_id' => $request_data['navigation_id'],
                    'period_status' => 'open'
                ]);

                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'       => auth()->user()->id,
                    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                    'action'        => 'finished creating - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-01'))
                ]);

                $request_data['period_id'] = $period->id;
            }

            foreach ($dates as $key_date => $value_date) {
                if(ModelFactory::getInstance('PeriodDate')->wherePeriodId($request_data['period_id'])->wherePeriodDate($key_date)->first()){
                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'       => auth()->user()->id,
                        'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                        'action'        => 'updating period status - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-' . $key_date)) . ' to ' . $value_date
                    ]);

                    ModelFactory::getInstance('PeriodDate')
                        ->wherePeriodId($request_data['period_id'])
                        ->wherePeriodDate($key_date)
                        ->update(['period_date_status' => $value_date]);

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'       => auth()->user()->id,
                        'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                        'action'        => 'finished updating period status - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-' . $key_date)) . ' to ' . $value_date
                    ]);
                } else {
                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'       => auth()->user()->id,
                        'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                        'action'        => 'not found - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-' . $key_date))
                    ]);

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'       => auth()->user()->id,
                        'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                        'action'        => 'creating period status- ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-' . $key_date))
                    ]);

                    ModelFactory::getInstance('PeriodDate')
                        ->create([
                            'period_id'          => $request_data['period_id'],
                            'period_date'        => $key_date,
                            'period_date_status' => $value_date
                        ]);

                    ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'       => auth()->user()->id,
                        'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                        'action'        => 'finished creating period status - ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-' . $key_date)) . ' to ' . $value_date
                    ]);
                }
            }

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                'action'        => 'finished processing ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-01'))
            ]);

            $request_data['dates'] = $dates;
            return response()->json(['success'=>true,'data'=>$request_data]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'       => auth()->user()->id,
                'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','open-closing-period')->value('id'),
                'action'        => 'error processing ' . $navigation->name . ' Open/Closing Period data for ' . date('F Y',strtotime($request_data['period_year'] .'-' . $request_data['period_month'] . '-01'))
            ]);
            return response()->json(['success'=> false]);
        }
    }
}