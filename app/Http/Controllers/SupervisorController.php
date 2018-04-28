<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;
use App\courseSession;
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
        $supervisor = $project::Supervisor($project->supervisor_id);

        if($supervisor == null)
        {
            return null;
        }

        $toReturn = [];
        $toReturn['name'] = $project->name;
        $toReturn['description'] = $project->description;
        $toReturn['availability'] = $project->availability;
        $toReturn['hidden'] = $project->hidden;
        $toReturn['supervisor_name'] = $supervisor->fname.$supervisor->lname;
        $session = courseSession::find($project->session_id);
        $toReturn['session'] = $session->name;

        return view('supervisor.project')->with('data', $toReturn);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return view('supervisor.projects_edit')->with('project', $project);
    }

    public function update(Request $request, Project $project)
    {
        if(Auth::id() != $project->supervisor_id)
        {
            return redirect('home');
        }

        $project->fill($request->all());
        $project->session_id = $request->session_id;
        $project->updated_at = Carbon::now()->toDateTimeString();

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
        $project->session_id = $request->input('session_id');
        $project->archived = 0;
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
        $clone->updated_at = Carbon::now()->toDateTimeString();
        $clone->save();
        return Redirect::back()->with('message', 'Operation Successful !');
    }
}