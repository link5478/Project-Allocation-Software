<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = ['student_id', 'project_id', 'session_id'];

    public function Student()
    {
        return User::find($this->student_id);
    }

    public function Project()
    {
        return Project::find($this->project_id);
    }

    public function Session()
    {
        return Session::find($this->session_id);
    }
}
