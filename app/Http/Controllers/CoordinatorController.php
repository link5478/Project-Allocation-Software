<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Session;
use App\User;
use App\Choice;

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
            $start = Carbon::parse($s->start);
            $end = Carbon::parse($s->end);

            $data['sessions'][$s->id] = [];
            $data['sessions'][$s->id]['start'] = $start->year. '-' .$start->month. '-' .$start->day;
            $data['sessions'][$s->id]['end'] = $end->year. '-' .$end->month. '-' .$end->day;
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

    public function UpdateSession(Request $request)
    {

    }

    public function CreateSession(Request $request)
    {
        if (empty($request->input('start'))) {
            return view('home');
        }

        if (empty($request->input('end'))) {
            return view('home');
        }

        if (empty($request->input('students'))) {
            return view('home');
        }

        $students = $request->input('students');

        $session = new Session();
        $session->start = $request->input('start');
        $session->end = $request->input('end');
        $session->created_at = Carbon::now()->toDateTimeString();
        $session->updated_at = Carbon::now()->toDateTimeString();
        $session->save();

        foreach($students as $s)
        {
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
