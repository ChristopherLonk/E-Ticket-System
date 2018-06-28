@extends('layouts.app')

@section('content')

<div class="row mt-4">
    <div class="col-2">
        <div class="list-group" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active" id="list-project-list" data-toggle="list" href="#list-project" role="tab" aria-controls="project">Project</a>
            <a class="list-group-item list-group-item-action" id="list-sprint-list" data-toggle="list" href="#list-sprint" role="tab" aria-controls="sprint">Sprint</a>
            <a class="list-group-item list-group-item-action" id="list-ticket-list" data-toggle="list" href="#list-ticket" role="tab" aria-controls="ticket">Ticket</a>
        </div>
    </div>

    <div class="col-8">
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="list-project" role="tabpanel" aria-labelledby="list-project-list">
                @include('layouts.create.project')
            </div>

            <div class="tab-pane fade" id="list-sprint" role="tabpanel" aria-labelledby="list-sprint-list">
                @include('layouts.create.sprint')
            </div>

            <div class="tab-pane fade" id="list-ticket" role="tabpanel" aria-labelledby="list-ticket-list">
                @include('layouts.create.ticket')
            </div>
        </div>
    </div>
</div>
@endsection
