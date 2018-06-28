@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-1">
            <div class="dropdown">
                <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Project
                </button>
                <div class="dropdown-menu">
                    @foreach ($projects as $project)
                        <button  class="project dropdown-item" data-id="{{ $project->ext_id }}" data-method="{{ $project->method }}" type="button">{{$project->name}}</button>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-1 sprint">

        </div>
    </div>
    <div class="row dashboard">
    </div>
@endsection
