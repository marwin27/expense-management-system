@extends('layout')
@section('title', 'Login')
@section('content')
<div class="container-fluid vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; border-radius: 10px;">
        <h4 class="text-center mb-4 " style="color: #28a745;"><i class="fa-solid fa-money-bill"></i> Expense Manager</h4>

        @if (session('success'))
        <div class="alert alert-success py-2">
            <i class="fas fa-check-circle fa-sm"></i>
            <span class="small w-100">{{ session('success') }}</span>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger py-2">
            <i class="fas fa-exclamation-circle fa-sm"></i>
            <strong class="small">There were some problems with your input:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card-body">
            <form method="POST" action="{{ url('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label  fw-bold"><i class="fa-solid fa-envelope"></i> Email address</label>
                    <input type="email" name="email" class="form-control " id="email" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label  fw-bold"><i class="fa-solid fa-lock"></i> Password</label>
                    <input type="password" name="password" class="form-control " id="password" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary btn-block mb-3"><i class="fa-solid fa-right-to-bracket"></i> Login</button>
                    {{-- <a href="" class="text-center ">Forgot Password?</a> --}}
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
