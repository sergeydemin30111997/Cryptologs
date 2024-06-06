<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\HistoryUsers;
use App\Models\Referral;
use App\Models\SettingsSite;
use App\Models\TempLogs;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProjectLogs;
use App\Models\Charges;


class UserController extends AbstractController
{
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
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
        if (!isset($request->id_telegram)) {
            $data_request['message'] = 'id telegram not found or not sent';
            return $data_request;
        }
        if (!isset($request->sum_up)) {
            $data_request['message'] = 'sum up not found or not sent';
            return $data_request;
        }
        if (!is_numeric($request->sum_up)) {
            $data_request['message'] = 'variables have a non-numeric data type';
            return $data_request;
        }
        $user_data = User::where('id_telegram', $request->id_telegram)->first();
        if ($user_data == null) {
            $data_request['message'] = 'I can\'t find a user with such a telegram';
            return $data_request;
        }
        $is_partner = $this->user->getPartner($user_data->id);
        $history_user = new HistoryUsers();
        $charges_user = new Charges();
        $incineration = SettingsSite::where('item_key', 'balance_burn_percentage')->first()->value;
        $incineration_sum = $request->sum_up * ($incineration / 100);
        $request->sum_up = $request->sum_up - $incineration_sum;
        if($is_partner) {
            $referral = Referral::where('referral_id', $user_data->id)->first();
            $user_data_partner = User::find($referral->partner_id);
            $charges_user_partner = new Charges();
            $sum_partner = $request->sum_up * ($referral->benefit / 100);
            $sum_referral = $request->sum_up-$sum_partner;
            //$user_data->balance += $sum_referral;
            //$referral->sum_balance += $sum_partner;
            //$user_data_partner->balance += $sum_partner;
            $charges_user_partner->user_id = $user_data_partner->id;
            $charges_user_partner->log_id = $request->sync_id;
            $charges_user_partner->sum = $sum_partner;
            $charges_user->user_id = $user_data->id;
            $charges_user->log_id = $request->sync_id;
            $charges_user->sum = $sum_referral;
            $referral->save();
            $user_data->save();
            $user_data_partner->save();
            $charges_user_partner->save();
            $charges_user->save();
            $history_user->number = $sum_referral;
        }else {
            //$user_data->balance = $user_data->balance + $request->sum_up;
            //$user_data->save();
            $charges_user->user_id = $user_data->id;
            $charges_user->log_id = $request->sync_id;
            $charges_user->sum = $request->sum_up;
            $charges_user->save();
            $history_user->number = $request->sum_up;
        }
        $history_user->telegram_id = $user_data->id_telegram;
        $history_user->key_translate_language = 'sum_balance';
        $history_user->status_view = false;
        $history_user->save();
        $data_request['result'] = true;
        return $data_request;
    }

}
