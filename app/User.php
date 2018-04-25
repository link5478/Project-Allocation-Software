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
}
