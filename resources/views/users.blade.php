@extends('layout')
@section('title', 'Manage Users')
@section('content')
@auth
@if (session('success'))
<div class="alert alert-success py-3">
    <i class="fas ml-3 fa-check-circle fa-sm"></i>
    <span class="small w-100">{{ session('success') }}</span>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger py-3">
    <i class="fas fa-exclamation-circle fa-sm"></i>
    <strong class="small">There were some problems with your input:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li class="small w-100">{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="container-fluid px-5 py-5">

    @if (Auth::user()->role === 'Admin')
        <button type="button" class="btn btn-sm btn-primary ml-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="fa-solid fa-plus"></i> Add User
        </button>
    @endif

    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('createUser') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" id="role" name="role" required>
                                <option value="User">User</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>    

    <div class="card shadow mb-4 mt-5">
        <div class="card-header py-3 bg-dark ">
            <h6 class="m-0 font-weight-bold text-white">Manage Users</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                    <thead class="m-0 font-weight-bold ">
                        <tr>
                            <th><i class="fa-solid fa-user"></i> Name</th>
                            <th><i class="fa-solid fa-envelope"></i> Email</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>
                                    <a href="#" class="btn btn-primary btn-sm text-white edit-user" data-bs-toggle="modal" data-bs-target="#updateUserModal" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}" data-user-role="{{ $user->role }}">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form action="{{ route('deleteUser', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">
                                            <i class="fa-solid fa-trash"></i> Delete
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
</div>

<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('updateUser', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="update_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="update_name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="update_email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="update_role" class="form-label">Role</label>
                        <select class="form-select" id="update_role" name="role" required>
                            <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth
@endsection

