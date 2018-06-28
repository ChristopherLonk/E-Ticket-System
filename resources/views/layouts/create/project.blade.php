<a href="/project/create" type="button" class="btn btn-success">New Project</a>
<table class="table table-hover mt-3">
        <thead class="thead-dark">
            <tr>
                <th>Name</th>
                <th>method</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->method }}</td>
                    <td>
                        <a href="/project/edit/{{ $project->ext_id }}" type="button" class="btn btn-info">Edit</a>
                        <button data-toggle="modal" data-target="#deleteProject{{ $project->ext_id }}" type="button" class="btn btn-danger">Delete</button>
                    </td>
                </tr>
                <div class="modal fade" id="deleteProject{{ $project->ext_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <a href="/project/delete/{{ $project->ext_id }}" type="button" class="btn btn-success">Yes</a>
                            </div>
                        </div>
                    </div>
                </div>

            @endforeach
        </tbody>
</table>
