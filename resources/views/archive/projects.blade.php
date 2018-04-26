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
                    <div class="panel-heading" align="center">Archived Projects</div>
                    <div class="panel panel-default">
                        @if(count($data) > 0)
                            @foreach ($data as $d)
                                <div class="panel-body">
                                    <a href="{{route('archive.project', $d->id)}}"> {{$d->name}} </a>
                                    <a href="{{route('archive.projects.restore', $d->id)}}">Restore</a>
                                </div>
                            @endforeach
                        @else
                            <div class="panel-body">
                                No Archived Projects
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
