<div class="row">
    <div class="col">
        <div class="dropdown">
            <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Sprint
            </button>
            <div class="dropdown-menu">
                @foreach ($sprints as $sprint)
                    <button  class="project dropdown-item sprint-button" data-id="{{ $sprint->ext_id }}" type="button">{{$sprint->name}}</button>
                @endforeach
            </div>
        </div>
    </div>
</div>
