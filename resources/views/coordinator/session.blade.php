@extends('layouts.app')

@section('content')
    <div class="container">
        @foreach ($data['sessions'] as $key=>$value)


        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('coordinator.sessions.update', $key)}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}
                    <label for="name">Session Name</label>
                    <input type="text" name="name" id="name" value="{{$value['name']}}" required>

                    <div class="form-group row">
                        <label for="start">Start Date</label>
                        <input class="form-control" id="start"  name="start" type="date" value="{{$value['start']}}" required>
                        <label for="end">End Date</label>
                        <input class="form-control" id="end"  name="end" type="date" value="{{$value['end']}}" required>
                    </div>

                    <div class="form-group row">
                        <label for="students">Students</label>
                        <select class="form-control" id="student" name="student[]" multiple>
                            <option value="0">None</option>
                            @foreach($data['students'] as $s)
                                <option value="{{$s['id']}}"   @if(in_array($s, $value['students'])) selected @endif>
                                    {{$s['name']}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
        @endforeach
        <div class="panel panel-default">
            <div class="panel-body">
                <form action="{{ route('coordinator.sessions.create')}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                    {{ csrf_field() }}
                    <label for="session_name">Session Name</label>
                    <input type="text" name="session_name" id="session_name" value="" required>

                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input id="start_date"  name="start_date" type="date" value="" required>
                        <label for="end_date">End Date</label>
                        <input id="end_date"  name="end_date" type="date" value="" required>
                    </div>

                    <div class="form-group">
                        <label for="students">Students</label>
                        <select class="form-control" id="students" name="students[]" multiple>
                            <option value="0">None</option>
                            @foreach($data['students'] as $s)
                                <option value="{{$s['id']}}">
                                    {{$s['name']}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
@endsection