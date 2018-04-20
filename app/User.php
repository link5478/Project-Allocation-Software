<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
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
