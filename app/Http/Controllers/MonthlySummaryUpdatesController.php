<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Http\Models\MonthlySummaryUpdate;
use App\Http\Models\MonthlySummaryNote;
use App\Http\Requests\MonthlySummaryAddedTotalRequest;
use App\Http\Requests\MonthlySummaryNotesRequest;

class MonthlySummaryUpdatesController extends ControllerCore
{
    /**
     * Add Monthly Summary Update
     * @param  MonthlySummaryAddedTotalRequest $request
     * @return json
     */
    public function addedTotal(MonthlySummaryAddedTotalRequest $request)
    {
        try {
            $added_total = [];

            $inputs =  $request->only([
                'salesman_code',
                'remarks',
                'summary_date',
                'total_collected_amount',
                'sales_tax',
                'amount_for_commission'
            ]);

            $no_day_date = explode('/', $inputs['summary_date']);
            $inputs['summary_date'] = date('Y-m-d',strtotime($no_day_date[1] . '-' . $no_day_date[0] . '-01'));

            $added_total['data'] = MonthlySummaryUpdate::create($inputs);

            $summary = $request->get('summary');
            $added_total['added_total'] = [
                'updated_total_collected_amount' => $summary['updated_total_collected_amount'] + $inputs['total_collected_amount'],
                'updated_sales_tax'              => $summary['updated_sales_tax'] + $inputs['sales_tax'],
                'updated_amount_for_commission'  => $summary['updated_amount_for_commission'] + $inputs['amount_for_commission'],
            ];
            return response()->json(array_merge(['success'=> true],$added_total));
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update Monthly Summary Update
     * @param  MonthlySummaryAddedTotalRequest $request
     * @return json
     */
    public function updateAddedTotal(MonthlySummaryAddedTotalRequest $request)
    {
        try {
            $added_total = [];

            $inputs =  $request->only([
                'remarks',
                'summary_date',
                'total_collected_amount',
                'sales_tax',
                'amount_for_commission'
            ]);

            $inputs['summary_date'] = date('Y-m-d',strtotime($inputs['summary_date']));

            MonthlySummaryUpdate::where('id','=',$request->id)->update($inputs);

            $summary = $request->get('summary');
            $added_total['added_total'] = [
                'updated_total_collected_amount' => ($summary['updated_total_collected_amount'] - $request->get('old_total_collected_amount')) + $inputs['total_collected_amount'],
                'updated_sales_tax'              => ($summary['updated_sales_tax'] - $request->get('old_sales_tax')) + $inputs['sales_tax'],
                'updated_amount_for_commission'  => ($summary['updated_amount_for_commission'] - $request->get('old_amount_for_commission')) + $inputs['amount_for_commission'],
            ];
            return response()->json(array_merge(['success'=> true],$added_total));
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete Monthly Summary Update
     * @param  MonthlySummaryAddedTotalRequest $request
     * @return json
     */
    public function deleteAddedTotal(MonthlySummaryAddedTotalRequest $request)
    {
        try {
            MonthlySummaryUpdate::where('id','=',$request->id)->delete();

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Add Monthly Summary Note
     * @param  MonthlySummaryNotesRequest $request
     * @return json
     */
    public function addedNotes(MonthlySummaryNotesRequest $request)
    {
        try {
            $inputs =  $request->only([
                'salesman_code',
                'notes',
                'summary_date'
            ]);

            $no_day_date = explode('/', $inputs['summary_date']);

            $inputs['summary_date'] = date('Y-m-d',strtotime($no_day_date[1] . '-' . $no_day_date[0] . '-01'));

            $added_total['data'] = MonthlySummaryNote::create($inputs);

            return response()->json(array_merge(['success'=> true],$added_total));
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete Monthly Summary Note
     * @param  MonthlySummaryNotesRequest $request
     * @return json
     */
    public function deleteAddedNotes(MonthlySummaryNotesRequest $request)
    {
        try {
            MonthlySummaryNote::where('id','=',$request->id)->delete();

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }
}