<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Session;
use App\User;
use App\Choice;
use Illuminate\Support\Facades\Redirect;

class CoordinatorController extends Controller
{

    public function ShowSessions()
    {
        $sessions = Session::all();
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

                    $student['name'] = $vs->name;
                    $student['id'] = $vs->id;
                    array_push($data['sessions'][$s->id]['students'], $student);
                }
            }
        }

        $data['students'] = [];
        foreach($students as $s)
        {
            $student = [];
            $student['name'] = $s->name;
            $student['id'] = $s->id;
            array_push($data['students'], $student);
        }

        return view('coordinator.session')->with('data', $data);
    }

    public function UpdateSession(Request $request, Session $session)
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

        $session = new Session();
        $session->start = $request->input('start');
        $session->end = $request->input('end');
        $session->created_at = Carbon::now()->toDateTimeString();
        $session->updated_at = Carbon::now()->toDateTimeString();
        $session->name = $request->input('name');
        $session->invalid = 0;
        $session->save();

        foreach($students as $s)
        {
            if($s != "0") {
                $choice = new Choice();
                $choice->student_id = $s->id;
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
    }
}
