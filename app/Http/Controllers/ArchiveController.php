<?php

namespace App\Http\Controllers;


use App\ArchivedProject;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;

class ArchiveController extends Controller
{
    // Shows all relevant projects to the logged account.
    public function index()
    {
        $projects  = ArchivedProject::all('id', 'name');
        return view('archive.projects')->with('data', $projects);
    }

    public function show($id)
    {
        $project = ArchivedProject::find($id);
        $supervisor = User::find($project->archived_by);
        $toReturn = [];
        $toReturn['name'] = $project->name;
        $toReturn['description'] = $project->description;
        $toReturn['availability'] = $project->availability;
        $toReturn['id'] = $project->id;
        $toReturn['supervisor_name'] = $supervisor->name;
        return view('archive.project')->with('data', $toReturn);
    }

    public function restore($id)
    {
        $archived = ArchivedProject::find($id);
        $project = new Project();

        $project->name = $archived->name;
        $project->description = $archived->description;
        $project->hidden = '1';
        $project->availability = $archived->availability;
        $project->supervisor_ID = Auth::user()->id;

        $project->save();

        // Delete archived project with
        $archived->delete();


        return redirect(route('archive.projects'))->with('message', 'Operation Successful !');
    }
}