<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Project extends Model
{
    //
    protected $fillable = ['name', 'description', 'availability', 'hidden', 'supervisor_id'];

}
