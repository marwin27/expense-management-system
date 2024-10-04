@extends('layout')
@section('title', 'Manage Expense Categories')
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
        <button type="button" class="btn btn-sm btn-primary ml-2 shadow-sm" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="fa-solid fa-plus"></i> Add Category
        </button>
    @endif
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Expense Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('storeCategory') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="expensecategory" class="form-label">Expense Category</label>
                            <input type="text" class="form-control" id="expensecategory" name="expensecategory" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <input type="text" class="form-control" id="description" name="description">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4 mt-5">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-white">Manage Expense Categories</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="inventoryTable" width="100%" cellspacing="0">
                    <thead class="m-0 font-weight-bold">
                        <tr>
                            <th>Expense Category</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->expensecategory }}</td>
                            <td>{{ $category->description }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#editCategoryModal-{{ $category->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <div class="modal fade" id="editCategoryModal-{{ $category->id }}" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editCategoryModalLabel">Edit Expense Category</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="POST" action="{{ route('updateCategory', $category->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-3">
                                                        <label for="expensecategory-{{ $category->id }}" class="form-label">Expense Category</label>
                                                        <input type="text" class="form-control" id="expensecategory-{{ $category->id }}" name="expensecategory" value="{{ $category->expensecategory }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description-{{ $category->id }}" class="form-label">Description</label>
                                                        <input type="text" class="form-control" id="description-{{ $category->id }}" name="description" value="{{ $category->description }}">
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Update Category</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form action="{{ route('deleteCategory', $category->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">
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
@endauth
@endsection
