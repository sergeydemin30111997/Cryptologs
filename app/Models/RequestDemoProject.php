<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RequestDemoProject extends Model
{

    /**
     * @return string
     */
    public function getDemoProject($id)
    {
        return DemoProject::find($id);
    }

    /**
     * @return string
     */
    public function getUser($telegram_id)
    {
        return User::where('id_telegram', $telegram_id)->first();
    }

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     */
    protected $table = 'request_demo_project';

    protected $casts = [
        'wallets' => 'array'
    ];
    public static function createRequestProject(Request $request, $telegram_id) {
        $request_demo_project = new self();
        if ($request->domain) {
            $request_demo_project->domain = $request->domain;
        }
        if ($request->demo_project_id) {
            $request_demo_project->demo_project_id = $request->demo_project_id;
        }
        $request_demo_project->telegram_id = $telegram_id;
        $isFullNullWallet = true;
        if ($request->wallets) {
            $request_demo_project->wallets = $request->wallets;
        }
        if ($request->message) {
            $request_demo_project->message = $request->message;
        }
        $request_demo_project->save();
        return true;
    }
}
