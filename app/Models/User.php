<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    private $user;

    protected $casts = [
        'payment_desc' => 'array'
    ];
    /**
     * @return int
     */
    public function getLogs($telegram_id)
    {
        return ProjectLogs::where('telegram_id', $telegram_id)->get();
    }

    public function getPartner($profile_id)
    {
        $list = Referral::where('referral_id', $profile_id)->first();
        $partner_info = false;
        if ($list) {
            $partner_info = User::find($list->partner_id);
        }
        return $partner_info ? $partner_info : null;
    }

    public function isPartner($profile_id)
    {
        $user = self::where('id', $profile_id)->first();
        if ($user) {
            if ($user->hasPermissionTo('attracting_referrals')) {
                return $user->id;
            }
        }
        return false;
    }

    public function getReferral($profile_id)
    {
        $referral = Referral::where('referral_id', $profile_id)->first();
        $user_info = false;
        if ($referral) {
            if ($referral->partner_id == Auth::user()->id) {
                $user_info = User::where('id', $profile_id)->first();
            }
        }
        return $user_info ? $user_info : null;
    }
    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    public function AuthTelegram($auth_data) {
        $check_hash = $auth_data['hash'];
        unset($auth_data['hash']);
        $data_check_arr = [];
        foreach ($auth_data as $key => $value) {
            $data_check_arr[] = $key . '=' . $value;
        }
        sort($data_check_arr);
        $data_check_string = implode("\n", $data_check_arr);
        $secret_key = hash('sha256', config('app.token_bot_auth'), true);
        $hash = hash_hmac('sha256', $data_check_string, $secret_key);
        if (strcmp($hash, $check_hash) !== 0) {
            throw new Exception('Data is NOT from Telegram');
        }
        if ((time() - $auth_data['auth_date']) > 86400) {
            throw new Exception('Data is outdated');
        }
        if (empty($auth_data['hash'])) {
            return self::createOrUpdateUserTelegram($auth_data);
        }
        return false;
    }
    public function createOrUpdateUserTelegram($data_user) {
        $user = self::where('id_telegram', $data_user['id'])->first();
        $history_user = new HistoryUsers();
        if($user) {
            $user->first_name_telegram = $data_user['first_name'];
            $user->name_telegram = $data_user['username'];
            if(!empty($data_user['photo_url'])) {
                $user->photo_telegram = $data_user['photo_url'];
            }else{
                $user->photo_telegram = '/users_image/default.jpg';
            }
            $user->last_time_online = Carbon::now();
            $user->save();
            $history_user->telegram_id = $user->id_telegram;
            $history_user->key_translate_language = 'auth_user';
            $history_user->ip = self::getIp();
            $history_user->status_view = false;
            $history_user->save();
        }else {
            $user = new User();
            $user->id_telegram = $data_user['id'];
            $user->first_name_telegram = $data_user['first_name'];
            $user->name_telegram = $data_user['username'];
            if(!empty($data_user['photo_url'])) {
                $user->photo_telegram = $data_user['photo_url'];
            }else{
                $user->photo_telegram = '/users_image/default.jpg';
            }
            $user->last_time_online = Carbon::now();
            $user->save();
            //Role::create(['name' => 'User']);
            //Role::create(['name' => 'Manager']);
            $user->assignRole('User');
            $history_user->telegram_id = $user->id_telegram;
            $history_user->key_translate_language = 'auth_user';
            $history_user->ip = self::getIp();
            $history_user->status_view = false;
            $history_user->save();
            $partner_id = Referral::getCookie();
            $partner_id = $this->isPartner($partner_id);
            if($partner_id) {
                $referral = new Referral();
                $referral->partner_id = $partner_id;
                $referral->referral_id = $user->id;
                $referral->save();
            }

        }
        Auth::login($user, true);
        return true;
    }
    public static function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
    }
    public static function createUpdatePaymentDesc(Request $request, $user_id) {
        $payment_desc_wallet = self::find($user_id);
        $isFullNullWallet = true;
        $wallet_array = $request->payment_desc;
        foreach ($wallet_array as $wallet => $address) {
            if ($address == null) {
                unset($wallet_array[$wallet]);
            }else {
                $isFullNullWallet = false;
            }
        }
        if ($isFullNullWallet == false) {
            $payment_desc_wallet->payment_desc = $wallet_array;
        }else {
            $payment_desc_wallet->payment_desc = null;
        }
        $payment_desc_wallet->save();
        return true;
    }

}
