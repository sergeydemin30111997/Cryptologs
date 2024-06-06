<?php

namespace App\Http\Controllers\AuthTelegram;

use App\Http\Controllers\Api\v1\AbstractController as LogsFunction;
use App\Models\ProjectLogs;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LoginController extends AbstractController
{
    public function loginTelegram(Request $request)
    {

        if (!empty($request->all())) {
            $user_data = new User();
            $statusAuth = $user_data->AuthTelegram($request->all());
            if (empty($statusAuth['hash'])) {
                return redirect('dashboard');
            }
        }
        return redirect(route('main'));

    }

    public function test1($all = false)
    {
        // $role1 = Role::create(['name' => 'Partner']);
    //   $permission = Permission::create(['name' => 'attracting_referrals']);
        // $role1->givePermissionTo($permission);
        // $role = Role::findByName('Administrator');
//        $permission = Permission::create(['name' => 'view_all_logs']);
        // $role->givePermissionTo($permission);
        // dd(1);
//        //$this->user->assignRole('Administrator');
        if ($all == 'all' && $this->user->can('view_users')) {
            $statsLogDays = ProjectLogs::statisticLogs($this->user->id_telegram, 10, 'Days', 'j', 1, $all);
            $statsLogMonth = ProjectLogs::statisticLogs($this->user->id_telegram, 6, 'Months', 'M', 1, $all);
            $statsLogCountry = ProjectLogs::statisticCountryLogs($this->user->id_telegram, $number = 24, $item = 'hours', $format = 'j', $gap = 1, $limit = 5, $all);
            $projectLogUser = ProjectLogs::orderBy('id', 'desc')->take(5)->get();
            $projectLogCountUser = ProjectLogs::count();

        } else {
            $statsLogDays = ProjectLogs::statisticLogs($this->user->id_telegram, 10, 'Days', 'j', 1);
            $statsLogMonth = ProjectLogs::statisticLogs($this->user->id_telegram, 6, 'Months', 'M', 1);
            $statsLogCountry = ProjectLogs::statisticCountryLogs($this->user->id_telegram, $number = 24, $item = 'hours', $format = 'j', $gap = 1, $limit = 5);
            $projectLogUser = ProjectLogs::where('telegram_id', $this->user->id_telegram)->orderBy('id', 'desc')->take(5)->get();
            $projectLogCountUser = ProjectLogs::where('telegram_id', $this->user->id_telegram)->count();
        }
        $daysHeight = 0;
        if ($statsLogDays) {
            foreach ($statsLogDays as $itemStats) {
                if ($itemStats > $daysHeight) {
                    $daysHeight = $itemStats;
                }
            }
        }
        $monthHeight = 0;
        if ($statsLogMonth) {
            foreach ($statsLogMonth as $itemStats) {
                if ($itemStats > $monthHeight) {
                    $monthHeight = $itemStats;
                }
            }
        }
        $countryHeight = 0;
        if ($statsLogCountry) {
            foreach ($statsLogCountry as $itemStats) {
                if ($itemStats > $countryHeight) {
                    $countryHeight = $itemStats;
                }
            }
        }

        foreach ($projectLogUser as $log) {
            $log->main_dates = LogsFunction::hideText($log->main_dates);
        }
        if ($all) {
            $balance = 0;
            $dashboard_user = User::all();
            foreach ($dashboard_user as $userItem) {
                $balance += $userItem->balance;
            }
            $dashboard_user->balance = $balance;
        } else {
            $dashboard_user = $this->user;
        }

        return view('dashboard', compact('dashboard_user', 'statsLogDays', 'statsLogMonth', 'statsLogCountry', 'projectLogUser', 'projectLogCountUser', 'daysHeight', 'monthHeight', 'countryHeight'));

    }
}
