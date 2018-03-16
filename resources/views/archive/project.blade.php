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
                    <div class="panel-heading" align="center">{{$data['name']}}</div>
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">Description</div>
                        <div class="panel-body" align="center">{{$data['description']}} </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">Availability</div>
                        <div class="panel-body" align="center">{{$data['availability']}}</div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading" align="center">Archived By</div>
                        <div class="panel-body" align="center">{{$data['supervisor_name']}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
