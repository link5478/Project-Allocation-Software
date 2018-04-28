<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class courseSession extends Model
{
    protected $fillable = ['name', 'start', 'end', 'invalid'];

    // slow probably.
    public static function GetSession()
    {
        $now = Carbon::now()->toDateTimeString();
        $session = courseSession::all()->where('start', '<', $now)->where('end', '>',
            $now)->last();

        if ($session == null)
            return null;
        else
            return $session;
    }

    public static function ValidSessions()
    {
        return courseSession::all()->where('invalid', '=', 0);
    }
}
