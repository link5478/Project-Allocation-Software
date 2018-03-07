@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">My Projects</div>
                    @foreach($data as $d)
                        {{--<a href="{{route('projects', ['id' => $d->id])}}">{{$d->name}} </a>--}}
                        {{$d->name}}
                        {{$d->description}}
                        @if($d->supervisor_id == Auth::user()->id)
                            <a href="{{route('projects.edit', $d->id)}}">Edit</a>
                        @endif
                        <br>
                    @endforeach
                    @if(Auth::user()->is_supervisor == 1)
                        <a href="{{route('projects.add')}}">Add</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
