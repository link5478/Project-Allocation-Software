@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Error!</div>
                    <div class="panel-body">
                        There is no active session.
                        Check with the course coordinator!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
