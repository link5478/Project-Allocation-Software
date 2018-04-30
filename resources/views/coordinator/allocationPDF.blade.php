<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>

<style>
    p.wrap {
        word-wrap: break-word;
    }
</style>

<body>

<h2>
    <u>{{$info['session_name']}}</u> <br>
    <u>Allocation List</u>

</h2>

<br>

@php $students = $info['students'] @endphp

@foreach ($students as $s)

    <h3 class = "wrap">
        {{$s['name']}} :- {{$s['project_name'] }}
    </h3>
    <br>
@endforeach







</body>
</html>