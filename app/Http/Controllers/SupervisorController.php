<?php

namespace App\Http\Controllers;


use App\ArchivedProject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;
use App\Session;
use Illuminate\Support\Facades\Redirect;

class SupervisorController extends Controller
{
    // Shows all relevant projects to the logged account.
    public function index()
    {
        $projects  = Project::all('id', 'name', 'hidden', 'supervisor_id', 'archived')->where('supervisor_id', '=', Auth::id())->where('archived', '=', 0);
        return view('supervisor.projects')->with('data', $projects);
    }

    public function show($id)
    {
        $project = Project::find($id);
        if($project == null)
        {
            return null;
        }
        $supervisor = $project::Supervisor(auth::id());

        if($supervisor == null)
        {
            return null;
        }

        $toReturn = [];
        $toReturn['name'] = $project->name;
        $toReturn['description'] = $project->description;
        $toReturn['availability'] = $project->availability;
        $toReturn['hidden'] = $project->hidden;
        $toReturn['supervisor_name'] = $supervisor->name;

        return view('supervisor.project')->with('data', $toReturn);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return view('supervisor.projects_edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        if(Auth::id() != $project->supervisor_id)
        {
            return redirect('home');
        }

        if (!empty($request->input('name')))
        {
            $project->name = $request->input('name');
        }
        if (!empty($request->input('description')))
        {
            $project->description = $request->input('description');
        }
        if (!empty($request->input('availability'))) {
            $project->availability = $request->input('availability');
        }

        if($request->has('hidden'))
        {
            $project->hidden = '1';
        }
        else
        {
            $project->hidden = '0';
        }

        $project->updated_at = Carbon::now()->toDateTimeString();
        $project->updated_at = Carbon::now()->toDateTimeString();
        $project->session_id = Session::GetSession();

        $project->save();
        return redirect(route('supervisor.projects'))->with('message', 'Operation Successful !');
    }

    public function add()
    {
        return view('supervisor.projects_add');
    }

    public function store(Request $request)
    {
        if(empty($request->input('name')) or empty($request->input('description')) or
            empty($request->input('availability')) or empty($request->input('hidden')))
        {
           // return Redirect::back()->with('message','Operation Failed. !');
        }

        $project = new Project();
        $project->fill($request->all());
        $project->session_id = Session::GetSession();
        $project->created_at = Carbon::now()->toDateTimeString();
        $project->updated_at = Carbon::now()->toDateTimeString();
        $project->save();

        return redirect(route('supervisor.projects'))->with('message', 'Operation Successful !');
    }

    public function archive($id)
    {
        $project = Project::find($id);

        if($project == null)
        {
            return Redirect::back()->with('error', 'Something went wrong. Try again!');
        }

        $project->supervisor_id = auth::id();
        $project->archived = 1;

        $project->save();
        return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function clone($id)
    {
        $project = Project::find($id);
        $clone = new Project();
        $clone->name = 'COPY - ' .$project->name;
        $clone->description = $project->description;
        $clone->availability = $project->availability;
        $clone->hidden = '1';
        $clone->supervisor_id= $project->supervisor_id;
        $clone->session_id = $project->session_id;
        $clone->save();
        return Redirect::back()->with('message', 'Operation Successful !');
    }
}