<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Carbon;

class ArchiveController extends Controller
{
    // Shows all relevant projects to the logged account.
    public function index()
    {
        $projects  = Project::all('id', 'name')->where('archived', '=', 1);
        return view('archive.projects')->with('data', $projects);
    }

    public function show($id)
    {
        $project = Project::find($id);

        if($project == null)
        {
            return null;
        }

        $supervisor = $project::Supervisor();

        if($supervisor == null)
        {
            return null;
        }

        $toReturn = [];
        $toReturn['name'] = $project->name;
        $toReturn['description'] = $project->description;
        $toReturn['availability'] = $project->availability;
        $toReturn['supervisor_name'] = $supervisor->name;

        return $toReturn;
    }

    public function restore($id)
    {
        $archived = Project::find($id);

        if($archived == null)
        {
            return redirect(route('archive.projects'))->with('error', 'Something went wrong. Try again!');
        }
        $archived->supervisor_id = Auth::user()->id;
        $archived->archived = 0;
        $archived->updated_at = Carbon::now();

        $archived->save();


        return redirect(route('archive.projects'))->with('message', 'Operation Successful !');
    }
}