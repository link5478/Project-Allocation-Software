<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [ 'fname', 'lname', 'email', 'password', 'is_student', 'is_supervisor', 'is_coordinator'];

    protected $hidden = [ 'remember_token'];

    public static function Projects($id)
    {
        return Project::all()->where('supervisor_id', '=', $id)->where('archived', '=', 0);
    }

    public static function ArchivedProjects($id)
    {
        return Project::all()->where('supervisor_id', '=', id)->where('archived', '=', 1);
    }

    public static function ChoicePerSession($id)
    {
        $session = courseSession::GetSession();

        if($session == null)
        {
            return null;
        }

        $choice = Choice::all()->where('session_id', '=', $session->id)->where('student_id', '=', $id)->last();

        return $choice;

    }
}
