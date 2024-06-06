<?php

namespace App\Http\Controllers\DemoProject;

use App\Models\DemoProject;
use App\Models\RequestDemoProject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class DemoProjectController extends AbstractController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demo_project = DemoProject::all();
        return view('demo_project.index' , compact('demo_project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$this->user->can('demo_project_crud')) {
            return redirect(404);
        }
        $statusCreate = DemoProject::createProject($request);
        if ($statusCreate) {
            return redirect(route('demo_project.index'));
        }
        return back()->with('message', 'Мало параметров для создания, попробуйте ещё');
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
        if (!$this->user->can('demo_project_crud')) {
            return redirect(404);
        }
        $statusUpdate = DemoProject::updateProject($request, $id);
        if ($statusUpdate) {
            return redirect(route('demo_project.index'));
        }
        return back()->with('message', Lang::get('demo_project.invalid_param'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!$this->user->can('demo_project_crud')) {
            return redirect(404);
        }
        $demo_project = DemoProject::find($id);
        $request_demo_project = RequestDemoProject::where('demo_project_id', $demo_project->id)->first();
        if ($request_demo_project) {
            return back()->with('message', Lang::get('demo_project.error_delete'));
        }
        DemoProject::find($id)->delete();
        return redirect(route('demo_project.index'));
    }
}
