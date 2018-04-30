@extends('layouts.app')

@section('title', 'Add Project')

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
                <form action="{{ route('supervisor.projects.save')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="Name"
                               value="" required>
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                               placeholder="Description"
                               value="" required>
                    </div>


                    <div class="form-group{{ $errors->has('hidden') ? ' has-error' : '' }}">
                        <label for="hidden">Hidden</label>
                        <input type="text" class="form-control" id="hidden" name="hidden"
                               placeholder="0"
                               value="" required>
                    </div>

                    <div class="form-group{{ $errors->has('supervisor_id') ? ' has-error' : '' }}">
                        <label for="supervisor_id">Supervisor ID</label>
                        <input type="text" class="form-control" id="supervisor_id" name="supervisor_id"
                               value="{{Auth::user()->id}}" readonly required>
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