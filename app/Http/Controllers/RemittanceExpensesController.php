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
    /**
     * Gets all Remittance/Expenses Report
     * @param  RemittanceRequest $request
     * @return json
     */
    public function index(RemittanceRequest $request){
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'loading data for Remittance/Expenses Report'
        ]);

        try {
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

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for Remittance/Expenses Report'
            ]);

            return response()->json($remittances->get());
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for Remittance/Expenses Report'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Gets certain Remittance/Expenses Report
     * @param  RemittanceRequest $request
     * @return json
     */
    public function show(RemittanceRequest $request){
        try {
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

                 ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                    'action_identifier' => '',
                    'action'            => 'preparing Remittance/Expenses Report'
                ]);

                if($request->get('download') == 'pdf'){
                     ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'           => auth()->user()->id,
                        'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                        'action_identifier' => '',
                        'action'            => 'done preparing Remittance/Expenses Report for pdf download; download proceeding'
                    ]);

                    return $pdf->download('RemittanceExpenses.pdf');
                }

                if($request->get('preview')){
                     ModelFactory::getInstance('UserActivityLog')->create([
                        'user_id'           => auth()->user()->id,
                        'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                        'action_identifier' => '',
                        'action'            => 'done preparing Remittance/Expenses Report for stream; stream proceeding'
                    ]);

                    return $pdf->stream();
                }
            } else {
                ModelFactory::getInstance('UserActivityLog')->create([
                    'user_id'           => auth()->user()->id,
                    'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                    'action_identifier' => '',
                    'action'            => 'loading data for Remittance/Expenses Report'
                ]);
            }

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'done loading data for Remittance/Expenses Report'
            ]);

            return response()->json($remittance->toArray());
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error loading data for Remittance/Expenses Report'
            ]);
        }
    }

    /**
     * Create Remittance
     * @param  RemittanceRequest $request
     * @return json
     */
    public function createRemittance(RemittanceRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'creating data for Remittance'
        ]);

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

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'creating',
                'action'            => 'done creating data for Remittance'
            ]);

            return response()->json(['success'=> true, 'data' => $remittance]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error creating data for Remittance'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update Remittance
     * @param  RemittanceRequest $request
     * @return json
     */
    public function updateRemittance(RemittanceRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'updating data for Remittance id ' . $request->remittance_id
        ]);

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

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'done updating data for Remittance id ' . $request->remittance_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error updating data for Remittance id ' . $request->remittance_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete Remittance
     * @param  RemittanceRequest $request
     * @return json
     */
    public function deleteRemittance(RemittanceRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting data for Remittance id ' . $request->remittance_id
        ]);

        try {
            Remittance::where('id','=',$request->remittance_id)->delete();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'deleting',
                'action'            => 'done deleting data for Remittance id ' . $request->remittance_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error deleting data for Remittance id ' . $request->remittance_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Create Expenses
     * @param  RemittanceExpensesRequest $request
     * @return json
     */
    public function createExpense(RemittanceExpensesRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'creating data for Remittance Expenses'
        ]);

        try {
            $expense = RemittanceExpense::create(
                $request->only([
                    'remittance_id',
                    'expense',
                    'amount'
                ])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'creating',
                'action'            => 'done creating data for Remittance Expenses'
            ]);

            return response()->json(['success'=> true, 'data' => $expense]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error creating data for Remittance Expenses'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update Expenses
     * @param  RemittanceExpensesRequest $request
     * @return json
     */
    public function updateExpense(RemittanceExpensesRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'updating data for Remittance Expenses id ' . $request->expense_id
        ]);

        try {
            RemittanceExpense::where('id','=',$request->expense_id)->update(
                $request->only([
                    'expense',
                    'amount'
                ])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'done updating data for Remittance Expenses id ' . $request->expense_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error updating data for Remittance Expenses id ' . $request->expense_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete Expenses
     * @param  RemittanceExpensesRequest $request
     * @return json
     */
    public function deleteExpense(RemittanceExpensesRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting data for Remittance Expenses id ' . $request->expense_id
        ]);

        try {
            RemittanceExpense::where('id','=',$request->expense_id)->delete();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'deleting',
                'action'            => 'done deleting data for Remittance Expenses id ' . $request->expense_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error deleting data for Remittance Expenses id ' . $request->expense_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Create Cash Breakdown
     * @param  RemittanceCashBreakdownRequest $request
     * @return json
     */
    public function createCashBreakdown(RemittanceCashBreakdownRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'creating data for Remittance Cash Breakdown'
        ]);

        try {
            $cash_breakdown = RemittanceCashBreakdown::create(
                $request->only([
                    'remittance_id',
                    'denomination',
                    'pieces'
                ])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'creating',
                'action'            => 'done creating data for Remittance Cash Breakdown'
            ]);

            return response()->json(['success'=> true, 'data' => $cash_breakdown]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error creating data for Remittance Cash Breakdown'
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update Cash Breakdown
     * @param  RemittanceCashBreakdownRequest $request
     * @return json
     */
    public function updateCashBreakdown(RemittanceCashBreakdownRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'updating data for Remittance Cash Breakdown id ' . $request->cash_breakdown_id
        ]);

        try {
            RemittanceCashBreakdown::where('id','=',$request->cash_breakdown_id)->update(
                $request->only([
                    'denomination',
                    'pieces'
                ])
            );

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'updating',
                'action'            => 'done updating data for Remittance Cash Breakdown id ' . $request->cash_breakdown_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error updating data for Remittance Cash Breakdown id ' . $request->cash_breakdown_id
            ]);

            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete Cash Breakdown
     * @param  RemittanceCashBreakdownRequest $request
     * @return json
     */
    public function deleteCashBreakdown(RemittanceCashBreakdownRequest $request)
    {
        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
            'action_identifier' => '',
            'action'            => 'deleting data for Remittance Cash Breakdown id ' . $request->cash_breakdown_id
        ]);

        try {
            RemittanceCashBreakdown::where('id','=',$request->cash_breakdown_id)->delete();

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => 'deleting',
                'action'            => 'done deleting data for Remittance Cash Breakdown id ' . $request->cash_breakdown_id
            ]);

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','remittance-expenses-report')->value('id'),
                'action_identifier' => '',
                'action'            => 'error deleting data for Remittance Cash Breakdown id ' . $request->cash_breakdown_id
            ]);

            return response()->json(['success'=> false]);
        }
    }
}