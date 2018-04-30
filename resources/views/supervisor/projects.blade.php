@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">

                @if(count($errors))
                    <div class="alert alert-danger ">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (Session::has('message'))
                    <div class="alert alert-info alert-dismissible">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-primary">
                    <div class="panel-heading" align="center">My Projects</div>
                    <div class="panel panel-default">

                        @if (App\courseSession::GetSession() != null)
                            <div class="panel-heading" align="center">Want to add a new project? <a href="{{route('supervisor.projects.add')}}">Add</a></div>
                        @else
                            <div class="panel-heading" align="center">There are no active session for new projects</div>
                        @endif

                        @foreach ($data as $d)
                            <div class="panel-body">
                                <a style= "font-size:150%;" href="{{route('project', $d->id)}}"> {{$d->name}}  : </a> <br>
                                <a href="{{route('supervisor.projects.edit', $d->id)}}">Edit</a>
                                <a href="{{route('supervisor.projects.archive', $d->id)}}">Archive</a>
                                <a href="{{route('supervisor.projects.clone', $d->id)}}">Clone</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
