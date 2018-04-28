<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'availability', 'hidden', 'supervisor_id', 'archived', 'session_id'];

    public static function Supervisor($id)
    {
        return User::find($id);
    }
}
