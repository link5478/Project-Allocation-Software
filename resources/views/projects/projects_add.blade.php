@extends('layouts.app')

@section('title', 'Add Project')

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
                <form action="{{ route('projects.save')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="Name"
                               value="">
                    </div>

                    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                               placeholder="Description"
                               value="">
                    </div>


                    <div class="form-group{{ $errors->has('hidden') ? ' has-error' : '' }}">
                        <label for="hidden">Hidden</label>
                        <input type="text" class="form-control" id="hidden" name="hidden"
                               placeholder="0"
                               value="">
                    </div>

                    <div class="form-group{{ $errors->has('availability') ? ' has-error' : '' }}">
                        <label for="availability">Availability</label>
                        <input type="text" class="form-control" id="availability" name="availability"
                               placeholder="10"
                               value="">
                    </div>

                    <div class="form-group{{ $errors->has('supervisor_id') ? ' has-error' : '' }}">
                        <label for="supervisor_id">Supervisor ID</label>
                        <input type="text" class="form-control" id="supervisor_id" name="supervisor_id"
                               value="{{Auth::user()->id}}" readonly>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Project</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection