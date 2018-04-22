<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [ 'name', 'email', 'password', 'is_student', 'is_supervisor', 'is_coordinator'];

    protected $hidden = [ 'remember_token'];

    public function Projects()
    {
        return Project::all()->where('supervisor_id', '=', $this->id)->where('archived', '=', 0);
    }

    public function ArchivedProjects()
    {
        return Project::all()->where('supervisor_id', '=', $this->id)->where('archived', '=', 1);
    }
}
