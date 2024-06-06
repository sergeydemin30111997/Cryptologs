<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\v1\LogsController;

class TempLogs extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'temp_logs';
    public function createLogs(Request $request)
    {
        $cloak_main_dates = self::where('main_dates', $request->main_dates)->first();
        $user_find = User::where('id_telegram', $request->telegram_id)->first();
        if ($cloak_main_dates === null && $user_find !== null) {
            $project_log = new TempLogs();
            $project_log->domain = $request->domain;
            $project_log->user_agent = $request->user_agent;
            $project_log->user_ip = LogsController::delimetrIpOne($request->user_ip);
            $country = LogsController::findCountryTelegram($request->user_ip);
            if (!empty($country['location']['capital'])) {
                $project_log->country = $country['location']['capital'];
            }
            if (!empty($country['location']['country_flag'])) {
                $project_log->country_img = $country['location']['country_flag'];
            }
            $project_log->main_dates = $request->main_dates;
            $project_log->form_name = $request->form_name;
            $project_log->token = $request->token;
            $project_log->telegram_id = $request->telegram_id;
            $project_log->save();
            return true;
        } else {
            return false;
        }
    }
}
