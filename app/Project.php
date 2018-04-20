<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'availability', 'hidden', 'supervisor_id', 'archived'];

    public function Supervisor()
    {
        return User::find($this->supervisor_id);
    }
}
