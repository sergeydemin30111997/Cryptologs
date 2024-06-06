<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AbstractController;
use App\Models\HistoryUsers;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class PaymentsRequestController extends AbstractController
{
    use SoftDeletes;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->user->can('verify_confirm_users')) {
            $payment_request = PaymentRequest::orderBy('id', 'desc')->paginate(10)->onEachSide(1);
        }else {
            $payment_request = PaymentRequest::where('telegram_id', $this->user->id_telegram)->orderBy('id', 'desc')->paginate(10)->onEachSide(1);
        }
            if ($payment_request) {
                $data_users = User::all();
                if ($data_users) {
                    return view('payments_request.index', compact('payment_request', 'data_users'));
                }
            }
        return back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($this->user->balance >= $request->balance_request && $request->balance_request > 0 && !empty($request->wallet_name)) {
            $payments_request = new PaymentRequest();
            $payments_request->telegram_id = $this->user->id_telegram;
            $payments_request->sum = $request->balance_request;
            $payments_request->wallet_name = $request->wallet_name;
            $payments_request->status_payment = 'pending';
            $this->user->balance -= $request->balance_request;
            $this->user->save();
            $payments_request->save();
            $history_user = new HistoryUsers();
            $history_user->telegram_id = $this->user->id_telegram;
            $history_user->key_translate_language = 'payment_request';
            $history_user->number = $request->balance_request;
            $history_user->wallet_name = $request->wallet_name;
            $history_user->status_view = false;
            $history_user->save();
            return back()->with('message', Lang::get('history_users.payment_request', ['number' => $request->balance_request, 'walletname' => $request->wallet_name]));
        }
        return back()->with('message', Lang::get('history_users.error_payment_request'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($id) {
            if (!$request->comment) {
                $request->comment = null;
            }
            PaymentRequest::where('id', $id)->update(['status_payment' => 'payout', 'comment' => $request->comment]);
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if ($id) {
            $payments_request = PaymentRequest::findOrFail($id);
            if ($payments_request->status_payment == 'pending' && $this->user->can('payment_request')) {
                $user_data = User::where('id_telegram', $payments_request->telegram_id)->first();
                if ($request->return) {
                    $user_data->balance = $user_data->balance + $payments_request->sum;
                    $user_data->save();
                    $payments_request->status_payment = 'canceled';
                }else {
                    $payments_request->status_payment = 'canceled_no_refund';
                }
                $payments_request->save();
            }
        }
        return back();
    }
}
