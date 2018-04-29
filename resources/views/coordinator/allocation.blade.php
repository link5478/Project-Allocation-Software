@php
    $states = [];
    array_push($states, $data['students']);
@endphp


@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Project Allocation</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>

                    <table class="table table-striped">
                        <tr>
                            <th>Project Name</th>
                            <th>First Choice</th>
                            <th>Second Choice</th>
                            <th>Third Choice</th>
                        </tr>
                        @foreach($data['projects'] as $key=>$value)
                        <tr>
                            <td>{{$value['name']}}</td>
                            <td>
                                @foreach($value['firstChoiceStudents'] as $choice)
                                    @php $student = $state[$choice];
                                    $name = $student['fname'].' '.$student['lname'];
                                    $choice1 = 'Choice One: '.$student['first'];
                                    $choice2 = 'Choice Two: '.$student['second'];
                                    $choice3 = 'Choice Three: '.$student['third'];
                                    $additional_info = 'Additional Info: '.$student['additional_info'];
                                    @endphp

                                    <form action="{{ route('coordinator.allocation.update.view', [$session_id, $student['id']])}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <button type="submit" name="project_id" id="button-{{$student['id']}}-first"
                                                value="{{$student['allocated']}}"
                                                @if($student['allocated'] == $key) class="buttonAllocated btn btn-xs " @else class="btn btn-xs buttonNotAllocated" @endif
                                                onclick="allocate('first','{{$student['id']}}', '{{$key}}');"
                                                data-html="true"
                                                data-toggle="tooltip"
                                                title="{{$name}} {{$choice1}} {{$choice2}} {{$choice3}} {{$additional_info}}">
                                                <b>{{substr($student['fname'], 0,1)}}.{{substr($student['lname'], 0,1)}} </b>
                                        </button>
                                    </form>

                                @endforeach
                            </td>
                            <td>
                                @foreach($value['secondChoiceStudents'] as $choice)
                                    @php $student = $state[$choice];
                                    $name = $student['fname'].' '.$student['lname'];
                                    $choice1 = 'Choice One: '.$student['first'];
                                    $choice2 = 'Choice Two: '.$student['second'];
                                    $choice3 = 'Choice Three: '.$student['third'];
                                    $additional_info = 'Additional Info: '.$student['additional_info'];
                                    @endphp

                                    <form action="{{ route('coordinator.allocation.update.view', [$session_id, $student['id']])}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <button type="submit" name="project_id" id="button-{{$student['id']}}-second"
                                                value="{{$student['allocated']}}"
                                                @if($student['allocated'] == $key) class="buttonAllocated btn btn-xs " @else class="btn btn-xs buttonNotAllocated" @endif
                                                onclick="allocate('second','{{$student['id']}}', '{{$key}}');"
                                                data-html="true"
                                                data-toggle="tooltip"
                                                title="{{$name}} {{$choice1}} {{$choice2}} {{$choice3}} {{$additional_info}}">
                                            <b>{{substr($student['fname'], 0,1)}}.{{substr($student['lname'], 0,1)}} </b>
                                        </button>
                                    </form>

                                @endforeach
                            </td>
                            <td>
                                @foreach($value['thirdChoiceStudents'] as $choice)
                                    @php $student = $state[$choice];
                                    $name = $student['fname'].' '.$student['lname'];
                                    $choice1 = 'Choice One: '.$student['first'];
                                    $choice2 = 'Choice Two: '.$student['second'];
                                    $choice3 = 'Choice Three: '.$student['third'];
                                    $additional_info = 'Additional Info: '.$student['additional_info'];
                                    @endphp

                                    <form action="{{ route('coordinator.allocation.update.view', [$session_id, $student['id']])}}" method="POST" enctype="multipart/form-data" class="form-horizontal">
                                        {{ csrf_field() }}
                                        <button type="submit" name="project_id" id="button-{{$student['id']}}-third"
                                                value="{{$student['allocated']}}"
                                                @if($student['allocated'] == $key) class="buttonAllocated btn btn-xs " @else class="btn btn-xs buttonNotAllocated" @endif
                                                onclick="allocate('third','{{$student['id']}}', '{{$key}}');"
                                                data-html="true"
                                                data-toggle="tooltip"
                                                title="{{$name}} {{$choice1}} {{$choice2}} {{$choice3}} {{$additional_info}}">
                                            <b>{{substr($student['fname'], 0,1)}}.{{substr($student['lname'], 0,1)}} </b>
                                        </button>
                                    </form>

                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <form action="{{route('coordinator.allocation.apply', $session_id)}}" method="POST">
                        {{ csrf_field() }}
                        <button type="submit">Apply Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>

    {{--id="button-{{$student['id']}}-first"--}}
    function allocate(choice, id, proj)
    {
        //Or a short way to swap classes
       //$("#button-" + id + "-" + choice).toggleClass('buttonAllocated buttonNotAllocated');
        if($("#button-" + id + "-" + choice).attr('value') !== proj) {
            $("#button-" + id + "-" + choice).attr('value', proj);
        }
        else
        {
            $("#button-" + id + "-" + choice).attr('value', 'None');
        }
    }

</script>

<style>
    .buttonAllocated {
        color:green;
    }
    .buttonNotAllocated {
        color:red;
    }
</style>