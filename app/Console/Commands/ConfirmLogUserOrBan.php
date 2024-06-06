<?php

namespace App\Console\Commands;

use App\Models\ProjectLogs;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ConfirmLogUserOrBan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user_no_logs_ban:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_list = User::all();
        $first_log = ProjectLogs::all();
        foreach ($user_list as $user) {
            $first_log = ProjectLogs::where('telegram_id', $user->id_telegram)->first();
            if ($first_log === null && $user->banned == 0 && $user->confirm_status == 1) {
                $time_diff = $user->created_at->diffInHours(Carbon::now());
                if ($time_diff > 24) {
                    $user->banned = 1;
                    $user->save();
                    Log::info('User '.$user->name_telegram.' banned. Not logs after 24 hours');
                }
            }else {
                Log::info('Not find Users no logs');
                break;
            }
        }
    }
}
