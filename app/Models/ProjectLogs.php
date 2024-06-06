<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\Api\v1\LogsController;

class ProjectLogs extends Model
{
    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'project_logs';

    /**
     * @return int
     */
    public function getLogsIpCount($ip)
    {
        return self::where('user_ip', $ip)->get();
    }

    public function getUserLog($telegram_id)
    {
        return User::where('id_telegram', $telegram_id)->first();
    }

    public static function statisticLogs($id_telegram, $number = 7, $item = 'Days', $format = 'j', $gap = 1, $all = false)
    {
        --$number;
        $stats_days = [];
        $firstKey = Carbon::now()->sub($number, $item);
        $lastKey = Carbon::now();
        for ($firstKey; $firstKey < $lastKey;) {
            $stats_days[$firstKey->format($format)] = 0;
            $firstKey = $firstKey->add($gap, $item);
        }
        if ($all) {
            $stats = ProjectLogs::orderBy('created_at', 'DESC')->get();
        }else {
            $stats = ProjectLogs::where('telegram_id', $id_telegram)->orderBy('created_at', 'DESC')->get();
        }
        if ($stats) {
            foreach ($stats as $statistic_day) {
                if ($number > 0) {
                    $format_diff = 'diffIn'.$item;
                    $differense = $statistic_day->created_at->$format_diff(Carbon::now());
                    if ($differense < $number) {
                        if (!isset($stats_days[$statistic_day->created_at->format($format)])) {
                            $stats_days[$statistic_day->created_at->format($format)] = 0;
                        }
                        ++$stats_days[$statistic_day->created_at->format($format)];
                    }
                }
            }
        }
        return $stats_days;
    }

    public static function statisticCountryLogs($id_telegram, $number = 5, $item = 'days', $format = 'j', $gap = 1, $limit = 5, $all = false)
    {
        --$number;
        $stats_country = [];
        if ($all) {
            $stats = ProjectLogs::orderBy('created_at', 'DESC')->get();
        }else {
            $stats = ProjectLogs::where('telegram_id', $id_telegram)->orderBy('created_at', 'DESC')->get();
        }
        if ($stats) {
            foreach ($stats as $statistic_country) {
                if ($number > 0) {
                    if ($statistic_country->created_at->diff(Carbon::now())->format('%'.$format) <= $number) {
                        if ($statistic_country->country) {
                            if (!isset($stats_country[$statistic_country->country])) {
                                $stats_country[$statistic_country->country] = 0;
                            }
                            ++$stats_country[$statistic_country->country];
                        }
                    }
                }
            }
            asort($stats_country);
            if (count($stats_country) > $limit) {
                $stats_country = array_slice($stats_country, self::minusInt($limit));
            }
        }
        return $stats_country;
    }

    public static function minusInt($num)
    {
        return $num < 0 ? $num : -1*$num;
    }

    public function createLogs(Request $request)
    {
        $cloak_main_dates = self::where('main_dates', $request->main_dates)->first();
        $user_find = User::where('id_telegram', $request->telegram_id)->first();
        if ($cloak_main_dates === null && $user_find !== null) {
            $project_log = new ProjectLogs();
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
            $project_log->main_dates = LogsController::hideText($request->main_dates);
            $project_log->form_name = $request->form_name;
            $project_log->token = $request->token;
            $project_log->telegram_id = $request->telegram_id;
            $project_log->save();
            return $project_log->id;
        } else {
            return false;
        }
    }
}
