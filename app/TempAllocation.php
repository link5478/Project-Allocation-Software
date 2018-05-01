<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempAllocation extends Model
{
    //
    protected $fillable = ['student_id', 'session_id', 'project_id', 'finalised'];
}
