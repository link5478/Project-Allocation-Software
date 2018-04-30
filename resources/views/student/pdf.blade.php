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
        <u>{{$info['session']}}</u> <br>
        <u>Project List</u>

    </h2>

    <br>

    @php $projects = $info['projects'] @endphp

    @foreach ($projects as $proj)

        <h3 class = "wrap">
            <u>{{$proj['name']}}</u>
        </h3>
        <h4>
            Supervisor: {{$proj['supervisor_name']}} <br>
            Email Address: {{$proj['email']}}
        </h4>
        <p class = "wrap">
            {{$proj['description']}}

        </p>
        <br>
        @endforeach







</body>
</html>