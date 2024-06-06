<?php

namespace App\Http\Controllers\DemoProject;

use App\Http\Controllers\Controller;
use App\Models\DemoProject;
use App\Models\RequestDemoProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class RequestDemoProjectController extends AbstractController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ($this->user->can('demo_project_crud')) {
            $request_demo_projects = RequestDemoProject::all();
            $demo_project = DemoProject::all();
        }else{
            $request_demo_projects = RequestDemoProject::where('telegram_id', $this->user->id_telegram)->get();
            $demo_project = DemoProject::all();
        }
        return view('demo_project.request.index', compact('request_demo_projects', 'demo_project'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $demo_projects = DemoProject::all();
        $data_user = $this->user;
        $data_user->payment_desc = json_decode($data_user->payment_desc);
        return view('demo_project.request.create', compact('demo_projects', 'data_user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = $this->user->id_telegram;
        $request_demo_project = RequestDemoProject::createRequestProject($request, $user_id);
        return redirect(route('request_demo_project.index'));
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
        $request_demo_project = RequestDemoProject::find($id);
        if ($request_demo_project->telegram_id == $this->user->id_telegram || $this->user->can('demo_project_crud'))
        {
            $request_demo_project->delete();
            return back()->with('message', Lang::get('request_demo_project.message_destroy'));
        }
        return back()->with('message', Lang::get('request_demo_project.error_message_destroy'));
    }
}
