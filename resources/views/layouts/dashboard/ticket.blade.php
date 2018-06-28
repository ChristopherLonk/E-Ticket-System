<div class="ticket card" data-id="{{ $ticket->ext_id }}">
    <h5 class="card-header">{{$ticket->name}}</h5>
    <div class='card-body'>
        <p class="card-text">{{ str_limit($ticket->description,100,' ...')}}</p>
        @if($ticket->user_id)
            <p>{{$ticket->user()->name}}</p>
        @endif

        @switch ($ticket->priority)
            @case('Low')
                <span class="badge badge-pill badge-info">{{$ticket->priority}} </span>
                @break
            @case('Normal')
                <span class="badge badge-pill badge-success">{{$ticket->priority}} </span>
                @break
            @case('High')
                <span class="badge badge-pill badge-warning">{{$ticket->priority}} </span>
                @break
            @case('Urgent')
                <span class="badge badge-pill badge-danger">{{$ticket->priority}} </span>
                @break
        @endswitch
        <span class="badge badge-pill badge-info">{{$ticket->storyPoints}}</span>
        <div class="btn-group" role="group">
        <button type="button" data-id="{{$ticket->ext_id}}" class="details btn btn-info">Details</button>
        @auth
            @role('user')
                <button id="status" type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Status
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <button data-status="2" class="status-button dropdown-item">To Do</button>
                    <button data-status="3" class="status-button dropdown-item">Barrier</button>
                    <button data-status="4" class="status-button dropdown-item">In Progress</button>
                    <button data-status="5" class="status-button dropdown-item">Code Review</button>
                    <button data-status="6" class="status-button dropdown-item">Done</button>
                </div>
            @endrole
        @endauth
    </div>

    </div>
</div>
