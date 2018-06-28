<a href="/sprint/create" type="button" class="btn btn-success">New Sprint</a>
<table class="table table-hover mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Project Name</th>
                <th>Name</th>
                <th>From</th>
                <th>to</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sprints as $sprint)
                <tr>
                    <td>{{ $sprint->project()->name }}</td>
                    <td>{{ $sprint->name }}</td>
                    <td>{{ $sprint->from }}</td>
                    <td>{{  $sprint->to }}</td>
                    <td>
                        <a href="/sprint/edit/{{ $sprint->ext_id }}" type="button" class="btn btn-info">Edit</a>
                        <button data-toggle="modal" data-target="#deleteSprint{{ $sprint->ext_id }}" type="button" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                <div class="modal fade" id="deleteSprint{{ $sprint->ext_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <a href="/sprint/delete/{{ $sprint->ext_id }}" type="button" class="btn btn-success">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
</table>
