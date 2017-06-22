<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use Illuminate\Http\Request;
use PDF;

class UserActivityLogController extends ControllerCore
{
    protected $log;

    public function __construct(){
        $this->log = ModelFactory::getInstance('UserActivityLog');
    }

    /**
     * Load User Logs
     * @param  Request $request
     * @return pdf/json
     */
    public function loadLogs(Request $request){
        $user_id = $request->has('user_id') ? $request->get('user_id') : auth()->user()->id;

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-activity-log')->value('id'),
            'action_identifier' => '',
            'action'            => 'preparing data logs for User Management - User Activity Log id ' . $user_id
        ]);

        $logs = $this->log->with('user','user.area','user.group','navigation')->where('user_id','=',$user_id);

        if($request->has('navigation_id')){
            $logs = $logs->where('navigation_id','=',$request->get('navigation_id'));
        }

        if($request->has('log_date_from') && !$request->has('log_date_to')){
            $date_from = date('Y-m-d H:i:s',strtotime($request->get('log_date_from') . ' 00:00:00'));
            $date_to = date('Y-m-d H:i:s',strtotime($request->get('log_date_from') . ' 23:59:59'));
            $logs = $logs->whereBetween('created_at',[$date_from,$date_to]);
        }

        if($request->has('log_date_from') && $request->has('log_date_to')){
            $date_from = date('Y-m-d H:i:s',strtotime($request->get('log_date_from') . ' 00:00:00'));
            $date_to = date('Y-m-d H:i:s',strtotime($request->get('log_date_to') . ' 23:59:59'));
            $logs = $logs->whereBetween('created_at',[$date_from,$date_to]);
        }

        $data = [
            'records' => $logs->get()
        ];

        if($request->has('download') && $request->get('download') == 'pdf'){
            $pdf = PDF::loadView('UserActivityLog.print', $data)->setPaper('legal','portrait');

            ModelFactory::getInstance('UserActivityLog')->create([
                'user_id'           => auth()->user()->id,
                'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-activity-log')->value('id'),
                'action_identifier' => 'downloading',
                'action'            => 'done preparing data logs for User Management - User Activity Log id ' . $user_id . ' download proceeding'
            ]);

            return $pdf->download('User Activity Logs.pdf');
        }

        ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'           => auth()->user()->id,
            'navigation_id'     => ModelFactory::getInstance('Navigation')->where('slug','=','user-activity-log')->value('id'),
            'action_identifier' => '',
            'action'            => 'done preparing data logs for User Management - User Activity Log id ' . $user_id
        ]);

        return response()->json($data);
    }
}