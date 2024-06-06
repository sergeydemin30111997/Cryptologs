<?php

namespace App\Http\Controllers\ProjectLogs;

use App\Models\ProjectLogs;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\v1\AbstractController as LogsFunction;
class LogsController extends AbstractController
{

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($all_project = false)
    {
        $referral = $this->user->getReferral($all_project);
        if ($all_project == 'all' && $this->user->can('view_all_logs')){
            $projectLogUser = ProjectLogs::orderBy('id', 'desc')->paginate(10)->onEachSide(1);
            foreach ($projectLogUser as $log) {
                $log->main_dates = LogsFunction::hideText($log->main_dates);
            }
        }elseif($referral) {
            $projectLogUser = ProjectLogs::where('telegram_id', $referral->id_telegram)->orderBy('id', 'desc')->paginate(10)->onEachSide(1);
        } else {
            $projectLogUser = ProjectLogs::where('telegram_id', $this->user->id_telegram)->orderBy('id', 'desc')->paginate(10)->onEachSide(1);
            foreach ($projectLogUser as $log) {
                $log->main_dates = LogsFunction::hideText($log->main_dates);
            }
        }
        return view('project_logs.index', compact('projectLogUser'));


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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
