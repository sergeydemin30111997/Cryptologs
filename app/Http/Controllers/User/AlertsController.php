<?php

namespace App\Http\Controllers\User;

use App\Models\AlertsUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class AlertsController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userList = User::all();
        $alert_list = AlertsUsers::where('telegram_id', $this->user->id_telegram)->orderBy('id', 'desc')->paginate(10)->onEachSide(1);
        foreach ($alert_list as $alert) {
            $alert->status_view = true;
            $alert->save();
        }
        return view('alerts_user.index', compact('userList', 'alert_list'));
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
        if ($request->message && ($request->usersAlert || $request->alertAllUsers)) {
            if ($request->alertAllUsers == true) {
                $users_data = User::all();
                foreach ($users_data as $user) {
                    AlertsUsers::create([
                        'telegram_id' => $user->id_telegram,
                        'message' => $request->message,
                    ]);
                }
            } else {
                foreach ($request->usersAlert as $item) {
                    $user_data = User::find($item);
                    AlertsUsers::create([
                        'telegram_id' => $user_data->id_telegram,
                        'message' => $request->message,
                    ]);
                }
            }
            return back()->with('message', Lang::get('alert_users.message_all_send_top'));
        }
        return back()->with('message', Lang::get('alert_users.error_message_send_form'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        AlertsUsers::where('telegram_id', $this->user->id_telegram)->delete();
        return back()->with('message', Lang::get('alert_users.message_all_destroy'));
    }
}
