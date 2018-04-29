<?php

namespace App\Http\Controllers;

use App\courseSession;
use App\Interest;
use Illuminate\Http\Request;
use App\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Choice;
use Illuminate\Support\Facades\Redirect;
use App;

class StudentController extends Controller
{
    // Shows all relevant projects to the logged account.
    public function index()
    {
        if(courseSession::GetSession() == null)
        {
            return view('error.session_invalid');
        }

        $supervisors = User::all('id', 'fname', 'lname', 'is_supervisor')->where('is_supervisor','=', '1');
        $data = [];
        foreach($supervisors as $s)
        {
            $projects  = $s::Projects(auth::id())->where('hidden', '=', 0);
            $data[$s->fname.' '.$s->lname] = [];
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
                array_push($data[$s->fname.' '.$s->lname], $project);
            }
        }
        return view ('student.projects')->with('data', $data);

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

        if(courseSession::GetSession() == null)
        {
            return view ('error.session_invalid');
        }

        // valid sessions only.
        $sessions = courseSession::all()->where('invalid', '=', 0);

        // foreach valid session we want to see if the user has a choice associated with it. as in, did the coordinator add
        // them to the choices.

        $choices = [];
        foreach($sessions as $session)
        {
            // should only be 1 choice per user per session.
            $choice = Choice::all()->where('session_id', '=', $session->id)->where('student_id', '=', auth::id())->first();

            if($choice != null)
            {
                $data = [];
                $data['choice'] = $choice;
                $data['session'] = $session;

                array_push($choices, $data);
            }
        }
        $projects = Project::all('id', 'name', 'hidden')->where('hidden', '=', 0);

        return view('student.choices')->with('choices', $choices)->with('projects', $projects);


    }

    public function update(Request $request, Choice $choice)
    {
        $choice1 = $request->input('choice1');
        $choice2 = $request->input('choice2');
        $choice3 = $request->input('choice3');

        $choice->project1 = $choice1 == "0" ? null : $choice1;
        $choice->project2 = $choice2 == "0" ? null : $choice2;
        $choice->project3 = $choice3 == "0" ? null : $choice3;

        if (!empty($request->input('additional_info'))) {
            $choice->additional_info = $request->input('additional_info');
        }

        $choice->updated_at = Carbon::now()->toDateTimeString();
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


    public function exportProjectsPDF(){

        /*
       * Plan for PDF
       *
       * Session Title
       * [
       * Project Title
       * Project Supervisor name + email
       * Project Description
       * ]
       * cycle
       *
       */

        $session = courseSession::ValidSessions();
        $data = [];
        foreach($session as $s) {

            $choice = Choice::all()->where('session_id', '=', $s->id)->where('student_id', '=', Auth::id())->first();

            if($choice) {
                $projectList = Project::where('session_id', '=', $s->id)->orderBy('name', 'asc')->get();
                $data[$s->id]['session'] = $s->name;
                $data[$s->id]['projects'] = [];
                foreach ($projectList as $proj) {

                    $project = [];
                    $project['name'] = $proj->name;
                    $project['description'] = $proj->description;

                    $supervisor = User::find($proj->supervisor_id);
                    $project['supervisor_name'] = $supervisor->fname . ' ' . $supervisor->lname;
                    array_push($data[$s->id]['projects'], $project);
                }
            }
        }
    $info = $data[count($data)];

        //dd($info);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('student.pdf',compact('info'));
        return $pdf->stream();

    }
}