<?php
/**
 * Created by PhpStorm.
 * User: Carsten
 * Date: 23/11/2017
 * Time: 17:05
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class APIController
{

    /**
     * Returns a list of projects assigned to a supervisor
     *
     * /api/projects/101
     *
     * @param Request $request
     * @return $this
     */
    public function supervisorGetProjects(Request $request)
    {
        return $this->supervisorGetProjectsLocal($request->supervisorID);
    }

    public function supervisorGetProjectsLocal($id)
    {
        return DB::table('projects')
            ->select('id', 'name')
            ->where('supervisor_ID', '=', $id)
            ->get();
    }

    /**
     * Inserts a Project entry into the database
     *
     * /api/projects/add
     *
     * @param Request $request
     * @return $this
     */
    public function supervisorAddProject(Request $request)
    {
        return $this->supervisorAddProjectLocal($request->name, $request->desc, $request->avail, $request->supervisorID);
    }

    public function supervisorAddProjectLocal($name, $desc, $avail, $supervisorID)
    {
        DB::table('projects')->insert(
            ['name' => $name,
                'description' => $desc,
                'availability' => $avail,
                'supervisor_ID' => $supervisorID]
        );
        return redirect('/supervisor/projects');
    }




}