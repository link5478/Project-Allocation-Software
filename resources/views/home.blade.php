@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p>
                            @if(\App\courseSession::GetSession())
                                Current Session: {{App\courseSession::GetSession()->name}}<br>
                                Start Date: {{Carbon\Carbon::parse(App\courseSession::GetSession()->start)->toDateString()}}<br>
                                End Date: {{Carbon\Carbon::parse(App\courseSession::GetSession()->end)->toDateString()}}<br>
                            @endif
                        <br>
                        You are a:
                        @auth
                            @if(Auth::user()->is_supervisor == 1)
                                <br> <u>SUPERVISOR</u>
                                <br> Projects that you wish to oversee this session can be created and modified under "My Projects"
                                <br> You may archive projects, or retrieve archived projects from "Archived Projects"

                            @endif
                            <br>
                            @if(Auth::user()->is_student == 1)
                                <br> <u>STUDENT</u>
                                <br> You can select which projects you would like to do which can be found under "My Choices"
                                <br> A list of all projects can be found under the "View Projects" header

                            @endif
                            <br>
                            @if(Auth::user()->is_coordinator == 1)
                                <br> <u>PROJECT COORDINATOR</u>
                                <br> A project session can be created under "Session". A session must be created in order for students to make their project choices
                                <br> Additionally students will have to be added to a session manually
                                <br> Allocating projects to students can be done using the Allocation tool found under "Allocation"

                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection