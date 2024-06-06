<?php

namespace App\Http\Controllers;

use App\Models\AlertsUsers;
use App\Models\HistoryUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;

abstract class AbstractController extends Controller
{
    /**
     * All of the current user's projects.
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            if ($this->user) {
                $this->user->last_time_online = Carbon::now();
                $this->user->save();
                View::share('profile', $this->user);
                $count_no_view_alerts = AlertsUsers::where(['telegram_id' => $this->user->id_telegram, 'status_view' => false])->count();
                View::share('count_no_view_alerts', $count_no_view_alerts);
                $count_no_view_history_users = HistoryUsers::where(['telegram_id' => $this->user->id_telegram, 'status_view' => false])->count();
                View::share('count_no_view_history_users', $count_no_view_history_users);
                $count_confirm_users = User::where('confirm_status', null)->count();
                View::share('count_confirm_users', $count_confirm_users);
            }
            return $next($request);
        });
    }
}
