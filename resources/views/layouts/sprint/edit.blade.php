@extends('layouts.app')

@section('content')
    <form method="POST" action="/sprint/edit/{{ $sprint->ext_id }}">
        @csrf
        <div class="form-group">
            <label for="formGroupExampleInput">Sprint Name</label>
            <input type="text" class="form-control" name="name" placeholder="Sprint Name" value="{{ $sprint->name }}">
        </div>
        <div class="form-group">
            <label for="from">From</label>

            <input type="text" class="date form-control" name="from" placeholder="From" value="{{$sprint->from}}">
        </div>
        <div class="form-group">
            <label for="to">To</label>
            <input type="text" class="date form-control" name="to" placeholder="To" value="{{$sprint->to}}">
        </div>
        <div class="form-group">
            <label for="project">Project</label>
            <select class="form-control" name="project">
                @foreach ($projects as $project)
                    <option
                    @if ($project->id == $sprint->project_id)
                        selected
                    @endif
                    >{{ $project->name }}</option>
                @endForeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    @if($errors->any())
        <p>
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </p>
    @endif
@endsection
