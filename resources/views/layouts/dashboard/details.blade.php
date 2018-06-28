<div class="card">
  <div class="card-header">
    <h5 >{{$ticket->name}}</h5>
  </div>
  <div class="card-body">
    <p class="card-text">{{$ticket->description}}</p>
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
    @if (Auth::user()->role == 'user')
        <a href="#" class="btn btn-primary">Go somewhere</a>
    @endif
  </div>
</div>
