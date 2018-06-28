@extends('layouts.app')

@section('content')
    <form method="POST" action="/ticket/create">
        @csrf
        <div class="form-group">
            <label for="ticketName">Ticket Name</label>
            <input type="text" class="form-control" name="name" placeholder="Ticket Name">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <input type="text" class="form-control" name="description" placeholder="description">
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
