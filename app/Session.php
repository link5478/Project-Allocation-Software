<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Session extends Model
{
    protected $fillable = ['start', 'end', 'invalid'];

    // slow probably.
    public static function GetSession()
    {
        $now = Carbon::now()->toDateTimeString();
        $session = Session::all()->where('start', '<',$now)->where('end', '>',
            $now)->first();

        if($session == null)
            return null;
        else
            return $session->id;
    }
}
