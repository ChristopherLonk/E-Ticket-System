@extends('layouts.app')

@section('content')
    <div class="container">
        <a class="btn btn-success" href="/user/create">New User</a>
        <table class="table table-striped table-dark mt-3">
                <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">method</th>
                        <th scope="col">Role</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>

                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->roles[0]->name }}</td>
                            <td>
                                <a href="/user/edit/{{ $user->ext_id }}" type="button" class="btn btn-info">Edit</a>
                                <button data-toggle="modal" data-target="#deleteModal{{ $user->ext_id }}" type="button" class="btn btn-danger">Delete</button>
                            </td>
                        </tr>
                        <div class="modal fade" id="deleteModal{{ $user->ext_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <a href="/user/delete/{{ $user->ext_id }}" type="button" class="btn btn-success">Yes</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </tbody>
        </table>
    </div>
@endsection
