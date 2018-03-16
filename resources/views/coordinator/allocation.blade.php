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

        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">Project Name</th>
                <th scope="col">First Choice</th>
                <th scope="col">Second Choice</th>
                <th scope="col">Third Choice</th>
            </tr>
            </thead>
            <tbody>
                @foreach($data as $key=>$value)
                    <tr>
                        <th scope="row">{{$key}}</th>

                        <!-- Choice 1 -->
                        <td>
                            @php
                                $choices = $value['choice1'];
                            @endphp
                            @foreach($choices as $choice)
                                <a href="#" data-toggle="tooltip" title="{{$choice['info']}}">{{$choice['name']}}</a>
                                <br>
                            @endforeach
                        </td>

                        <!-- Choice 2 -->
                        <td>
                            @php
                                $choices = $value['choice2'];
                            @endphp
                            @foreach($choices as $choice)
                                <a href="#" data-toggle="tooltip" title="{{$choice['info']}}">{{$choice['name']}}</a>
                                <br>
                            @endforeach
                        </td>

                        <!-- Choice 3 -->
                        <td>
                            @php
                                $choices = $value['choice3'];
                            @endphp
                            @foreach($choices as $choice)
                                <a href="#" data-toggle="tooltip" title="{{$choice['info']}}">{{$choice['name']}}</a>
                                <br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
