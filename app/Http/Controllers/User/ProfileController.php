<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\AbstractController;
use App\Models\HistoryUsers;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends AbstractController
{
    public function profileUser()
    {

        $data_user = $this->user;
        $history_payments = PaymentRequest::where('telegram_id', $data_user->id_telegram)->orderBy('id', 'desc')->take(5)->get();
        $history_user = HistoryUsers::where('telegram_id', $data_user->id_telegram)->orderBy('id', 'desc')->take(5)->get();

        return view('user.profile', compact('data_user', 'history_payments', 'history_user'));
    }

    public function historyUser()
    {

        $data_user = $this->user;
        $history_user = HistoryUsers::where('telegram_id', $data_user->id_telegram)->orderBy('id', 'desc')->paginate(10)->onEachSide(1);
        foreach ($history_user as $history) {
            $history->status_view = true;
            $history->save();
        }
        return view('history_users.index', compact('history_user'));
    }

    public function profilePaymentRequest()
    {
        $data_user = $this->user;

        return view('user.profile', compact('data_user'));
    }

}
