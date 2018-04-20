<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $fillable = ['student_id', 'project1', 'project2', 'project3', 'additional_info', 'session_id'];

    /**
     * @return Project Object or Null if none was found.
     */
    public function Project1()
    {
        return Project::find($this->project1);
    }

    /**
     * @return Project Object or Null if none was found.
     */
    public function Project2()
    {
        return Project::find($this->project2);
    }

    /**
     * @return Project Object or Null if none was found.
     */
    public function Project3()
    {
        return Project::find($this->project3);
    }

    /**
     * @return User Object or Null if none was found.
     */
    public function Student()
    {
        return User::find($this->student_id);
    }

    /**
     * @return Session Object. A session should always exist.
     */
    public function Session()
    {
        return Session::find($this->session_id);
    }
}
