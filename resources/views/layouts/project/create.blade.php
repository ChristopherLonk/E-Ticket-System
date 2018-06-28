@extends('layouts.app')

@section('content')
    <form method="POST" action="/project/create">
        @csrf
        <div class="form-group">
            <label for="formGroupExampleInput">Project Name</label>
            <input type="text" class="form-control" name="name" placeholder="Project Name">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">method</label>
            <select class="form-control" name="method">
                <option>Scrum</option>
                <option>Kanban</option>
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
