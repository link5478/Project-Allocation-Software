@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">My Projects</div>

                    @foreach($data as $d)
                    <div class="panel-body">
                         <supervisor_project name="{{$d->name}}"></supervisor_project>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
