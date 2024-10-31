@extends('layouts.admin.master')

@section('title', 'Manage Users')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4" style="margin-top: 20px;">
                <h6 class="mb-4">Manage Users</h6>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Create New User
                </a>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role->name }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" style="color: #5bc0de;">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block; margin-left: 10px;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="border: none; background: none; color: #d9534f;" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <style>
a:hover i.fa-edit, button:hover i.fa-trash {
    transform: scale(1.2); /* Scale icon to 120% of its original size */
}

a i.fa-edit, button i.fa-trash {
    transition: transform 0.3s ease; /* Smooth transition effect */
}

    </style>
@endsection
