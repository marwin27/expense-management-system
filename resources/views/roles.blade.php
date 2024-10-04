@extends('layout')
@section('title', 'Manage Roles')
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
            <i class="fa-solid fa-plus"></i> Add Role
        </button>
    @endif
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Add Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('addRole') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="displayname" class="form-label">Display Name</label>
                            <input type="text" class="form-control" id="displayname" name="displayname" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 mt-5">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-white">Manage Roles</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                    <thead class="m-0 font-weight-bold">
                        <tr>
                            <th>Display Name</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{ $role->displayname }}</td>
                            <td>{{ $role->description }}</td>
                            <td>{{ $role->created_at }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('updateRole', $role->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="displayname" class="form-label">Display Name</label>
                                                        <input type="text" class="form-control" id="displayname" name="displayname" value="{{ $role->displayname }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description" class="form-label">Description</label>
                                                        <input type="text" class="form-control" id="description" name="description" value="{{ $role->description }}" required>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Role</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleteRole', $role->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this role?');">
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
@endauth
@endsection
