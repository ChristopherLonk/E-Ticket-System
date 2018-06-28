@extends('layouts.app')

@section('content')
    <form method="POST" action="/ticket/edit/{{ $ticket->ext_id }}">
        @csrf
        <div class="form-group">
            <label for="formGroupExampleInput">Ticket</label>
            <input type="text" class="form-control" name="name" placeholder="Ticket" value="{{ $ticket->name }}">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Description</label>
            <input type="text" class="form-control" name="description" placeholder="Description" value="{{ $ticket->description }}">
        </div>

        <div class="form-group">
            <label for="project">Status</label>
            <select class="form-control" name="status">
                @foreach ($stati as $status)
                    <option

                    @if ($status == $ticket->status)
                        selected
                    @endif
                    >{{ $status }}</option>
                @endForeach
            </select>
        </div>
        <div class="form-group">
            <label for="project">Priority</label>
            <select class="form-control" name="priority">
                @foreach ($priorities as $priority)
                    <option
                    @if ($priority == $ticket->priority)
                        selected
                    @endif
                    >{{ $priority }}</option>
                @endForeach
            </select>
        </div>
        <div class="form-group">
            <label for="project">Story Points</label>
            <select class="form-control" name="storyPoints">
                @foreach ($storyPoints as $storyPoint)
                    <option
                    @if ($storyPoint == $ticket->storyPoint)
                        selected
                    @endif

                    >{{ $storyPoint }}</option>
                @endForeach
            </select>
        </div>

        <div class="form-group">
            <label for="formGroupExampleInput">Project</label>
            <input type="text" class="form-control" name="project" placeholder="Project" value="{{ $ticket->project()->name }}" readonly>
        </div>

        @if($ticket->project()->method == 'Scrum')
        <div class="form-group">
            <label for="project">Sprint</label>
            <select class="form-control" name="sprint">
                @foreach($ticket->project()->sprint()->where('isDelete', NULL) as $sprint)
                    <option
                    @if ($sprint->id == $ticket->sprint_id)
                        selected
                    @endif

                    >{{ $sprint->name }}</option>
                @endforeach
            </select>
        </div>

        @endif

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
