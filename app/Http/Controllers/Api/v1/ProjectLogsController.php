<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProjectLogs;


class ProjectLogsController extends AbstractController
{

    public function index(Request $request)
    {
        $data_request = [
            'result' => false,
        ];

        if (!isset($request->api_key)) {
            $data_request['message'] = 'api key not found or not sent';
            return $data_request;
        }
        $this->user = User::where('api', $request->api_key)->first();
        if ($this->user == null) {
            $data_request['message'] = 'Can\'t find the user for the given api key';
            return $data_request;
        }
        if (!$this->user->can('verify_confirm_users')) {
            $data_request['message'] = 'there are no rights to this action';
            return $data_request;
        }
        if (!isset($request->sync_id)) {
            $data_request['message'] = 'sync_id not found or not sent';
            return $data_request;
        }
        $project_log_data = ProjectLogs::where('id', $request->sync_id)->first();
        if ($project_log_data == null) {
            $data_request['message'] = 'I can\'t find a project_log with sync_id';
            return $data_request;
        }
        $data_request['data'] = $project_log_data;
        $data_request['result'] = true;
        return $data_request;
    }

}
