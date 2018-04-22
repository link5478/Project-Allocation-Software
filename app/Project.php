<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'availability', 'hidden', 'supervisor_id', 'archived'];

    public static function Supervisor($id)
    {
        return User::find($id);
    }
}
