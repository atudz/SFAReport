<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use App\Http\Requests\RemittanceRequest;
use App\Http\Requests\RemittanceExpensesRequest;
use App\Http\Requests\RemittanceCashBreakdownRequest;
use App\Http\Models\Remittance;
use App\Http\Models\RemittanceExpense;
use App\Http\Models\RemittanceCashBreakdown;
use PDF;

class RemittanceExpensesController extends ControllerCore
{
    public function index(RemittanceRequest $request){
        $remittances = Remittance::with('sr_salesman','jr_salesman');

        if($request->has('sr_salesman_code')){
            $remittances = $remittances->where('sr_salesman_code','=',$request->get('sr_salesman_code'));
        }

        if($request->has('jr_salesman_code')){
            $remittances = $remittances->where('jr_salesman_code','=',$request->get('jr_salesman_code'));
        }

        if($request->has('date_from') && !$request->has('date_to')){
            $date_from = date('Y-m-d',strtotime($request->get('date_from')));

            $remittances = $remittances->where(function($query) use ($date_from) {
                                $query->where('date_from','<=',$date_from)
                                      ->orWhere('date_to','>=',$date_from);
                            });
        }

        if($request->has('date_from') && $request->has('date_to')){
            $date_from = date('Y-m-d',strtotime($request->get('date_from')));
            $date_to = date('Y-m-d',strtotime($request->get('date_to')));

            $remittances = $remittances
                                ->where('date_from','=',$date_from)
                                ->where('date_to','=',$date_to);
        }

        return response()->json($remittances->get());
    }

    public function show(RemittanceRequest $request){
        $remittance = Remittance::with('sr_salesman','jr_salesman','expenses','cash_breakdown')->where('id','=',$request->remittance_id)->first();

        if($request->has('download') || ($request->has('preview') && $request->get('preview'))){

            foreach ($remittance->expenses as $expense) {
                $remittance->total_expenses += $expense->amount;
            }

            foreach ($remittance->cash_breakdown as $cash_breakdown) {
                $remittance->total_cash_breakdowns += ($cash_breakdown->denomination * $cash_breakdown->pieces);
            }

            $pdf =  PDF::loadView(
                        'RemittanceExpenses.exportRemittanceExpenses',
                        ['record' => $remittance]
                    )->setPaper('legal', 'portrait');
            if($request->get('download') == 'pdf'){
                return $pdf->download('RemittanceExpenses.pdf');
            }

            if($request->get('preview')){
                return $pdf->stream();
            }
        }
        return response()->json($remittance->toArray());
    }

    public function createRemittance(RemittanceRequest $request)
    {
        try {
            $remittance = Remittance::create(
                $request->only([
                    'sr_salesman_code',
                    'jr_salesman_code',
                    'date_from',
                    'date_to',
                    'cash_amount',
                    'check_amount'
                ])
            );

            return response()->json(['success'=> true, 'data' => $remittance]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function updateRemittance(RemittanceRequest $request)
    {
        try {
            $inputs = $request->only([
                'sr_salesman_code',
                'jr_salesman_code',
                'date_from',
                'date_to',
                'cash_amount',
                'check_amount'
            ]);
            $inputs['date_from'] = date('Y-m-d',strtotime($inputs['date_from']));
            $inputs['date_to'] = date('Y-m-d',strtotime($inputs['date_to']));

            Remittance::where('id','=',$request->remittance_id)->update($inputs);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function deleteRemittance(RemittanceRequest $request)
    {
        try {
            Remittance::where('id','=',$request->remittance_id)->delete();

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function createExpense(RemittanceExpensesRequest $request)
    {
        try {
            $expense = RemittanceExpense::create(
                $request->only([
                    'remittance_id',
                    'expense',
                    'amount'
                ])
            );

            return response()->json(['success'=> true, 'data' => $expense]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function updateExpense(RemittanceExpensesRequest $request)
    {
        try {
            RemittanceExpense::where('id','=',$request->expense_id)->update(
                $request->only([
                    'expense',
                    'amount'
                ])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function deleteExpense(RemittanceExpensesRequest $request)
    {
        try {
            RemittanceExpense::where('id','=',$request->expense_id)->delete();

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function createCashBreakdown(RemittanceCashBreakdownRequest $request)
    {
        try {
            $cash_breakdown = RemittanceCashBreakdown::create(
                $request->only([
                    'remittance_id',
                    'denomination',
                    'pieces'
                ])
            );

            return response()->json(['success'=> true, 'data' => $cash_breakdown]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function updateCashBreakdown(RemittanceCashBreakdownRequest $request)
    {
        try {
            RemittanceCashBreakdown::where('id','=',$request->cash_breakdown_id)->update(
                $request->only([
                    'denomination',
                    'pieces'
                ])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    public function deleteCashBreakdown(RemittanceCashBreakdownRequest $request)
    {
        try {
            RemittanceCashBreakdown::where('id','=',$request->cash_breakdown_id)->delete();

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }
}