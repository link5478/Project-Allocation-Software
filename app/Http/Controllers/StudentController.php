<?php

namespace App\Http\Controllers;


use App\ArchivedProject;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Choices;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    // Shows all relevant projects to the logged account.
    public function index()
    {
        $supervisors = User::all('id', 'name', 'is_supervisor')->where('is_supervisor','=', '1');
        $choice = $this->currentUserChoice();
        $data = [];
        foreach($supervisors as $s)
        {
            $projects  = Project::all('id', 'name', 'description', 'supervisor_id')->where('supervisor_id', '=', $s->id);
            $data["'".$s->name."'"] = [];
            foreach($projects as $p)
            {
                $is_choice = 'No';

                if($choice->project1 == $p->id)
                {
                    $is_choice = 'No';
                }
                else if($choice->project2 == $p->id)
                {
                    $is_choice = 'No';
                }
                else if($choice->project3 == $p->id)
                {
                    $is_choice = 'No';
                }
                $project = ['project_id' => $p->id, 'name'=> $p->name, 'description' => $p->description, 'is_choice' => $is_choice];
                array_push($data["'".$s->name."'"], $project);
            }
        }


        return view ('student.projects')->with('data', $data);

    }

    public function add($id)
    {
        $project = Project::find($id);

    }

    public function delete($id)
    {
    }

    // for now will only return 1 choice.
    public function currentUserChoice()
    {
        $current = Choices::all()->where('student_id', '=', Auth::id())->first();
        if ($current == null)
        {
            $Choices = new Choices();
            $Choices->student_id = Auth::id();
            $Choices->project1 = null;
            $Choices->project2 = null;
            $Choices->project3 = null;
            $Choices->additional_info = null;
            $Choices->created_at = Carbon::now();
            $Choices->updated_at = Carbon::now();
            return $Choices;
        }
        return $current;
    }
}