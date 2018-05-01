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
use App;
use test\Mockery\AllowsExpectsSyntaxTest;


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
            $data['sessions'][$s->id]['invalid'] = $s->invalid;


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
                $allocation = TempAllocation::all()->where('session_id', '=', $session->id)->where('student_id', '=', $student)->first();
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

                if($allocation == null)
                {
                    $allocation = new TempAllocation();
                    $allocation->project_id = null;
                    $allocation->student_id = $student;
                    $allocation->session_id = $session->id;
                    $allocation->created_at = Carbon::now()->toDateTimeString();
                    $allocation->updated_at = Carbon::now()->toDateTimeString();
                    $allocation->finalised = 0;
                    $allocation->save();
                }
                else
                {
                    $allocation->updated_at = Carbon::now()->toDateTimeString();
                    $allocation->save();
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

        $allocations = TempAllocation::all()->where('session_id', '=', $session->id);
        foreach($allocations as $alloc)
        {
            if(!in_array($alloc->student_id, $students))
            {
                $alloc->delete();
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


                $allocation = new TempAllocation();
                $allocation->project_id = null;
                $allocation->student_id = $s;
                $allocation->session_id = $session->id;
                $allocation->created_at = Carbon::now()->toDateTimeString();
                $allocation->updated_at = Carbon::now()->toDateTimeString();
                $allocation->finalised = 0;
                $allocation->save();
            }
        }

        return Redirect::back()->with('message', 'Operation Successful!');
    }

    public function PickSession()
    {
        $sessions = courseSession::all()->where('invalid', '=', 0);
        return view('coordinator.sessioncheck')->with('sessions', $sessions);
    }

    public function UpdateAllocationView(Request $request, $session_id, $student_id)
    {
        $states = session('state');
        $state = $states[count($states)-1];

        $state[$student_id]['allocated'] = $request->input('project_id');
        array_push($states, $state);
        session(['state'=> $states]);

        return $this->AllocationView($session_id);
    }

    public function ApplyChanges($session_id)
    {
        $states = session('state');
        $state = $states[count($states)-1];

        foreach($state as $key=>$value)
        {
           $temp = TempAllocation::all()->where('student_id', '=', $value['id'])->
           where('session_id', '=', $session_id)->first();

           if($temp == null)
           {
               $temp = new TempAllocation();
               $temp->student_id = $value['id'];
               $temp->session_id = $session_id;
               $temp->created_at = Carbon::now()->toDateTimeString();
               $temp->finalised = 0;
           }

            $temp->project_id  = $value['allocated'] == 'None' ? null : $value{'allocated'};
            $temp->updated_at = $temp->created_at = Carbon::now()->toDateTimeString();

            $temp->save();
        }

        return Redirect('allocation')->with('message', 'Operation Successful');
    }

    public function AllocationView($session_id)
    {
        $session = courseSession::find($session_id);
        if ($session == null) {
            return view('error.session_invalid');
        }

        $projectList = Project::all()->where('session_id', '=', $session_id)->where('hidden', '=', 0);
        $studentList = User::all()->where('is_student', '=', 1);
        $data = [];
        $data['projects'] = [];
        $data['students'] = [];


        foreach ($projectList as $proj) {
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

        foreach ($studentList as $stud) {
            $choice = Choice::all()->where('student_id', '=', $stud->id)->where('session_id', '=', $session_id)->first();

            // we only want to add them if they are part of the current session.
            if ($choice != null) {

                $allocation = TempAllocation::all()->where('session_id', '=', $session_id)->where('student_id', '=', $stud->id)->first();


                $data['students'][$stud->id] = [];
                $data['students'][$stud->id]['id'] = $stud->id;
                $data['students'][$stud->id]['fname'] = $stud->fname;
                $data['students'][$stud->id]['lname'] = $stud->lname;
                $data['students'][$stud->id]['first'] = $projectList->find($choice->project1) == null ? 'None' : $projectList->find($choice->project1)->name;
                $data['students'][$stud->id]['second'] = $projectList->find($choice->project2) == null ? 'None' : $projectList->find($choice->project2)->name;
                $data['students'][$stud->id]['third'] = $projectList->find($choice->project3) == null ? 'None' : $projectList->find($choice->project3)->name;
                if($allocation == null)
                    $data['students'][$stud->id]['allocated'] = $allocation->project_id == null ? 'None' : $allocation->project_id;
                else
                    $data['students'][$stud->id]['allocated'] = 'None';

                $data['students'][$stud->id]['additional_info'] = $choice->additional_info;
            }
        }

        $state = session('state');
        if ($state == null) {
            $state = array();
            array_push($state, $data['students']);
            session(['state' => $state]);
        }

        if(count($state) > 0)
        {
            $state = $state[count($state)-1];
        }

        return view('coordinator.allocation')->with('data', $data)->with('state', $state)->with('session_id', $session_id);
    }

    public function finaliseAllocation($session_id)
    {
        $allocations = TempAllocation::all()->where('session_id', '=', $session_id);#
        foreach($allocations as $alloc)
        {
            $alloc->finalised = 1;
            $alloc->updated_at = Carbon::now()->toDateTimeString();
            $alloc->save();
        }
        return Redirect::back()->with('message', 'Operation Sucessful');
    }

    public function ShowSessionsForAllocation()
    {
        $sessions = courseSession::orderBy('id', 'desc')->get();

        return view('coordinator.sessioncheck')->with('data', $sessions);
    }


    public function invalidateSession($session_id){

        $session = courseSession::find($session_id);

        $session->invalid = !$session->invalid;

        $session->save();

        return Redirect::back()->with('message', 'Operation Successful!');

    }

    public function exportToPDF($session_id){

        /*
        * Plan for PDF
        *
        * Session Title
        * [
        * Project Title + Student name
        * ]
        * cycle
        *
        */

        $info = [];
        $info['students'] = [];

        $info['session_name'] = courseSession::find($session_id)->name;

        $students = User::where('is_student', '=', 1)->orderBy('lname', 'asc')->get();

        foreach($students as $student)
        {
            // see if student has an allocation
            $alloc = TempAllocation::all()->where('session_id', '=', $session_id)->where('student_id', '=', $student->id)
                ->where('project_id', '!=', null)->where('finalised', '=', 1) ->first();

            if($alloc != null)
            {
                $stud= [];
                $stud['name'] = $student->lname.', '.$student->fname;
                $project = Project::find($alloc->project_id);
                $stud['project_name'] = $project->name;
                array_push($info['students'], $stud);
            }
        }

        //dd($data);

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('coordinator.allocationPDF',compact('info'));
        return $pdf->stream();


    }

}
