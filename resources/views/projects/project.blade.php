@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"><h1>{{$data['name']}}</h1></div>
                    <h2> Description</h2>
                    <p>{{$data['description']}} </p>

                    <h2> Availability</h2>
                    <p>{{$data['availability']}} </p>

                    <h2>Supervisor</h2>
                    <p>{{$data['supervisor_name']}}</p>

                    @if ($data['supervisor_id'] == Auth::user()->id)
                        <a href="{{route('supervisor.edit', $data['id'])}}">Edit</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
