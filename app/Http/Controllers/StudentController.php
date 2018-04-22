<?php

namespace App\Http\Controllers;

use App\Interest;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Choice;
use App\Session;
use Illuminate\Support\Facades\Redirect;

class StudentController extends Controller
{
    // Shows all relevant projects to the logged account.
    public function index()
    {
        if(Session::GetSession() == null)
        {
            return view('error.session_invalid');
        }


        $supervisors = User::all('id', 'name', 'is_supervisor')->where('is_supervisor','=', '1');
        $data = [];
        foreach($supervisors as $s)
        {
            $projects  = $s::Projects(auth::id())->where('hidden', '=', 0);
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

    // for now will only return 1 choice.
    public function currentUserChoice()
    {
        $current = Choice::all()->where('student_id', '=', Auth::id())->where('session_id', '=', Session::GetSession())->first();
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
        if(Session::GetSession() == null)
        {
            return view ('error.session_invalid');
        }

        // should only be one choice really.
        $choices = Choice::all()->where('student_id', '=', auth::id())->first();
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

        $choice->updated_at = Carbon::now();
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