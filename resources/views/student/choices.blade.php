@extends('layouts.app')

@section('title', 'Project Choices')

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

        <div class="alert alert-warning">
            <strong>Warning!</strong> Please don't pick choices by the same supervisor. Mix it up!
        </div>
        @foreach($choices as $ch)
            <p> Session: {{$ch['name']}}</p>
            <div class="row">
                <div class="col-md-4">
                    <form action="{{ route('student.choices.update', $ch['choice']) }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="form-group">
                            <label for="choice1">Choice 1</label>
                            <select class="form-control" id="choice1" name="choice1">
                                <option value="0">None</option>
                                @foreach($ch['projects'] as $proj)
                                    <option value="{{$proj['id']}}" @if($proj['id'] == $ch['choice']->project1) selected @endif>
                                        {{$proj['name']}}
                                    </option>
                                @endforeach
                            </select>

                            <label for="choice2">Choice 2</label>
                            <select class="form-control" id="choice2" name="choice2">
                                <option value="0">None</option>
                                @foreach($ch['projects'] as $proj)
                                    <option value="{{$proj['id']}}" @if($proj['id'] == $ch['choice']->project2) selected @endif>
                                        {{$proj['name']}}
                                    </option>
                                @endforeach
                            </select>

                            <label for="choice3">Choice 3</label>
                            <select class="form-control" id="choice3" name="choice3">
                                <option value="0">None</option>
                                @foreach($ch['projects'] as $proj)
                                    <option value="{{$proj['id']}}" @if($proj['id'] == $ch['choice']->project3) selected @endif>
                                        {{$proj['name']}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="additional_info">Comment:</label>
                            <textarea class="form-control" rows="5" id="additional_info" name="additional_info">{{$ch['choice']->additional_info}}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Choices</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="alert alert-warning">
            If you're having issues please contact the Project Coordinator: Keith Edwards at "kjedwards@dundee.ac.uk" <br>
            If you're trying to submit your project choices late, please contact the Project Coordinator
        </div>
    </div>

@endsection