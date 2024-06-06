<?php

namespace App\Http\Controllers\User;

use App\Models\HistoryUsers;
use App\Models\PaymentRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Spatie\Permission\Models\Role;

class UserController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userList = User::paginate(20)->onEachSide(1);
        return view('user.list', compact('userList'));
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
        if ($this->user->can('view_users')) {
            $data_user = User::findOrFail($id);

            $history_payments = PaymentRequest::where('telegram_id', $data_user->id_telegram)->orderBy('id', 'desc')->take(5)->get();
            $all_roles_in_database = Role::all()->pluck('name');
            $role_user = $data_user->getRoleNames();
            $history_user = HistoryUsers::where('telegram_id', $data_user->id_telegram)->orderBy('id', 'desc')->take(5)->get();
            return view('user.profile', compact('data_user', 'history_payments', 'all_roles_in_database', 'role_user', 'history_user'));
        } else {
            return redirect(route('dashboard'));
        }
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
        $user_update = User::findOrFail($id);
        $history_user = new HistoryUsers();
        if ($id && !empty($request->payment_desc)) {
            if (($this->user->can('verify_confirm_users') || ($this->user->id == $id && $user_update->payment_desc == null))) {
                $status_payment_desc = User::createUpdatePaymentDesc($request, $id);
                if ($status_payment_desc) {
                    $history_user->telegram_id = $user_update->id_telegram;
                    $history_user->status_view = false;
                    $history_user->key_translate_language = 'edit_wallets';
                    $history_user->save();
                    return back()->with('message', Lang::get('history_users.edit_wallets'));
                }
            }
            return back()->with('message', Lang::get('history_users.error_edit_wallets'));
        } elseif ($id && $request->role && $this->user->can('verify_confirm_users')) {
            $statusReplaceRole = $user_update->syncRoles([$request->role]);
            if ($statusReplaceRole) {
                $history_user->telegram_id = $user_update->id_telegram;
                $history_user->name_role = $request->role;
                $history_user->key_translate_language = 'edit_users_role';
                $history_user->status_view = false;
                $history_user->save();
                return back()->with('message', Lang::get('history_users.edit_users_role', ['namerole' => $request->role]));
            } else {
                return back()->with('message', Lang::get('history_users.error_edit_users_role'));
            }
        } elseif ($id && isset($request->banned) && $this->user->can('verify_confirm_users')) {
            $user_update->banned = $request->banned;
            $user_update->save();
            if ($user_update->banned == 1) {
                $history_user->telegram_id = $user_update->id_telegram;
                $history_user->key_translate_language = 'ban_user';
                $history_user->status_view = false;
                $history_user->save();
                return back()->with('message', Lang::get('history_users.ban_user'));
            } else {
                $history_user->telegram_id = $user_update->id_telegram;
                $history_user->key_translate_language = 'unban_user';
                $history_user->status_view = false;
                $history_user->save();
                return back()->with('message', Lang::get('history_users.unban_user'));
            }
        } elseif ($id && $request->balance_replace !== null && $this->user->can('verify_confirm_users')) {
            if ($request->message) {
                $message = $request->message;
            }else {
                $message = '';
            }
            $user_update->balance = $request->balance_replace;
            $user_update->save();
            $history_user->telegram_id = $user_update->id_telegram;
            $history_user->key_translate_language = 'replace_balance';
            $history_user->number = $request->balance_replace;
            $history_user->message = $message;
            $history_user->status_view = false;
            $history_user->save();
            return back()->with('message', Lang::get('history_users.replace_balance', ['number' => $request->balance_replace]));
        } elseif ($id && $request->balance_sum && $this->user->can('verify_confirm_users')) {
            if ($request->message) {
                $message = $request->message;
            }else {
                $message = '';
            }
            $user_update->balance = $user_update->balance+$request->balance_sum;
            $user_update->save();
            $history_user->telegram_id = $user_update->id_telegram;
            $history_user->key_translate_language = 'sum_balance';
            $history_user->number = $request->balance_sum;
            $history_user->message = $message;
            $history_user->status_view = false;
            $history_user->save();
            return back()->with('message', Lang::get('history_users.sum_balance', ['number' => $request->balance_replace]));
        }  else {
            return back()->with('message', Lang::get('history_users.error_edit_form_payments'));
        }
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
