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
                                    @php $student = $data['students'][$choice];
                                    $name = $student['fname'].' '.$student['lname'];
                                    $choice1 = 'Choice One: '.$student['first'];
                                    $choice2 = 'Choice Two: '.$student['second'];
                                    $choice3 = 'Choice Three: '.$student['third'];
                                    $additional_info = 'Additional Info: '.$student['additional_info'];
                                    @endphp
                                    <button type="button"
                                            @if($student['allocated'] == $key) class="buttonAllocated btn btn-xs " @else class="btn btn-xs buttonNotAllocated" @endif
                                            onclick="allocate('{{$student['id']}}', '{{$key}}');"
                                            data-html="true"
                                            data-toggle="tooltip"
                                            title="{{$name}} {{$choice1}} {{$choice2}} {{$choice3}} {{$additional_info}}">
                                            <b>{{substr($student['fname'], 0,1)}}.{{substr($student['lname'], 0,1)}} </b>
                                    </button>
                                @endforeach
                            </td>
                            <td>
                                @foreach($value['secondChoiceStudents'] as $choice)
                                    @php $student = $data['students'][$choice];
                                    $name = $student['fname'].' '.$student['lname'];
                                    $choice1 = 'Choice One: '.$student['first'];
                                    $choice2 = 'Choice Two: '.$student['second'];
                                    $choice3 = 'Choice Three: '.$student['third'];
                                    $additional_info = 'Additional Info: '.$student['additional_info'];
                                    @endphp
                                    <button type="button"
                                            @if($student['allocated'] == $key) class="btn btn-xs buttonAllocated" @else class="btn btn-xs buttonNotAllocated" @endif
                                            onclick="allocate('{{$student['id']}}', '{{$key}}');"
                                            data-html="true"
                                            data-toggle="tooltip"
                                            title="{{$name}} {{$choice1}} {{$choice2}} {{$choice3}} {{$additional_info}}">
                                        <b>{{substr($student['fname'], 0,1)}}.{{substr($student['lname'], 0,1)}} </b>
                                    </button>
                                @endforeach
                            </td>
                            <td>
                                @foreach($value['thirdChoiceStudents'] as $choice)
                                    @php $student = $data['students'][$choice];
                                    $name = $student['fname'].' '.$student['lname'];
                                    $choice1 = 'Choice One: '.$student['first'];
                                    $choice2 = 'Choice Two: '.$student['second'];
                                    $choice3 = 'Choice Three: '.$student['third'];
                                    $additional_info = 'Additional Info: '.$student['additional_info'];
                                    @endphp
                                    <button type="button"
                                            @if($student['allocated'] == $key) class="btn btn-xs buttonAllocated" @else class="btn btn-xs buttonNotAllocated" @endif
                                            onclick="allocate('{{$student['id']}}', '{{$key}}');"
                                            data-html="true"
                                            data-toggle="tooltip"
                                            title="{{$name}} {{$choice1}} {{$choice2}} {{$choice3}} {{$additional_info}}">
                                        <b>{{substr($student['fname'], 0,1)}}.{{substr($student['lname'], 0,1)}} </b>
                                    </button>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    function allocate(id, proj)
    {
        saveState();
    }

    function saveState()
    {
    }

    function undoState() {
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