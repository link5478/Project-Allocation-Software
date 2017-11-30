@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">

                @if(count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('api.projects.supervisor_add', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="Example Name" required>
                    </div>

                    <div class="form-group{{ $errors->has('desc') ? ' has-error' : '' }}">
                        <label for="desc">Description</label>
                        <input type="text" class="form-control" id="desc" name="desc"
                               placeholder="Example Description" required>
                    </div>

                    <div class="form-group{{ $errors->has('avail') ? ' has-error' : '' }}">
                        <label for="avail">Number of Avaailable</label>
                        <input type="text" class="form-control" id="avail" name="avail"
                               placeholder="10" required>
                    </div>

                    <div class="form-group{{ $errors->has('supervisorID') ? ' has-error' : '' }}">
                        <label for="supervisorID">supervisor ID</label>
                        <input type="text" class="form-control" id="supervisorID"
                               name="supervisorID"
                               value="{{Auth::id()}}" readonly required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Project</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
