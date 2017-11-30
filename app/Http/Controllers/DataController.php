<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Route;
use App\Http\Controllers\APIController;


class DataController extends Controller
{
    public function supervisorMyProjects()
    {
        $id = Auth::id();
        $api = new APIController();
        $data = $api->supervisorGetProjectsLocal($id);
        return view('supervisor.myprojects')->with('data', $data);
    }

    public function supervisorAddProjects()
    {
        return view('supervisor.addProjects');
    }

}