@extends('layouts.app')

@section('content')
    <form method="POST" action="/sprint/create">
        @csrf
        <div class="form-group">
            <label for="sprintName">Sprint Name</label>
            <input type="text" class="form-control" name="name" placeholder="Sprint Name">
        </div>
        <div class="form-group">
            <label for="from">From</label>

            <input type="text" class="date form-control" name="from" placeholder="From">
        </div>
        <div class="form-group">
            <label for="to">To</label>
            <input type="text" class="date form-control" name="to" placeholder="To">
        </div>
        <div class="form-group">
            <label for="project">Project</label>
            <select class="form-control" name="project">
                @foreach ($projects as $project)
                    <option>{{ $project->name }}</option>
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
