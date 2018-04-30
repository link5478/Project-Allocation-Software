@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Sessions for Allocation</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
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
                    @foreach ($data as $d)
                        <div class="panel-body">
                            <a style= "font-size:150%;" href="{{route('coordinator.show.allocation', $d->id)}}"> {{$d->name}}  : </a> <br>
                            <a href="{{route('coordinator.allocation.finalise', $d->id)}}">Finalise</a>
                            <a href="{{route('coordinator.export', $d->id)}}">Export</a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection