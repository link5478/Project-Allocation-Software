<?php

namespace App\Http\Controllers;


use App\ArchivedProject;
use App\Interest;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Choices;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use function Symfony\Component\VarDumper\Dumper\esc;

class StudentController extends Controller
{
    // Shows all relevant projects to the logged account.
    public function index()
    {
        $supervisors = User::all('id', 'name', 'is_supervisor')->where('is_supervisor','=', '1');
        $data = [];
        foreach($supervisors as $s)
        {
            $projects  = Project::all('id', 'name', 'description', 'supervisor_id')->where('supervisor_id', '=', $s->id)->where('hidden', '=', 0);
            $data[$s->name] = [];
            foreach($projects as $p)
            {
                $interest = Interest::all()->where('student_id', '=', Auth::id())->where('project_id', '=', $p->id)->first();
                $is_interested = false;
                // if we have an interest entry, we want to look at it.
                if($interest != null)
                {
                    if($interest->project_id == $p->id)
                    {
                        $is_interested = true;
                    }
                }
                $project = ['project_id' => $p->id, 'name'=> $p->name, 'description' => $p->description, 'interested' => $is_interested];
                array_push($data[$s->name], $project);
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

    public function addInterest($id)
    {
        $interested = Interest::all()->where('project_id', '=', $id)->where('student_id', '=',Auth::id())->first();
        if($interested == null)
        {
            $interested = new Interest();
            $interested->project_id = $id;
            $interested->student_id = Auth::id();
            $interested->created_at = Carbon::now();
            $interested->updated_at = Carbon::now();
            $interested->save();
            return Redirect::back();
        }
        else
        {
            $interested->delete();
            return Redirect::back();
        }
    }

    public function viewChoices()
    {
        // should only be one choice really.
        $choices = Choices::all()->where('student_id', '=', auth::id())->first();
        $projects = Project::all('id', 'name', 'hidden')->where('hidden', '=', 0);

        return view('student.choices')->with('choice', $choices)->with('projects', $projects);
    }

    public function update(Request $request, Choices $choice)
    {

        if(Auth::id() != $choice->student_id)
        {
            return redirect('home');
        }
        $choice->project1 = $request->input('choice1');
        $choice->project2 = $request->input('choice2');
        $choice->project3 = $request->input('choice3');

        if (!empty($request->input('additional_info'))) {
            $choice->additional_info = $request->input('additional_info');
        }

        $choice->save();
        return Redirect::back()->with('message', 'Operation Successful !');
    }

    public function interested_toggle(Request $request)
    {
        if($request->session()->has('interested'))
        {
            $request->session()->put('interested', !$request->session()->get('interested'));
        }
        else
        {
            $request->session()->put('interested', true);
        }
        return Redirect::back();
    }
}