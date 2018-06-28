<a href="/ticket/create" type="button" class="btn btn-success">New Ticket</a>
<table class="example table table-hover mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Project Name</th>
                <th>Sprint Name</th>
                <th>Ticket</th>
                <th>User Name</th>
                <th>Created From</th>
                <th>Status</th>
                <th>Story Points</th>
                <th>Priority</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->project()->name }}</td>
                    @if(!empty($ticket->sprint()->name))
                        <td>{{ $ticket->sprint()->name }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ str_limit($ticket->name,100,' ...') }}</td>
                    @if(!empty($ticket->user()->name))
                        <td>{{ $ticket->user()->name }}</td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $ticket->createFrom()->name }}</td>

                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->storyPoints }}</td>
                    <td>{{ $ticket->priority }}</td>

                    <td>
                        <a href="/ticket/edit/{{ $ticket->ext_id }}" type="button" class="btn btn-info">Edit</a>
                        <button data-toggle="modal" data-target="#deleteTicket{{ $ticket->ext_id }}" type="button" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                <div class="modal fade" id="deleteTicket{{ $ticket->ext_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Are you Sure</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                <a href="/ticket/delete/{{ $ticket->ext_id }}" type="button" class="btn btn-success">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
</table>
