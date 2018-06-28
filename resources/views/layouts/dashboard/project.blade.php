@foreach ($tickets as $key => $value)
<div class="col mt-3">
    <h5>{{ucfirst($key)}}</h5>
    @foreach ($value as $ticket)
        @include('layouts.dashboard.ticket')
    @endforeach
</div>
@endforeach
<div class="col-4 col-details"></div>
