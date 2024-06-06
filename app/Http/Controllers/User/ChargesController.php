<?php

namespace App\Http\Controllers\User;

use App\Models\Charges;
use App\Models\HistoryUsers;
use App\Models\ProjectLogs;
use App\Models\User;
use Illuminate\Http\Request;

class ChargesController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id = false)
    {
        if ($user_id == 'all' && $this->user->can('view_all_logs')){
            $chargesList = Charges::orderBy('id', 'desc')->paginate(10)->onEachSide(1);
        }elseif($user_id && $this->user->can('view_all_logs')) {
            $chargesList = Charges::where('user_id', $user_id)->orderBy('id', 'desc')->paginate(10)->onEachSide(1);
        }else{
            $chargesList = Charges::where('user_id', $this->user->id)->orderBy('id', 'desc')->paginate(10)->onEachSide(1);
        }
        $projectLogUser = [];
        foreach ($chargesList as $chargesItem) {
            if (ProjectLogs::find($chargesItem->log_id)) {
                $projectLogUser[] = ProjectLogs::find($chargesItem->log_id);
            }
        }
        return view('user.charges', compact('chargesList', 'projectLogUser'));
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
        //
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
        $changesItem = Charges::find($id);
        $changesList = Charges::where('log_id', $changesItem->log_id)->get();
        //dd($request->confirm);
        if ($this->user->can('view_all_logs')) {
            if ($request->confirm) {
                foreach ($changesList as $changes) {
                    if (!isset($changes->confirm)) {
                        $user_data = User::find($changes->user_id);
                        $user_data->balance += $changes->sum;
                        $changes->confirm = true;
                        $user_data->save();
                        $changes->save();
                        $history_user = new HistoryUsers();
                        $history_user->number = $changesItem->sum;
                        $history_user->telegram_id = $user_data->id_telegram;
                        $history_user->key_translate_language = 'sum_balance';
                        $history_user->status_view = false;
                        $history_user->save();
                    }
                }
                //$user_data->balance += $sum_referral;
                //$referral->sum_balance += $sum_partner;
                //$user_data_partner->balance += $sum_partner;
            } elseif (!$request->confirm) {
                foreach ($changesList as $changes) {
                    if (!isset($changes->confirm)) {
                        $changes->confirm = false;
                        $changes->save();
                    }
                }
            }
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
