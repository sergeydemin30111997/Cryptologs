<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\TempLogs;
use Illuminate\Http\Request;
use App\Models\ProjectLogs;

class LogsController extends AbstractController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $statusIdCreate = false;
        
        if($logs_result = self::checkApiLogs($request)) {
            if($logs_ip_result = self::checkIpLogs($request)) {
                $project_logs = new ProjectLogs();
                $statusIdCreate = $project_logs->createLogs($request);
                $temp_logs = new TempLogs();
                $statusIdCreateTemp = $temp_logs->createLogs($request);
                if ($statusIdCreate) {
//                    $statuCreateAndSend = self::sendMainTelegram($statusIdCreate);
//                    $statuCreateAndSend = self::sendSpammerTelegram($statusIdCreate);
               }
            }
        }
        return [
            'result' => $statusIdCreate ? $statusIdCreate : false,
        ];
    }

}
