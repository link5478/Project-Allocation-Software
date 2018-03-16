<?php
/**
 * Created by PhpStorm.
 * User: Delacarpet
 * Date: 15/03/2018
 * Time: 21:37
 */

namespace App\Http\Controllers;

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

class CoordinatorController extends Controller
{

    public function index()
    {
        $projects = Project::all();
        $data = [];
        foreach($projects as $p)
        {
            $choices1  = Choices::all()->where('project1', '=', $p->id);
            $choices2  = Choices::all()->where('project2', '=', $p->id);
            $choices3  = Choices::all()->where('project3', '=', $p->id);
            $data[$p->name]['choice1'] = [];

            $data[$p->name]['choice2'] = [];

            $data[$p->name]['choice3'] = [];



            // get all the students with the project as choice 1.
            foreach ($choices1 as $ch)
            {
                $student = User::all()->where('id', '=', $ch->id)->first();
                $info = 'No additional information was given';
                if($ch->additional_info != false or $ch->additional_info != '')
                {
                    $info = $ch->additional_info;
                }
                $entry = ["name" => $student->name, "info" => $info];

                array_push($data[$p->name]['choice1'], $entry);
            }

            foreach ($choices2 as $ch)
            {
                $student = User::all()->where('id', '=', $ch->id)->first();
                $info = 'No additional information was given';
                if($ch->additional_info != false or $ch->additional_info != '')
                {
                    $info = $ch->additional_info;
                }
                $entry = ["name" => $student->name, "info" => $info];

                array_push($data[$p->name]['choice2'], $entry);

            }

            foreach ($choices3 as $ch)
            {
                $student = User::all()->where('id', '=', $ch->id)->first();
                $info = 'No additional information was given';
                if($ch->additional_info != false or $ch->additional_info != '')
                {
                    $info = $ch->additional_info;
                }
                $entry = ["name" => $student->name, "info" => $info];

                array_push($data[$p->name]['choice3'], $entry);
            }
        }




        return view('coordinator.allocation')->with('data', $data);
    }
}