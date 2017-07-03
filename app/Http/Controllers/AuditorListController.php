<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Http\Models\AuditorList;
use App\Http\Models\User;
use App\Http\Models\AppSalesman;
use App\Http\Models\AppArea;
use App\Http\Requests\AuditorListRequest;
use DB;
use Excel;
use PDF;

class AuditorListController extends ControllerCore
{
    public function filterAuditorsList($request,$show_filter = false)
    {
        $filter = [];
        $auditorLists = AuditorList::with('user','salesman','area');

        if($request->has('auditor_id')){
            $auditor_id = $request->get('auditor_id');
            $auditorLists = $auditorLists->where('auditor_id','=',$auditor_id);

            if($show_filter){
                $user = User::where('id','=',$auditor_id)->first();
                $filter['auditor'] = $user->firstname . ' ' . $user->lastname;
            }
        }

        if($request->has('salesman_code')){
            $salesman_code = $request->get('salesman_code');
            $auditorLists = $auditorLists->where('salesman_code','=',$salesman_code);

            if($show_filter){
                $salesman = AppSalesman::where('salesman_code','=',$salesman_code)->first();
                $filter['salesman'] = $salesman->salesman_name;
            }
        }

        if($request->has('area_code')){
            $area_code = $request->get('area_code');
            $auditorLists = $auditorLists->where('area_code','=',$area_code);

            if($show_filter){
                $area = AppArea::where('area_code','=',$area_code)->first();
                $filter['area'] = $area->area_name;
            }
        }

        if($request->has('type')){
            $type = $request->get('type');
            $auditorLists = $auditorLists->where('type','=',$type);

            if($show_filter){
                $filter['type'] = $type;
            }
        }

        if($request->has('period_from') && !$request->has('period_to')){
            $period_from = date('Y-m-d',strtotime($request->get('period_from')));

            $auditorLists = $auditorLists->where(function($query) use ($period_from) {
                                $query->where('period_from','<=',$period_from)
                                      ->orWhere('period_to','>=',$period_from);
                            });

            if($show_filter){
                $filter['period_covered'] = date('F d,Y',strtotime($period_from));
            }
        }

        if($request->has('period_from') && $request->has('period_to')){
            $period_from = date('Y-m-d',strtotime($request->get('period_from')));
            $period_to = date('Y-m-d',strtotime($request->get('period_to')));

            $auditorLists = $auditorLists
                                ->whereBetween('period_from',[$period_from,$period_to])
                                ->orWhere(function ($query) use ($period_from,$period_to){
                                    $query->whereBetween('period_to',[$period_from,$period_to]);
                                });

            if($show_filter){
                $filter['period_covered'] = date('F d,Y',strtotime($period_from)) . ' - ' . date('F d,Y',strtotime($period_to));
            }
        }

        if(!$show_filter && $request->has('order_by')){
            $auditorLists = $auditorLists->orderBy($request->get('order_by'), $request->get('order'));
        }

        return array_merge(
            ['records' => (!empty($auditorLists->get()) ? $auditorLists->get()->toArray() : [])],
            ['filters' => $filter]
        );
    }

    /**
     * Gets all Auditor List
     * @param  AuditorListRequest $request
     * @return json
     */
    public function index(AuditorListRequest $request)
    {
        $auditorLists = $this->filterAuditorsList($request, ($request->has('download_type') ?  true : false));

        if($request->has('download_type')){
            $auditorLists['download_type'] = $request->get('download_type');

            if($auditorLists['download_type'] == 'xlsx'){
                Excel::create('AuditorsList', function($excel) use ($auditorLists){
                    $excel->sheet('Sheet1', function($sheet) use ($auditorLists){
                        $sheet->loadView('VanInventory.exportAuditorsList',$auditorLists);
                    });
                })->download($auditorLists['download_type']);
            }

            if($auditorLists['download_type'] == 'pdf'){
                $pdf = PDF::loadView('VanInventory.exportAuditorsList', $auditorLists)->setPaper('legal', 'landscape');
                return $pdf->download('AuditorsList.pdf');
            }
        }

        return response()->json($auditorLists['records']);
    }

    /**
     * Get a certain Auditor List
     * @param  [integer] $id
     * @return json
     */
    public function show($id)
    {
        $auditorList = AuditorList::with('user','salesman','area')->where('id','=',$id)->first();
        return response()->json($auditorList);
    }

    /**
     * Create an Auditor List
     * @param  AuditorListRequest $request
     * @return json
     */
    public function store(AuditorListRequest $request)
    {
        try {
            $list = AuditorList::create(
                $request->only([
                    'auditor_id',
                    'salesman_code',
                    'area_code',
                    'type',
                    'period_from',
                    'period_to',
                ])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Update an Auditor List
     * @param  AuditorListRequest $request
     * @param  [integer] $id
     * @return json
     */
    public function update(AuditorListRequest $request,$id)
    {
        try {
            AuditorList::where('id','=',$id)->update(
                $request->only([
                    'auditor_id',
                    'salesman_code',
                    'area_code',
                    'type',
                    'period_from',
                    'period_to',
                ])
            );

            return response()->json(['success'=> true]);
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }

    /**
     * Delete an Auditor List
     * @param  [integer] $id
     * @return json
     */
    public function destroy($id)
    {
        try {
            if(AuditorList::where('id','=',$id)->delete()){
                return response()->json(['success'=> true]);
            }
        } catch (Exception $e) {
            return response()->json(['success'=> false]);
        }
    }
}