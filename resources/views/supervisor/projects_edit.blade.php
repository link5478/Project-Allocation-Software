@extends('layouts.app')

@section('title', 'Edit Your Project')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>@yield('title')</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                @if(count($errors))
                    <div class="alert alert-danger">
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
            <div class="col-md-4">
                <form action="{{ route('supervisor.projects.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="{{$project->name}}"
                               value="{{ $project->name }}">
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                               placeholder="{{$project->description}}"
                               value="{{ $project->description }}">
                    </div>

                    <div class="form-group{{ $errors->has('hidden') ? ' has-error' : '' }}">
                        <label for="hidden">Hidden (0 = visible, 1 = hidden)</label>
                        <input type="text" class="form-control" id="hidden" name="hidden"
                               placeholder="0"
                               value="{{$project->hidden}}" required>
                    </div>

                    <div class="form-group">
                        <label for="session_id">Session</label>
                        <select class="form-control" name="session_id" id = "session_id">
                            @foreach(App\courseSession::ValidSessions() as $session)
                                <option value="{{$session->id}}">{{$session->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Project</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection