<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArchivedProject extends Model
{
    //
    public $timestamps = false;
    protected $fillable = ['name', 'description', 'availability', 'archived_by'];
}
