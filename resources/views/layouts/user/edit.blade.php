@extends('layouts.app')

@section('content')
    <form method="POST" action="/user/edit/{{ $user->ext_id }}">
        @csrf
        <div class="form-group">
            <label for="formGroupExampleInput">User Name</label>
            <input type="text" class="form-control" name="name" placeholder="User Name" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput">Email</label>
            <input type="text" class="form-control" name="email" placeholder="Email" value="{{ $user->email }}">
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Password</label>
            <input id="password" type="password" class="form-control" name="password" >
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Confirm Password</label>
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >
        </div>
        <div class="form-group">
            <label for="formGroupExampleInput2">Role</label>
                <select class="form-control" name="role">
                    <option
                        @if($user->roles[0]->name == 'user')
                            selected
                        @endif
                    >user</option>
                    <option
                        @if($user->roles[0]->name == 'teamleader')
                            selected
                        @endif
                    >teamleader</option>
                    <option
                        @if($user->roles[0]->name == 'admin')
                            selected
                        @endif
                    >admin</option>
                </select>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
    @if($errors->any())
        <p>
            <ul class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </p>
    @endif
@endsection
