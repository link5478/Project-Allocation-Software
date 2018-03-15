<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choices extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['student_id', 'project1', 'project2', 'project3', 'additional_info'];
}
