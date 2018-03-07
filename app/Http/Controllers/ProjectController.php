<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;

class ProjectController extends Controller
{
    // Shows all relevant projects to the logged account.
    public function index()
    {
        return view('projects.projects')->with('data', Project::all('id', 'name', 'description', 'supervisor_id'));
    }

    // Shows specific details on a project.
    public function show($id)
    {
        $project = Project::find($id);
        $supervisor = User::find($project->supervisor_ID);
        $data =[];
        $data['id'] = $project->id;
        $data['name'] = $project->name;
        $data['description'] = $project->description;
        $data['availability'] = $project->availability;
        $data['supervisor_id'] = $supervisor->id;
        $data['supervisor_name'] = $supervisor->name;

        return view('projects.project')->with('data', $data);
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return view('projects.projects_edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        if(Auth::user()->id != $project->supervisor_ID)
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
        $project->save();
        return Redirect::back()->with('message','Operation Successful !');
    }

    public function add()
    {
        return view('projects.projects_add');
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
        $project->save();

        return redirect(route('home'));
    }
}