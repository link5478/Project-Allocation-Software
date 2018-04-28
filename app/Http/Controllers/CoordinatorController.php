<?php

namespace App\Http\Controllers;

use App\courseSession;
use App\TempAllocation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use App\Choice;
use App\Project;
use Illuminate\Support\Facades\Redirect;

class CoordinatorController extends Controller
{

    public function ShowSessions()
    {
        $sessions = courseSession::all();
        $students = User::all()->where('is_student', '=', 1);

        $data = [];
        $data['sessions'] = [];
        foreach($sessions as $s)
        {

            $data['sessions'][$s->id] = [];
            $data['sessions'][$s->id]['name'] = $s->name;
            $data['sessions'][$s->id]['start'] = Carbon::parse($s->start)->format('Y-m-d');
            $data['sessions'][$s->id]['end'] = Carbon::parse($s->end)->format('Y-m-d');
            $data['sessions'][$s->id]['students'] = [];

            $choicesPerSession = Choice::all()->where('session_id', '=', $s->id);
            foreach($choicesPerSession as $choice)
            {
                $validStudents = $students->where('id', '=', $choice->student_id);
                foreach($validStudents as $vs) {


                    $student = [];

                    $student['name'] = $vs->fname.' '.$vs->lname;
                    $student['id'] = $vs->id;
                    array_push($data['sessions'][$s->id]['students'], $student);
                }
            }
        }

        $data['students'] = [];
        foreach($students as $s)
        {
            $student = [];
            $student['name'] = $s->fname.' '.$s->lname;
            $student['id'] = $s->id;
            array_push($data['students'], $student);
        }
        return view('coordinator.session')->with('data', $data);
    }

    public function UpdateSession(Request $request, courseSession $session)
    {
        $session->fill($request->all());
        $session->updated_at = Carbon::now()->toDateTimeString();
        $session->save();

        $students = $request->input('student');

        foreach($students as $student)
        {
            if($student != "0") {
                $choice = Choice::all()->where('session_id', '=', $session->id)->where('student_id', '=', $student)->first();
                if ($choice == null)
                {
                    $choice = new Choice();
                    $choice->student_id = $student;
                    $choice->project1 = null;
                    $choice->project2 = null;
                    $choice->project3 = null;
                    $choice->additional_info = null;
                    $choice->session_id = $session->id;
                    $choice->created_at = Carbon::now()->toDateTimeString();
                    $choice->updated_at = Carbon::now()->toDateTimeString();
                    $choice->save();
                }
                else
                {
                    $choice->updated_at = Carbon::now()->toDateTimeString();
                    $choice->save();
                }
            }
        }

        $choices = Choice::all()->where('session_id', '=', $session->id);

        // if user has a choice but wasnt part of the list then we remove them.
        foreach($choices as $choice)
        {
            if(!in_array($choice->student_id, $students))
            {
                $choice->delete();
            }
        }

        return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function CreateSession(Request $request)
    {
        $students = $request->input('students');

        $session = new courseSession();
        $session->start = $request->input('start_date');
        $session->end = $request->input('end_date');
        $session->created_at = Carbon::now()->toDateTimeString();
        $session->updated_at = Carbon::now()->toDateTimeString();
        $session->name = $request->input('session_name');
        $session->invalid = 0;
        $session->save();

        foreach($students as $s)
        {
            if($s != "0") {
                $choice = new Choice();
                $choice->student_id = $s;
                $choice->project1 = null;
                $choice->project2 = null;
                $choice->project3 = null;
                $choice->additional_info = null;
                $choice->session_id = $session->id;
                $choice->created_at = Carbon::now()->toDateTimeString();
                $choice->updated_at = Carbon::now()->toDateTimeString();

                $choice->save();
            }
        }

        return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function PickSession()
    {
        $sessions = courseSession::all()->where('invalid', '=', 0);
        return view('coordinator.sessioncheck')->with('sessions', $sessions);
    }

    public function AllocationView($session_id)
    {

        $session = courseSession::find($session_id);
        if($session == null)
        {
            return view('error.session_invalid');
        }

        $projectList = Project::all()->where('session_id', '=', $session_id);
        $studentList = User::all()->where('is_student', '=', 1);
        $data = [];
        $data['projects'] = [];
        $data['students'] = [];


        foreach($projectList as $proj)
        {
            $data['projects'][$proj->id] = [];
            $data['projects'][$proj->id]['name'] = $proj->name;

            $firstChoice = [];
            $secondChoice = [];
            $thirdChoice = [];


            foreach ($studentList as $stud) {

                $choice = Choice::all()->where('student_id', '=', $stud->id)->where('session_id', '=', $session_id)->first();
                if ($choice == null)
                    continue;

                if ($choice->project1 == $proj->id) {
                    array_push($firstChoice, $stud->id);
                }

                if ($choice->project2 == $proj->id) {
                    array_push($secondChoice, $stud->id);
                }

                if ($choice->project3 == $proj->id) {
                    array_push($thirdChoice, $stud->id);
                }

            }

            $data['projects'][$proj->id]['firstChoiceStudents'] = $firstChoice;
            $data['projects'][$proj->id]['secondChoiceStudents'] = $secondChoice;
            $data['projects'][$proj->id]['thirdChoiceStudents'] = $thirdChoice;
        }

        foreach($studentList as $stud)
        {
            $choice = Choice::all()->where('student_id', '=', $stud->id)->where('session_id', '=', $session_id)->first();

            // we only want to add them if they are part of the current session.
            if($choice != null)
            {

                $allocation = TempAllocation::all()->where('session_id', '=', $session_id)->where('student_id', '=', $stud->id)->first();


                $data['students'][$stud->id] = [];
                $data['students'][$stud->id]['id'] = $stud->id;
                $data['students'][$stud->id]['fname'] = $stud->fname;
                $data['students'][$stud->id]['lname'] = $stud->lname;
                $data['students'][$stud->id]['first'] = $projectList->find($choice->project1) == null ? 'None' : $projectList->find($choice->project1)->name;
                $data['students'][$stud->id]['second'] = $projectList->find($choice->project2) == null ? 'None' : $projectList->find($choice->project2)->name;
                $data['students'][$stud->id]['third'] = $projectList->find($choice->project3) == null ? 'None' : $projectList->find($choice->project3)->name;
                $data['students'][$stud->id]['allocated'] = $allocation == null ? 'None' : $allocation->project_id;
                $data['students'][$stud->id]['additional_info'] = $choice->additional_info;
            }
        }

        return view('coordinator.allocation')->with('data', $data);
    }
}
