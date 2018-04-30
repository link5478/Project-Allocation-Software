@extends('layouts.app')

@section('title', 'Project List')


<style>
    p.wrap {
        word-wrap: break-word;
    }
</style>


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

                <a href="{{ route('export.projects') }}">Export to PDF</a>


        </div>


        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel-group" id="accordion">
                   @foreach($data as $key=>$value)
                       Session : {{$value['name']}}
                        @foreach($value['supervisor'] as $sup)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#{{$sup['id'].$key}}">{{$sup['name']}}</a>
                                    </h4>
                                </div>
                                <div id="{{$sup['id'].$key}}" class="panel-collapse collapse in">
                                   @foreach($sup['projects'] as $val)
                                       @if(Session::has('interested') and Session::get('interested') and $val['interested'] != 1)
                                           @continue
                                        @endif
                                       <div class="card card-body"></div>
                                        <h4 class="card-title">{{$val['name']}}
                                            @if($val['interested'] == 1)
                                                <a href="{{route('student.add_interest', $val['id'])}}">
                                                    <span class="glyphicon glyphicon-star" aria-hidden="true"></span>
                                                </a>
                                            @else
                                                <a href="{{route('student.add_interest', $val['id'])}}">
                                                    <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>
                                                </a>
                                            @endif
                                        </h4>
                                        <p class="card-text wrap" >
                                            {{$val['description']}}
                                            <br>
                                        </p>

                                   @endforeach
                                </div>
                            </div>
                        @endforeach
                   @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
