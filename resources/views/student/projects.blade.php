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

        <div>
            @if(Session()->has('interested') and Session()->get('interested')==1)
                <h3>To unfilter interests, click <a href="{{route('interest_toggle')}}">here</a></h3>
            @else
                <h3>Want to show interested only? Click <a href="{{route('interest_toggle')}}">here</a></h3>
            @endif
        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel-group" id="accordion">
                   @foreach($data as $key=>$value)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#{{$key}}">{{$key}}</a>
                                </h4>
                            </div>
                            <div id="{{$key}}" class="panel-collapse collapse in">
                               @foreach($value as $val)
                                   @if(Session::has('interested') and Session::get('interested') and $val['interested'] != 1)
                                       @continue
                                    @endif
                                   <div class="card card-body"></div>
                                       <h4 class="card-title"><a href="{{route('project', $val['project_id'])}}">{{$val['name']}}</a>
                                        @if($val['interested'] == 1)
                                            <a href="{{route('student.add_interest', $val['project_id'])}}">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                            </a>
                                        @else
                                            <a href="{{route('student.add_interest', $val['project_id'])}}">
                                                <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                                            </a>
                                        @endif
                                    </h4>
                               @endforeach
                            </div>
                        </div>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
