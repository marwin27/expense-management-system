@extends('layout')
@section('title', 'Expenses')
@section('content')
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

    <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
        <i class="fa-solid fa-plus me-1"></i> Add Expense
    </button>
    <div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExpenseModalLabel">Add Expense</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('storeExpense') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="expensecategory" class="form-label">Expense Category</label>
                            <select class="form-select" id="expensecategory" name="expensecategory" required>
                                <option value="" disabled selected>Select a category</option>
                                <option value="Travel">Travel</option>
                                <option value="Entertainment">Entertainment</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Expense</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-dark">
            <h6 class="m-0 font-weight-bold text-white">Manage Expenses</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="m-0 font-weight-bold">
                        <tr>
                            <th>Expense Category</th>
                            <th>Amount</th>
                            <th> <i class="fa-solid fa-calendar-days"></i> Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($expenses->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">No expenses found.</td>
                            </tr>
                        @else
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td>{{ $expense->expensecategory }}</td>
                                    <td>${{ number_format($expense->amount, 2) }}</td>
                                    <td>{{ $expense->date }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm text-white" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#updateExpenseModal{{ $expense->id }}">
                                            <i class="fa-solid fa-edit"></i> Edit
                                        </button>
                                        <div class="modal fade" id="updateExpenseModal{{ $expense->id }}" tabindex="-1" aria-labelledby="updateExpenseModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="updateExpenseModalLabel">Update Expense</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="{{ route('updateExpense', $expense->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mb-3">
                                                                <label for="expensecategory" class="form-label">Expense Category</label>
                                                                <select class="form-select" id="expensecategory" name="expensecategory" required>
                                                                    <option value="Travel" {{ $expense->expensecategory == 'Travel' ? 'selected' : '' }}>Travel</option>
                                                                    <option value="Entertainment" {{ $expense->expensecategory == 'Entertainment' ? 'selected' : '' }}>Entertainment</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="amount" class="form-label">Amount</label>
                                                                <input type="number" class="form-control" id="amount" name="amount" value="{{ $expense->amount }}" step="0.01" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="date" class="form-label">Date</label>
                                                                <input type="date" class="form-control" id="date" name="date" value="{{ $expense->date }}" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary">Update Expense</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
