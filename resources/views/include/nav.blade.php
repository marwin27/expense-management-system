@auth
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand font-weight-bold" style="color: #28a745;" href="{{ url('/') }}">
            Expense Manager
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link @if(Request::is('dashboard')) active @endif" href="{{ url('/dashboard') }}">
                        <i class="fa-solid fa-chart-line me-1"></i> Dashboard
                    </a>
                </li>
                
                {{-- Modified Expenses tab to light up when Expense Categories is selected --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle @if(Request::is('expenses') || Request::is('expenses/*') || Request::is('expensecategories')) active @endif" 
                       href="#" id="expensesDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-money-bill-wave me-1"></i> Expenses
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="expensesDropdown">
                        <li>
                            <a class="dropdown-item @if(Request::is('expenses')) active @endif" href="{{ route('expenses') }}">
                                All Expenses
                            </a>
                        </li>
                        <li>
                            @if (Auth::user()->role === 'Admin')
                            <a class="dropdown-item @if(Request::is('expensecategories')) active @endif" href="{{ route('expensecategories') }}">
                                Expense Categories
                            </a>
                            @endif
                        </li>
                    </ul>
                </li>
                
                @if (Auth::user()->role === 'Admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if(Request::is('users') || Request::is('roles')) active @endif" href="#" id="userManagementDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-users-cog me-1"></i> User Management
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userManagementDropdown">
                            <li>
                                <a class="dropdown-item @if(Request::is('users')) active @endif btn btn-outline-secondary" href="{{ route('users') }}">
                                    <i class="fa-solid fa-user me-1"></i> Manage Users
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item @if(Request::is('roles')) active @endif btn btn-outline-secondary" href="{{ route('roles') }}">
                                    <i class="fa-solid fa-user-tag me-1"></i> Manage Roles
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>

            <div class="ms-auto d-flex align-items-center">
                <span class="navbar-text me-3 text-light">
                    <i class="fa-solid fa-user me-1"></i> {{ Auth::user()->name }} ({{ Auth::user()->role }})
                </span>
                
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-cog"></i> Settings
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li>
                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="fa-solid fa-lock me-1"></i> Change Password
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-1"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

{{-- Change Password Modal --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('changePassword', Auth::user()->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endauth
